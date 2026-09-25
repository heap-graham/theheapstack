<?php

$poemDir = __DIR__ . "/poems/";
$imageDir = __DIR__ . "/images/";
$metadataFile = __DIR__ . "/text/opw01-poems.txt";

$poems = [];

/* Find poem files */

if (is_dir($poemDir)) {
    $files = scandir($poemDir);

    foreach ($files as $file) {
        if (preg_match('/^opp(\d+)-(.+)\.html$/i', $file, $match)) {
            $number = (int) $match[1];

            $poems[$number] = [
                "file" => $file,
                "number" => $number,
                "base" => pathinfo($file, PATHINFO_FILENAME),
            ];
        }
    }
}

ksort($poems);

/* Read poem information */

$metadata = [];

if (is_file($metadataFile)) {
    $lines = file($metadataFile, FILE_IGNORE_NEW_LINES);
    $record = [];

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === "") {
            if (!empty($record)) {
                $metadata[] = $record;
            }

            $record = [];
        } elseif (strpos($line, "=") !== false) {
            [$key, $value] = explode("=", $line, 2);

            $record[trim($key)] = trim($value);
        }
    }

    if (!empty($record)) {
        $metadata[] = $record;
    }
}

/* Featured Poem */

$poemKeys = array_keys($poems);

$featuredIndex = null;

if (!empty($poemKeys)) {
    $choices = array_merge([1, 1, 1, 1], $poemKeys);

    $featuredIndex = $choices[array_rand($choices)];
}
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Poetry - The Owl and the Pussycat World</title>

    <link rel="stylesheet" href="css/mystyle.css">

</head>

<body>

<nav>

    <ul>

        <li>
            <a href="index.php">Home</a>
        </li>

        <li>
            <a href="opw01-home.php">Poetry</a>
        </li>

        <li>
            <a href="opw02-characters.php">Characters</a>
           
        </li>

        <li>
            <a href="stories/">Graphic Stories</a>
        </li>

        <li>
            <a href="world/">World</a>
        </li>

    </ul>

</nav>

<main>

    <h1>Poetry</h1>

<?php /* Display Featured Poem */

if ($featuredIndex !== null && isset($poems[$featuredIndex])) {

    $poem = $poems[$featuredIndex];
    $data = $metadata[$featuredIndex - 1] ?? [];

    $title = $data["title"] ?? "";
    $subtitle = $data["subtitle"] ?? "";
    $youtube = $data["youtube"] ?? "";

    $image = "";

    $images = scandir($imageDir);

    foreach ($images as $candidate) {
        if (preg_match("/^" . preg_quote($poem["base"], "/") . '\.(png|jpg|jpeg|webp)$/i', $candidate)) {
            $image = $candidate;
            break;
        }
    }
    ?>

    <div class="featured-poem-container">

        <article class="poem poem-item featured-poem">

           

            <h3>
                <?= htmlspecialchars($title) ?>
            </h3>

<?php if ($subtitle !== ""): ?>

            <p class="poem-subtitle">
                <?= htmlspecialchars($subtitle) ?>
            </p>

<?php endif; ?>

<?php if ($image !== ""): ?>

            <a href="poems/<?= htmlspecialchars($poem["file"]) ?>"
               class="poem-image-link">

                <img
                    src="images/<?= htmlspecialchars($image) ?>"
                    alt="<?= htmlspecialchars($title) ?>"
                    class="poem-image"
                >

            </a>
             

<?php endif; ?>

            <p class="poem-links">

                <a href="poems/<?= htmlspecialchars($poem["file"]) ?>">
                    Read
                </a>

                |

                <a href="<?= htmlspecialchars($youtube) ?>"
                   target="_blank"
                   rel="noopener noreferrer">
                    Listen
                </a>

            </p>

        </article>

    </div>
    <br/>
    <h2>Featured Poem</h2>

<?php
} ?>

    <div class="poem-list">

<?php /* Display Complete Poetry Collection */

foreach ($poems as $number => $poem) {

    $data = $metadata[$number - 1] ?? [];

    $title = $data["title"] ?? "";
    $subtitle = $data["subtitle"] ?? "";
    $youtube = $data["youtube"] ?? "";

    $image = "";

    $images = scandir($imageDir);

    foreach ($images as $candidate) {
        if (preg_match("/^" . preg_quote($poem["base"], "/") . '\.(png|jpg|jpeg|webp)$/i', $candidate)) {
            $image = $candidate;
            break;
        }
    }
    ?>

        <article class="poem-item">

            <h3>
                <?= htmlspecialchars($title) ?>
            </h3>

<?php if ($subtitle !== ""): ?>

            <p class="poem-subtitle">
                <?= htmlspecialchars($subtitle) ?>
            </p>

<?php endif; ?>

<?php if ($image !== ""): ?>

            <a href="poems/<?= htmlspecialchars($poem["file"]) ?>"
               class="poem-image-link">

                <img
                    src="images/<?= htmlspecialchars($image) ?>"
                    alt="<?= htmlspecialchars($title) ?>"
                    class="poem-image"
                >

            </a>

<?php endif; ?>

            <p class="poem-links">

                <a href="poems/<?= htmlspecialchars($poem["file"]) ?>">
                    Read
                </a>

                |

                <a href="<?= htmlspecialchars($youtube) ?>"
                   target="_blank"
                   rel="noopener noreferrer">
                    Listen
                </a>

            </p>

        </article>

<?php
} ?>

    </div>

</main>

<footer>

    <p>&copy; 2026 Pennylane Poetry. All rights reserved.</p>

</footer>

</body>

</html>