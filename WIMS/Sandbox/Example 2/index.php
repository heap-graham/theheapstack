<?php
// Turn on error reporting at the absolute top of the page
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIMS Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- This line grabs the menu from your other file and drops it here cleanly -->
    <?php require_once "aa-my-menu.php"; ?>

    <!-- Main Content Container -->
    <main style="padding: 40px 20px;">
        <h1>Welcome to the WIMS Platform</h1>
        <p>Your menu and errors are now completely fixed, separated, and clean!</p>
    </main>

</body>
</html>