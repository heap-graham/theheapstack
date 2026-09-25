<?php

/*
 * OPW00 - POP
 * OPW Filesystem Discovery
 */

$opwRoot = __DIR__;

$directories = [];
$files = [];


/*
 * Discover the complete OPW filesystem
 */
function discoverOPW($directory, $root, &$directories, &$files)
{
    $items = scandir($directory);

    foreach ($items as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {

            $relativePath = str_replace(
                $root . DIRECTORY_SEPARATOR,
                '',
                $path
            );

            $directories[] = $relativePath;

            discoverOPW(
                $path,
                $root,
                $directories,
                $files
            );

        } elseif (is_file($path)) {

            $relativePath = str_replace(
                $root . DIRECTORY_SEPARATOR,
                '',
                $path
            );

            $files[] = [
                'directory' => dirname($relativePath),
                'file'      => basename($relativePath),
                'path'      => $relativePath
            ];
        }
    }
}


/*
 * Run discovery
 */
discoverOPW(
    $opwRoot,
    $opwRoot,
    $directories,
    $files
);


/*
 * Sort directories
 */
sort($directories);


/*
 * Sort files by directory and filename
 */
usort($files, function ($a, $b) {

    $directoryCompare = strcmp(
        $a['directory'],
        $b['directory']
    );

    if ($directoryCompare !== 0) {
        return $directoryCompare;
    }

    return strcmp(
        $a['file'],
        $b['file']
    );
});


/*
 * Report
 */
echo "<h1>OPW Discovery</h1>";

echo "<p><strong>OPW Root:</strong><br>";
echo htmlspecialchars($opwRoot);
echo "</p>";


/*
 * DIRECTORIES
 */
echo "<h2>Directories</h2>";

foreach ($directories as $directory) {

    echo htmlspecialchars($directory);
    echo "<br>";
}


/*
 * FILES
 */
echo "<h2>Files</h2>";

$currentDirectory = '';

foreach ($files as $file) {

    if ($file['directory'] !== $currentDirectory) {

        $currentDirectory = $file['directory'];

        echo "<h3>";
        echo htmlspecialchars($currentDirectory);
        echo "</h3>";
    }

    echo htmlspecialchars($file['file']);
    echo "<br>";
}

?>