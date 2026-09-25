<?php
/*
 * OPW OBJECT DESIGN — TEST 1
 *
 * Discovery:
 *
 * 1. Find the stories directory.
 * 2. Find the Character Reference directory.
 * 3. Identify key players from its image filenames.
 * 4. Find Story Collections.
 * 5. Find Individual Stories.
 * 6. Use the known character names to add meaning to story names.
 *
 * No object construction yet.
 */

$root = __DIR__;
$storiesPath = $root . '/stories';


/*
 * Find directories directly inside a directory.
 */
function findDirectories($directory)
{
    $directories = [];

    if (!is_dir($directory)) {
        return $directories;
    }

    foreach (scandir($directory) as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            $directories[] = [
                'name' => $item,
                'path' => $path
            ];
        }
    }

    return $directories;
}


/*
 * Find image files directly inside a directory.
 */
function findImages($directory)
{
    $images = [];

    if (!is_dir($directory)) {
        return $images;
    }

    foreach (scandir($directory) as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (is_file($path)) {

            $extension = strtolower(
                pathinfo($item, PATHINFO_EXTENSION)
            );

            if (
                in_array(
                    $extension,
                    ['png', 'jpg', 'jpeg', 'gif', 'webp']
                )
            ) {
                $images[] = $item;
            }
        }
    }

    return $images;
}


/*
 * Convert an image filename into a possible
 * character name.
 *
 * Example:
 *
 * graham-detail.png
 *        ↓
 * Graham
 */
function characterNameFromFilename($filename)
{
    $name = pathinfo($filename, PATHINFO_FILENAME);

    $name = preg_replace(
        '/[-_]?(detail|details|icon|character)$/i',
        '',
        $name
    );

    $name = str_replace(
        ['-', '_'],
        ' ',
        $name
    );

    return ucwords(trim($name));
}


/*
 * Find the Character Reference directory
 * anywhere below stories.
 */
function findCharacterReference($directory)
{
    if (!is_dir($directory)) {
        return null;
    }

    foreach (scandir($directory) as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (
            is_dir($path) &&
            stripos($item, 'character-reference') !== false
        ) {
            return $path;
        }

        if (is_dir($path)) {

            $found = findCharacterReference($path);

            if ($found !== null) {
                return $found;
            }
        }
    }

    return null;
}


/*
 * Turn a story directory name into a readable name.
 */
function readableName($name)
{
    /*
     * Remove numbering such as:
     * [01] -
     * [02] -
     */
    $name = preg_replace(
        '/^\[\d+\]\s*-\s*/',
        '',
        $name
    );

    /*
     * Remove ops numbering.
     */
    $name = preg_replace(
        '/^ops\d+\s*-\s*/i',
        '',
        $name
    );

    $name = str_replace(
        ['-', '_'],
        ' ',
        $name
    );

    return ucwords(trim($name));
}


/*
 * Try to identify character names appearing
 * in a story directory name.
 */
function identifyCharacters($storyName, $characters)
{
    $found = [];

    $storyText = strtolower(
        str_replace(
            ['-', '_'],
            ' ',
            $storyName
        )
    );

    foreach ($characters as $character) {

        if (
            stripos(
                $storyText,
                strtolower($character)
            ) !== false
        ) {
            $found[] = $character;
        }
    }

    return $found;
}


/*
 * Start discovery.
 */

$characterReference = findCharacterReference(
    $storiesPath
);

$characters = [];


/*
 * Identify key players.
 */

if ($characterReference !== null) {

    $images = findImages(
        $characterReference
    );

    foreach ($images as $image) {

        $character = characterNameFromFilename(
            $image
        );

        if ($character !== '') {
            $characters[] = $character;
        }
    }
}


/*
 * Remove duplicates.
 */

$characters = array_values(
    array_unique($characters)
);


/*
 * Find top-level story directories.
 */

$topDirectories = findDirectories(
    $storiesPath
);

$collections = [];
$individualStories = [];


foreach ($topDirectories as $directory) {

    /*
     * Ignore the Character Reference directory
     * if it happens to be at this level.
     */

    if (
        stripos(
            $directory['name'],
            'character-reference'
        ) !== false
    ) {
        continue;
    }


    $children = findDirectories(
        $directory['path']
    );


    /*
     * A directory containing child directories
     * is a Story Collection.
     */

    if (!empty($children)) {

        $stories = [];

        foreach ($children as $child) {

            if (
                stripos(
                    $child['name'],
                    'character-reference'
                ) !== false
            ) {
                continue;
            }

            $stories[] = $child;
        }

        $collections[] = [
            'name' => $directory['name'],
            'stories' => $stories
        ];

    } else {

        /*
         * Otherwise it is an Individual Story.
         */

        $individualStories[] = $directory;
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>OPW Object Design — Test 1</title>

</head>

<body>

<h1>OPW OBJECT DESIGN — TEST 1</h1>


<h2>DISCOVERY</h2>


<h2>CHARACTER REFERENCES</h2>

<?php if ($characterReference === null): ?>

    <p>No character references found.</p>

<?php else: ?>

    <p>
        Character reference found:
        <strong>
            <?php
            echo htmlspecialchars(
                basename($characterReference)
            );
            ?>
        </strong>
    </p>

    <p>
        <strong>Key players identified:</strong>
    </p>

    <?php if (empty($characters)): ?>

        <p>No character names identified.</p>

    <?php else: ?>

        <ul>

            <?php foreach ($characters as $character): ?>

                <li>
                    <?php echo htmlspecialchars($character); ?>
                </li>

            <?php endforeach; ?>

        </ul>

    <?php endif; ?>

<?php endif; ?>


<h2>STORY COLLECTIONS</h2>

<?php if (empty($collections)): ?>

    <p>No Story Collections found.</p>

<?php else: ?>

    <?php foreach ($collections as $collection): ?>

        <h3>
            <?php
            echo htmlspecialchars(
                $collection['name']
            );
            ?>
        </h3>

        <p>
            Stories found:
            <?php echo count($collection['stories']); ?>
        </p>

        <ul>

            <?php foreach ($collection['stories'] as $story): ?>

                <?php

                $storyName = readableName(
                    $story['name']
                );

                $storyCharacters = identifyCharacters(
                    $storyName,
                    $characters
                );

                ?>

                <li>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $storyName
                        );
                        ?>
                    </strong>

                    <?php if (!empty($storyCharacters)): ?>

                        — Character reference:

                        <?php
                        echo htmlspecialchars(
                            implode(
                                ' + ',
                                $storyCharacters
                            )
                        );
                        ?>

                    <?php endif; ?>

                </li>

            <?php endforeach; ?>

        </ul>

    <?php endforeach; ?>

<?php endif; ?>


<h2>INDIVIDUAL STORIES</h2>

<?php if (empty($individualStories)): ?>

    <p>No Individual Stories found.</p>

<?php else: ?>

    <ul>

        <?php foreach ($individualStories as $story): ?>

            <?php

            $storyName = readableName(
                $story['name']
            );

            $storyCharacters = identifyCharacters(
                $storyName,
                $characters
            );

            ?>

            <li>

                <strong>
                    <?php
                    echo htmlspecialchars(
                        $storyName
                    );
                    ?>
                </strong>

                <?php if (!empty($storyCharacters)): ?>

                    — Character reference:

                    <?php
                    echo htmlspecialchars(
                        implode(
                            ' + ',
                            $storyCharacters
                        )
                    );
                    ?>

                <?php endif; ?>

            </li>

        <?php endforeach; ?>

    </ul>

<?php endif; ?>


<hr>

<h2>DISCOVERY SUMMARY</h2>

<ul>

    <li>
        Key players identified:
        <?php echo count($characters); ?>
    </li>

    <li>
        Story Collections found:
        <?php echo count($collections); ?>
    </li>

    <li>
        Individual Stories found:
        <?php echo count($individualStories); ?>
    </li>

</ul>

</body>

</html>