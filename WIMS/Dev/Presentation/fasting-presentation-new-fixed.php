<?php

/*
 * WIMS Presentation
 *
 * Slides are defined in slides.txt
 *
 */

/* ---------------------------------------------------------
   READ SLIDES
   --------------------------------------------------------- */

$slides = [];
$current = null;
$currentKey = null;

$lines = file("slides.txt", FILE_IGNORE_NEW_LINES);

foreach ($lines as $line) {
    $line = rtrim($line);

    /* Preserve blank lines for text formatting */
    if (trim($line) === "") {
        if ($currentKey !== null) {
            if (is_array($current[$currentKey])) {
                $lastIndex = count($current[$currentKey]) - 1;
                if ($lastIndex >= 0) {
                    $current[$currentKey][$lastIndex] .= "\n";
                }
            } else {
                $current[$currentKey] .= "\n";
            }
        }

        continue;
    }

    /* New slide */
    if (trim($line) === "[slide]") {
        if ($current !== null) {
            $slides[] = $current;
        }

        $current = [];
        $currentKey = null;
        continue;
    }

    if ($current === null) {
        continue;
    }

    /* New keyword / field */
    if (strpos($line, "=") !== false) {
        [$key, $value] = explode("=", $line, 2);

        $key = trim($key);
        $value = trim($value);

        /* Allow repeated image= entries */
        if ($key === "image") {
            if (!isset($current[$key])) {
                $current[$key] = [$value];
            } else {
                $current[$key][] = $value;
            }

            $currentKey = null;
            continue;
        }

        /* Allow repeated column= entries */
        if ($key === "column") {
            if (!isset($current[$key])) {
                $current[$key] = [$value];
            } else {
                $current[$key][] = $value;
            }

            $currentKey = null;
            continue;
        }

        /* Allow repeated items= entries */
        if ($key === "items") {
            if (!isset($current[$key]) || !is_array($current[$key])) {
                $current[$key] = [];
            }

            $current[$key][] = $value;
            $currentKey = $key;
            continue;
        }

        $current[$key] = $value;
        $currentKey = $key;

        continue;
    }

    /* Continuation line */
    if ($currentKey !== null) {
        if ($currentKey === "items" && is_array($current[$currentKey])) {
            $lastIndex = count($current[$currentKey]) - 1;
            $current[$currentKey][$lastIndex] .= "\n" . trim($line);
        } else {
            $current[$currentKey] .= "\n" . trim($line);
        }
    }
}

if ($current !== null) {
    $slides[] = $current;
}

$totalSlides = count($slides);

/* ---------------------------------------------------------
   HELPER FUNCTIONS
   --------------------------------------------------------- */

function e($value)
{
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

function lines($value)
{
    return nl2br(e(str_replace("|", "\n", $value ?? "")));
}

function paragraphs($value)
{
    $value = trim($value ?? "");

    if ($value === "") {
        return "";
    }

    /*
     * Three or more newline characters mean
     * two or more blank lines = new paragraph.
     */
    $paragraphs = preg_split("/\n{3,}/", $value);

    $output = [];

    foreach ($paragraphs as $paragraph) {
        /*
         * Escape the text before adding HTML markup.
         */
        $paragraph = e($paragraph);

        /*
         * Two newline characters mean
         * one blank line = visual line break.
         */
        $paragraph = preg_replace("/\n{2}/", "<br>", $paragraph);

        /*
         * A normal newline becomes a space,
         * allowing the browser to wrap the text naturally.
         */
        $paragraph = preg_replace("/\n/", " ", $paragraph);

        $output[] = "<p>" . $paragraph . "</p>";
    }

    return implode("", $output);
}

function items($value)
{
    if (empty($value)) {
        return [];
    }

    if (is_array($value)) {
        $output = [];

        foreach ($value as $block) {
            $output = array_merge(
                $output,
                array_filter(array_map("trim", preg_split('/\r\n|\r|\n/', (string) $block)))
            );
        }

        return $output;
    }

    return array_filter(array_map("trim", preg_split('/\r\n|\r|\n/', (string) $value)));
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

<title>WIMS Presentation</title>

<link
    rel="stylesheet"
    href="css/presentation.css"
>

</head>

<body>


<?php foreach ($slides as $index => $slide): ?>

<?php
$slideNumber = $index + 1;

$slideId = "slide" . $slideNumber;

$isFirst = $index === 0;

$isLast = $index === $totalSlides - 1;
?>


<section
    class="slide <?= $isFirst ? "title-slide" : "" ?>"
    id="<?= e($slideId) ?>"
>


    <div class="content">


        <!-- STAND-ALONE HEADING -->

        <?php if (!empty($slide["heading"])): ?>

            <div class="slide-heading">

                <h1><?= e($slide["heading"]) ?></h1>

            </div>

        <?php endif; ?>


        <!-- EYEBROW -->

        <?php if (!empty($slide["eyebrow"])): ?>

            <p class="eyebrow">
                <?= e($slide["eyebrow"]) ?>
            </p>

        <?php endif; ?>


        <!-- OLD TITLE -->

        <?php if (!empty($slide["title"])): ?>

            <h1>
                <?= lines($slide["title"]) ?>
            </h1>

        <?php endif; ?>


        <!-- SUBTITLE -->

        <?php if (!empty($slide["subtitle"])): ?>

            <h2>
                <?= lines($slide["subtitle"]) ?>
            </h2>

        <?php endif; ?>


        <!-- DESCRIPTION -->

        <?php if (!empty($slide["description"])): ?>

            <p class="subtitle">
                <?= e($slide["description"]) ?>
            </p>

        <?php endif; ?>


        <!-- TEXT -->

        <?php if (!empty($slide["text"])): ?>

            <?= paragraphs($slide["text"]) ?>

        <?php endif; ?>


        <!-- AUTHOR -->

        <?php if (!empty($slide["author"])): ?>

            <p class="author">
                <?= e($slide["author"]) ?>
            </p>

        <?php endif; ?>


        <!-- IMAGES -->

        <?php if (!empty($slide["image"])): ?>

            <?php if (count($slide["image"]) === 1): ?>

                <div class="slide-image">

                    <img
                        src="<?= e($slide["image"][0]) ?>"
                        alt="<?= e($slide["heading"] ?? ($slide["title"] ?? "")) ?>"
                    >

                </div>

            <?php else: ?>

                <div class="slide-images">

                    <?php foreach ($slide["image"] as $image): ?>

                        <img
                            src="<?= e($image) ?>"
                            alt="<?= e($slide["heading"] ?? ($slide["title"] ?? "")) ?>"
                        >

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>


        <!-- FLOW DIAGRAM -->

        <?php if (($slide["type"] ?? "") === "flow"): ?>

            <div class="flow">

                <div class="flow-box">
                    <strong>WHAT?</strong>
                    <span>What happened?</span>
                </div>

                <div class="arrow">→</div>

                <div class="flow-box">
                    <strong>SO WHAT?</strong>
                    <span>What was learnt?</span>
                </div>

                <div class="arrow">→</div>

                <div class="flow-box">
                    <strong>WHAT NEXT?</strong>
                    <span>What might change?</span>
                </div>

            </div>

        <?php endif; ?>


        <!-- LIST -->

        <?php if (($slide["type"] ?? "") === "list"): ?>

            <ul>

                <?php foreach (items($slide["items"] ?? "") as $item): ?>

                    <li>
                        <?= e($item) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>


        <!-- COMPARE -->

        <?php if (($slide["type"] ?? "") === "compare"): ?>

            <?php
            /*
             * Dynamic compare columns.
             *
             * Repeated column= entries define the number and
             * headings of the columns:
             *
             * column=Text 1
             * column=Text 2
             * column=Text 3
             *
             * Existing column1=/column2= slides remain supported.
             */
            $columns = $slide["column"] ?? [];

            if (!is_array($columns)) {
                $columns = [$columns];
            }

            if (empty($columns)) {
                $columns = [];

                if (!empty($slide["column1"])) {
                    $columns[] = $slide["column1"];
                }

                if (!empty($slide["column2"])) {
                    $columns[] = $slide["column2"];
                }
                if (!empty($slide["column3"])) {
                    $columns[] = $slide["column3"];
                }
            }
            ?>

            <div class="compare">

                <?php foreach ($columns as $columnIndex => $column): ?>

                    <?php if (isset($slide["items"]) && is_array($slide["items"])) {
                        $columnItems = items($slide["items"][$columnIndex] ?? "");
                    } else {
                        $itemsKey = "items" . ($columnIndex + 1);
                        $columnItems = items($slide[$itemsKey] ?? "");
                    } ?>

                    <div class="compare-column">

                        <h3><?= e($column) ?></h3>

                        <?php if (!empty($columnItems)): ?>

                            <ul>

                                <?php foreach ($columnItems as $item): ?>

                                    <li>
                                        <?= e($item) ?>
                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- SCOPE -->

        <?php if (!empty($slide["scope"])): ?>

            <div class="scope">
                <?= e($slide["scope"]) ?>
            </div>

        <?php endif; ?>


        <!-- TABLE -->

        <?php if (($slide["type"] ?? "") === "table"): ?>

            <table>

                <thead>

                    <tr>
                        <th>Week</th>
                        <th>Fasting days</th>
                        <th>Average</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>01/09</td>
                        <td>4</td>
                        <td>16.51 st</td>
                    </tr>

                    <tr>
                        <td>08/09</td>
                        <td>3</td>
                        <td>16.22 st</td>
                    </tr>

                    <tr>
                        <td>15/09</td>
                        <td>4</td>
                        <td>15.90 st</td>
                    </tr>

                    <tr>
                        <td>22/09</td>
                        <td>3</td>
                        <td>15.59 st</td>
                    </tr>

                    <tr>
                        <td>29/09</td>
                        <td>2</td>
                        <td>16.04 st</td>
                    </tr>

                </tbody>

            </table>

        <?php endif; ?>


        <!-- FEEDBACK DIAGRAM -->

        <?php if (($slide["type"] ?? "") === "feedback"): ?>

            <div class="feedback">

                <div>Daily weight</div>
                <span>↓</span>

                <div>Weekly average</div>
                <span>↓</span>

                <div>Trend</div>
                <span>↓</span>

                <div>Adjustment</div>
                <span>↺</span>

            </div>

        <?php endif; ?>


        <!-- NOTE -->

        <?php if (!empty($slide["note"])): ?>

            <?= paragraphs($slide["note"]) ?>

        <?php endif; ?>


        <!-- CLOSING -->

        <?php if (!empty($slide["closing"])): ?>

            <p class="closing">
                <?= e($slide["closing"]) ?>
            </p>

        <?php endif; ?>


    </div>


    <!-- SLIDE NUMBER -->

    <div class="slide-number">
        <?= $slideNumber ?> / <?= $totalSlides ?>
    </div>


    <!-- PREVIOUS -->

    <?php if (!$isFirst): ?>

        <a
            class="prev"
            href="#slide<?= $slideNumber - 1 ?>"
            aria-label="Previous slide"
        >←</a>

    <?php endif; ?>


    <!-- NEXT -->

    <?php if (!$isLast): ?>

        <a
            class="next"
            href="#slide<?= $slideNumber + 1 ?>"
            aria-label="Next slide"
        >→</a>

    <?php endif; ?>


</section>


<?php endforeach; ?>


</body>

</html>