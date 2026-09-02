<?php
// header.php
// Common page header for WIMS website
?>

<?php
// header.php
// Common header for WIMS

if (!isset($pageTitle)) {
    $pageTitle = "Weight Insight Mentoring Service (WIMS)";
}
?>
<!DOCTYPE html>
<html lang="en-IE">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($pageTitle) ?>
    </title>

    <meta 
        name="description" 
        content="Weight Insight Mentoring Service (WIMS) - Measure, Learn and Adapt for sustainable weight change."
    >

    <link rel="stylesheet" href="/Dev/Dev%25201.20/css/my-styles.cs">

</head>

<body>

<header>

    <h1>
        Weight Insight Mentoring Service
    </h1>

    <p>
        Know Thyself • Measure • Learn • Adapt
    </p>

</header>

<?php
include __DIR__ . "/my-menu.php";
?>

<main>