<div class="return-home-container">
    <a href="/index.php" class="btn-return-home">← Return to Home</a>
</div>


/* --- RETURN HOME BUTTON --- */
.return-home-container {
    display: flex; /* 1. Layout */
    justify-content: flex-start; /* 1. Layout - Adjust to center or flex-end if desired */
    width: 100%; /* 2. Size */
    margin: 0 auto 30px auto; /* 3. Spacing - Bottom margin gives breathing room */
}

.btn-return-home {
    display: inline-block; /* 1. Layout */
    padding: 12px 20px; /* 3. Spacing */
    border: 1px solid darkblue; /* 4. Border */
    border-radius: 6px; /* 4. Border */
    background-color: rgba(255, 243, 205, 0.8); /* 5. Background - Pulls global warm tone */
    color: darkblue; /* 6. Text */
    font-size: 1.05rem; /* 6. Text */
    font-weight: bold; /* 6. Text */
    text-decoration: none; /* 6. Text */
    transition: background-color 0.2s ease, color 0.2s ease; /* 7. Effects */
}

.btn-return-home:hover {
    background-color: black; /* 5. Background */
    color: white; /* 6. Text */
}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standalone Page</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

    <main>
        <!-- PULL IN THE HOME RETURN BUTTON -->
        <?php include 'includes/home-button.php'; ?>

        <h1>Welcome to this Standalone Page</h1>
        <p>This page has no complex navigation, but allows the user to easily head back home.</p>
    </main>

</body>
</html>


