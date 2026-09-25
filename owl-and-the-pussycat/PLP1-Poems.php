<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Poems - Pennylane Poetry</title>

        <link rel="stylesheet" href="css/mystyle.css" />
    </head>

    <body>
        
        <nav>
            <ul>
                <li><a href="PLP0-Home.html">Home</a></li>
                <li><a href="PLP1-Poems.php">Poetry</a></li>
                <li><a href="PLP2-Stories.html">Stories</a></li>
                <li><a href="PLP4-Contact.html">Contact</a></li>
            </ul>
        </nav>

        <main>

<?php
$poemDir = __DIR__ . "/poems/";
$imageDir = __DIR__ . "/images/";
$metadataFile = __DIR__ . "/plp-poems.txt";

$poems = [];

if (is_dir($poemDir) && ($files = scandir($poemDir)) !== false) {
    foreach ($files as $file) {
        if (preg_match('/^pm(\d+)-(.+)\.html$/i', $file, $match)) {
            $poems[(int) $match[1]] = [
                "file" => $file,
                "number" => (int) $match[1],
                "base" => pathinfo($file, PATHINFO_FILENAME),
            ];
        }
    }

    ksort($poems, SORT_NUMERIC);
}

$metadata = [];

if (is_file($metadataFile)) {
    $lines = file($metadataFile, FILE_IGNORE_NEW_LINES);
    $record = [];

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === "") {
            if (isset($record["title"])) {
                $metadata[] = $record;
            }

            $record = [];
            continue;
        }

        if (strpos($line, "=") !== false) {
            [$key, $value] = explode("=", $line, 2);
            $record[trim($key)] = trim($value);
        }
    }

    if (isset($record["title"])) {
        $metadata[] = $record;
    }
}

/* =====================================
   Featured Poem
   Random selection with Poem 1 weighted
   ===================================== */

$featuredIndex = null;

if (count($poems) > 0) {
    $poemKeys = array_keys($poems);

    if (isset($poems[1]) && count($poems) > 1) {
        $choices = array_merge(
            [1, 1, 1, 1],
            $poemKeys
        );

        $featuredIndex = $choices[array_rand($choices)];
    } else {
        $featuredIndex = $poemKeys[array_rand($poemKeys)];
    }
}

if ($featuredIndex !== null && isset($poems[$featuredIndex])) {
    $featuredPoem = $poems[$featuredIndex];
    $featuredData = $metadata[$featuredIndex - 1] ?? [];

    $featuredTitle = $featuredData["title"] ?? "";
    $featuredSubtitle = $featuredData["subtitle"] ?? "";
    $featuredYoutube = $featuredData["youtube"] ?? "";

    $featuredImage = "";
    $featuredImageWidth = 0;
    $featuredImageHeight = 0;

    $featuredPattern =
        "/^" .
        preg_quote($featuredPoem["base"], "/") .
        '\\.(png|jpg|jpeg|webp)$/i';

    if (is_dir($imageDir) && ($images = scandir($imageDir)) !== false) {
        foreach ($images as $candidate) {
            if (preg_match($featuredPattern, $candidate)) {
                $featuredImage = $candidate;

                $featuredImagePath = $imageDir . $featuredImage;

                if (is_file($featuredImagePath)) {
                    $imageInfo = getimagesize($featuredImagePath);

                    if ($imageInfo !== false) {
                        $featuredImageWidth = $imageInfo[0];
                        $featuredImageHeight = $imageInfo[1];
                    }
                }

                break;
            }
        }
    }

    echo '            <div class="featured-poem-container">' . PHP_EOL;
    echo '                <article class="poem-item featured-poem">' . PHP_EOL;

    echo '                    <h3>' .
        htmlspecialchars($featuredTitle, ENT_QUOTES, "UTF-8") .
        '</h3>' . PHP_EOL;

    echo '                    <p class="poem-subtitle">' .
        htmlspecialchars($featuredSubtitle, ENT_QUOTES, "UTF-8") .
        '</p>' . PHP_EOL;

    if ($featuredImage !== "") {
        echo '                    <a href="poems/' .
            htmlspecialchars($featuredPoem["file"], ENT_QUOTES, "UTF-8") .
            '" class="poem-image-link">' .
            PHP_EOL;

        echo '                        <img src="images/' .
            htmlspecialchars($featuredImage, ENT_QUOTES, "UTF-8") .
            '"';

        if ($featuredImageWidth > 0 && $featuredImageHeight > 0) {
            echo ' width="' . $featuredImageWidth .
                '" height="' . $featuredImageHeight . '"';
        }

        echo ' alt="' .
            htmlspecialchars($featuredTitle, ENT_QUOTES, "UTF-8") .
            '" class="poem-image">' .
            PHP_EOL;

        echo '                    </a>' . PHP_EOL;
    }

    echo '                    <p class="poem-links">' . PHP_EOL;

    echo '                        <a href="poems/' .
        htmlspecialchars($featuredPoem["file"], ENT_QUOTES, "UTF-8") .
        '">Read</a>' .
        PHP_EOL;

    echo '                        |' . PHP_EOL;

    echo '                        <a href="' .
        htmlspecialchars($featuredYoutube, ENT_QUOTES, "UTF-8") .
        '" target="_blank" rel="noopener noreferrer">Listen</a>' .
        PHP_EOL;

    echo '                    </p>' . PHP_EOL;

    echo '                </article>' . PHP_EOL;
    echo '            </div>' . PHP_EOL;

    echo '            <br />' . PHP_EOL;
    echo '            <h2>Featured Poem</h2>' . PHP_EOL;
}
?>

            <div class="poem-list">
<?php
foreach ($poems as $index => $poem) {
    $data = $metadata[$index - 1] ?? [];

    $title = $data["title"] ?? "";
    $subtitle = $data["subtitle"] ?? "";
    $youtube = $data["youtube"] ?? "";

    $image = "";
    $imageWidth = 0;
    $imageHeight = 0;

    $pattern =
        "/^" .
        preg_quote($poem["base"], "/") .
        '\\.(png|jpg|jpeg|webp)$/i';

    if (is_dir($imageDir) && ($images = scandir($imageDir)) !== false) {
        foreach ($images as $candidate) {
            if (preg_match($pattern, $candidate)) {
                $image = $candidate;

                $imagePath = $imageDir . $image;

                if (is_file($imagePath)) {
                    $imageInfo = getimagesize($imagePath);

                    if ($imageInfo !== false) {
                        $imageWidth = $imageInfo[0];
                        $imageHeight = $imageInfo[1];
                    }
                }

                break;
            }
        }
    }

    echo '                <article class="poem-item">' . PHP_EOL;

    echo "                    <h3>" .
        htmlspecialchars($title, ENT_QUOTES, "UTF-8") .
        "</h3>" . PHP_EOL;

    echo '                    <p class="poem-subtitle">' .
        htmlspecialchars($subtitle, ENT_QUOTES, "UTF-8") .
        "</p>" . PHP_EOL;

    if ($image !== "") {
        echo '                    <a href="poems/' .
            htmlspecialchars($poem["file"], ENT_QUOTES, "UTF-8") .
            '" class="poem-image-link">' .
            PHP_EOL;

        echo '                        <img src="images/' .
            htmlspecialchars($image, ENT_QUOTES, "UTF-8") .
            '"';

        if ($imageWidth > 0 && $imageHeight > 0) {
            echo ' width="' . $imageWidth .
                '" height="' . $imageHeight . '"';
        }

        echo ' alt="' .
            htmlspecialchars($title, ENT_QUOTES, "UTF-8") .
            '" class="poem-image">' .
            PHP_EOL;

        echo "                    </a>" . PHP_EOL;
    }

    echo '                    <p class="poem-links">' . PHP_EOL;

    echo '                        <a href="poems/' .
        htmlspecialchars($poem["file"], ENT_QUOTES, "UTF-8") .
        '">Read</a>' .
        PHP_EOL;

    echo "                        |" . PHP_EOL;

    echo '                        <a href="' .
        htmlspecialchars($youtube, ENT_QUOTES, "UTF-8") .
        '" target="_blank" rel="noopener noreferrer">Listen</a>' .
        PHP_EOL;

    echo "                    </p>" . PHP_EOL;

    echo "                </article>" . PHP_EOL;
}
?>
            </div>
        </main>

        <footer>
            <p>&copy; 2026 Pennylane Poetry. All rights reserved.</p>
        </footer>
    </body>
</html>