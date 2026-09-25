<?php

$debug = false;

$imageDir = __DIR__ . "/images/";
$metadataFile = __DIR__ . "/text/opw02-characters.txt";

$characters = [];

/* Read character information */

if (is_file($metadataFile)) {

    $lines = file($metadataFile, FILE_IGNORE_NEW_LINES);
    $record = [];

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === "") {

            if (!empty($record)) {
                $characters[] = $record;
            }

            $record = [];

        } elseif (strpos($line, ":") !== false) {

            [$key, $value] = explode(":", $line, 2);

            $record[strtolower(trim($key))] = trim($value);
        }
    }

    if (!empty($record)) {
        $characters[] = $record;
    }
}

/* Select character */

$selectedIndex = null;

if (
    isset($_GET["character"]) &&
    filter_var(
        $_GET["character"],
        FILTER_VALIDATE_INT
    ) !== false
) {

    $selectedIndex = (int) $_GET["character"];
}

/* Check selected character */

if (
    $selectedIndex === null ||
    !isset($characters[$selectedIndex])
) {

    http_response_code(404);

    echo "Character not found.";

    exit();
}

$character = $characters[$selectedIndex];

/* Character asset numbers */

$characterNumber = ($selectedIndex * 2) + 1;

$iconNumber = str_pad(
    $characterNumber,
    2,
    "0",
    STR_PAD_LEFT
);

$detailsNumber = str_pad(
    $characterNumber + 1,
    2,
    "0",
    STR_PAD_LEFT
);

/* Find images */

$images = is_dir($imageDir)
    ? scandir($imageDir)
    : [];

$icon = "";
$details = "";
$artwork = [];

foreach ($images as $candidate) {

    /* Character Icon */

    if (preg_match(
        '/^cop' . $iconNumber . '-.*\.(png|jpg|jpeg|webp)$/i',
        $candidate
    )) {

        $icon = $candidate;
    }

    /* Character Details */

    if (preg_match(
        '/^cop' . $detailsNumber . '-.*\.(png|jpg|jpeg|webp)$/i',
        $candidate
    )) {

        $details = $candidate;
    }

    /* Additional Character Artwork */

    if (preg_match(
        '/^cop' . $iconNumber . '-[0-9]+-.*\.(png|jpg|jpeg|webp)$/i',
        $candidate
    )) {

        $artwork[] = $candidate;
    }
}

/* Sort additional artwork */

natsort($artwork);

$artwork = array_values($artwork);

/* Debug Information */

if ($debug) {

    echo '<div style="
        margin:20px;
        padding:15px;
        border:2px solid red;
        background:#fff;
        color:#000;
        font-family:monospace;
    ">';

    echo '<h2>DEBUG</h2>';

    echo '<p><strong>Character:</strong> '
        . htmlspecialchars($character["name"] ?? "")
        . '</p>';

    echo '<p><strong>Character number:</strong> '
        . htmlspecialchars($iconNumber)
        . '</p>';

    echo '<p><strong>Icon:</strong> '
        . htmlspecialchars($icon ?: "NONE")
        . '</p>';

    echo '<p><strong>Details:</strong> '
        . htmlspecialchars($details ?: "NONE")
        . '</p>';

    echo '<p><strong>Additional artwork:</strong> '
        . count($artwork)
        . '</p>';

    if (!empty($artwork)) {

        echo '<ul>';

        foreach ($artwork as $image) {

            echo '<li>'
                . htmlspecialchars($image)
                . '</li>';
        }

        echo '</ul>';
    }

    echo '</div>';
}

?>

<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars(
            $character["name"] ?? "Character"
        ) ?>
        - The Owl and the Pussycat World
    </title>

    <link
        rel="stylesheet"
        href="css/mystyle.css"
    >

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

    <h1>
        <?= htmlspecialchars(
            $character["name"] ?? ""
        ) ?>
    </h1>

    <!-- Character Display -->

    <div class="character-display">

        <!-- Character Information -->

        <div class="character-display-info">

            <p>
                <strong>Place:</strong>
                <?= htmlspecialchars(
                    $character["place"] ?? ""
                ) ?>
            </p>

            <p>
                <strong>Role:</strong>
                <?= htmlspecialchars(
                    $character["role"] ?? ""
                ) ?>
            </p>

        </div>

        <!-- Character Images -->

        <h2>Character</h2>

        <div class="character-display-row">

<?php if (!empty($icon)): ?>

            <div class="character-display-item">

                <h3>Icon</h3>

                <a
                    href="images/<?= htmlspecialchars($icon) ?>"
                    target="_blank"
                >

                    <img
                        src="images/<?= htmlspecialchars($icon) ?>"
                        alt="<?= htmlspecialchars(
                            $character["name"] ?? ""
                        ) ?>"
                        class="character-display-image"
                    >

                </a>

            </div>

<?php endif; ?>

<?php if (!empty($details)): ?>

            <div class="character-display-item">

                <h3>Details</h3>

                <a
                    href="images/<?= htmlspecialchars($details) ?>"
                    target="_blank"
                >

                    <img
                        src="images/<?= htmlspecialchars($details) ?>"
                        alt="<?= htmlspecialchars(
                            $character["name"] ?? ""
                        ) ?>"
                        class="character-display-image"
                    >

                </a>

            </div>

<?php endif; ?>

        </div>

        <!-- Associated Artwork -->

<?php if (!empty($artwork)): ?>

        <h2>Associated Artwork</h2>

        <div class="character-display-artwork">

<?php foreach ($artwork as $image): ?>

            <div class="character-display-item">

                <a
                    href="images/<?= htmlspecialchars($image) ?>"
                    target="_blank"
                >

                    <img
                        src="images/<?= htmlspecialchars($image) ?>"
                        alt="<?= htmlspecialchars(
                            $character["name"] ?? ""
                        ) ?>"
                        class="character-display-image"
                    >

                </a>

            </div>

<?php endforeach; ?>

        </div>

<?php endif; ?>

    </div>

    <br>

    <p>
        <a href="opw02-characters.php">
            Back to Characters
        </a>
    </p>

</main>

<footer>

    <p>
        &copy; 2026 Pennylane Poetry. All rights reserved.
    </p>

</footer>

</body>

</html>