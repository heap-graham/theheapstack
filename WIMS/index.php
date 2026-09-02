<?php
// --- FILE VIEWER MECHANISM (MUST RUN BEFORE ANY HTML IS OUTPUT) ---
if (isset($_GET['view_file'])) {
    $fileToView = urldecode($_GET['view_file']);
    
    // Security sanitisation: Prevent directory traversal hacking (e.g., ../../../etc/passwd)
    $realBase = realpath('.');
    $realUserFile = realpath($fileToView);

    if ($realUserFile && strpos($realUserFile, $realBase) === 0 && is_file($realUserFile)) {
        $extension = strtolower(pathinfo($realUserFile, PATHINFO_EXTENSION));

        // Define headers based on file type to stop automatic downloads
        switch ($extension) {
            case 'txt':
            case 'log':
            case 'ini':
            case 'conf':
                header('Content-Type: text/plain; charset=utf-8');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'pdf':
                header('Content-Type: application/pdf');
                // inline forces browser viewing instead of attachment download
                header('Content-Disposition: inline; filename="' . basename($realUserFile) . '"');
                break;
            default:
                // Fallback for code files (css, js, sql, json) to display as plain text
                header('Content-Type: text/plain; charset=utf-8');
                break;
        }
        
        readfile($realUserFile);
        exit; // Terminate execution so the explorer HTML doesn't append to the file view
    } else {
        die("Error: Access denied or file does not exist.");
    }
}

// --- SAVE TREE TO FILE MECHANISM ---
if (isset($_GET['save_tree'])) {
    $baseDir = realpath('.');
    $lines = saveTreeListing($baseDir, $baseDir);
    file_put_contents('directory_tree.txt', implode(PHP_EOL, $lines) . PHP_EOL);
    header('Location: index.php?tree_saved=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure PHP Directory Tree & Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; }
        .toc-container { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px; }
        h1 { font-size: 24px; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .scroll-box { max-height: 500px; overflow-y: auto; overflow-x: hidden; border: 1px solid #ddd; padding: 15px; background: #fafafa; border-radius: 4px; }
        ul { list-style-type: none; padding-left: 20px; margin: 5px 0; }
        li { margin: 6px 0; }
        .folder-link { color: #0066cc; font-weight: bold; text-decoration: none; display: inline-block; }
        .folder-link::before { content: "▶ "; font-size: 11px; color: #666; margin-right: 5px; display: inline-block; }
        .folder-link.open-folder::before { content: "▼ "; }
        .file-link { text-decoration: none; color: #333; padding-left: 16px; display: inline-block; }
        .file-link:hover { color: #0066cc; text-decoration: underline; }
    </style>
</head>
<body>

<div class="toc-container">
    <h1>Pure PHP Project Explorer</h1>
    <p style="font-size: 13px; color: #666; margin-top: -10px; margin-bottom: 20px;">
        Click folders to expand. Click files to view them directly in a new tab.
    </p>

    <?php if (isset($_GET['tree_saved'])): ?>
        <p style="color: green; font-size: 13px;">✅ Tree saved to directory_tree.txt</p>
    <?php endif; ?>

    <a href="index.php?save_tree=1" style="display:inline-block; margin-bottom:15px; padding:6px 12px; background:#0066cc; color:#fff; text-decoration:none; border-radius:4px; font-size:13px;">
        💾 Save Tree to File
    </a>
    
    <div class="scroll-box">
        <?php
        $openDirParam = isset($_GET['open_dir']) ? $_GET['open_dir'] : '';

        function buildDirectoryArray($dir) {
            if (!is_dir($dir)) return [];
            $result = [];
            $items = array_diff(scandir($dir), array('.', '..'));
            foreach ($items as $item) {
                $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
                if ($fullPath === '.' . DIRECTORY_SEPARATOR . 'index.php') continue; 
                if (is_dir($fullPath)) {
                    $result[$item] = buildDirectoryArray($fullPath);
                } else {
                    $result[] = $fullPath;
                }
            }
            return $result;
        }

        function saveTreeListing($dir, $baseDir, &$lines = []) {
            if (!is_dir($dir)) return $lines;
            $items = array_diff(scandir($dir), array('.', '..'));

            foreach ($items as $item) {
                $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
                if ($fullPath === '.' . DIRECTORY_SEPARATOR . 'index.php') continue;

                // Path relative to the parent/base directory
                $relativePath = ltrim(str_replace($baseDir, '', $fullPath), DIRECTORY_SEPARATOR);
                $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

                if (is_dir($fullPath)) {
                    $lines[] = "[DIR]  $relativePath";
                    saveTreeListing($fullPath, $baseDir, $lines);
                } else {
                    $lines[] = "[FILE] $relativePath";
                }
            }

            return $lines;
        }

        function renderDirectoryHTML($array, $currentPath = '', $openDirParam = '') {
            echo "<ul>";
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $folderVirtualPath = $currentPath ? $currentPath . '/' . $key : $key;
                    $safeFolder = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                    $isOpen = ($openDirParam === $folderVirtualPath || strpos($openDirParam, $folderVirtualPath . '/') === 0);
                    $nextUrlParam = $isOpen ? '' : urlencode($folderVirtualPath);
                    $arrowClass = $isOpen ? 'open-folder' : '';

                    echo "<li>";
                    echo "<a class='folder-link $arrowClass' href='index.php?open_dir=$nextUrlParam'>$safeFolder/</a>";
                    if ($isOpen) {
                        renderDirectoryHTML($value, $folderVirtualPath, $openDirParam); 
                    }
                    echo "</li>";
                } else {
                    $filePath = $value;
                    $fileName = basename($filePath);
                    $safePath = htmlspecialchars($filePath, ENT_QUOTES, 'UTF-8');
                    $safeName = htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8');
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                    // Execute web scripts directly, route data files through our viewer
                    if ($extension === 'html' || $extension === 'htm' || $extension === 'php') {
                        echo "<li><a class='file-link' href='$safePath'>🌐 $safeName</a></li>";
                    } else {
                        // Route non-web files into our inline custom PHP viewer script
                        $viewUrl = 'index.php?view_file=' . urlencode($filePath);
                        echo "<li><a class='file-link' href='$viewUrl' target='_blank'>📄 $safeName</a></li>";
                    }
                }
            }
            echo "</ul>";
        }

        $directoryData = buildDirectoryArray('.'); 
        if (empty($directoryData)) {
            echo "<p style='color: #888; font-style: italic;'>The directory is empty.</p>";
        } else {
            renderDirectoryHTML($directoryData, '', $openDirParam);
        }
        ?>
    </div>
</div>

</body>
</html>