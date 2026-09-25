<?php

// Save poem as a plain text file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $poem = $_POST['poem'] ?? '';

    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="poem.txt"');

    echo $poem;
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PLP Poetry Editor</title>

<link rel="stylesheet" href="css/editor.css">

</head>

<body>

<div class="editor-container">

<form method="post">

    <div class="toolbar">

        <button type="button"
                onclick="document.getElementById('poem').value = '';">
            New
        </button>

        <button type="submit">
            Save
        </button>

    </div>


    <div class="page">

        <textarea
            id="poem"
            name="poem"
            placeholder= "/n Start writing..."
        ></textarea>

    </div>

</form>

</div>

</body>

</html>
