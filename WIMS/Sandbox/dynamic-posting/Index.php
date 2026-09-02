<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Text Feed</title>
    <style>
        .post-card { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .post-date { color: #666; font-size: 0.85em; }
    </style>
</head>
<body>

    <h1>Latest Updates</h1>
    <div id="feed-container">
        <?php
        $file_path = 'posts.txt';

        // Check if the file exists and is readable
        if (file_exists($file_path) && is_readable($file_path)) {
            
            // Read file into an array, skipping empty lines
            $posts = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Reverse the array to show the newest posts first
            $posts = array_reverse($posts);

            foreach ($posts as $post) {
                // Split the line into variables using the delimiter
                $data = explode('|||', $post);

                // Ensure the line has all 3 required parts to prevent errors
                if (count($data) === 3) {
                    // Sanitize outputs to prevent XSS vulnerabilities
                    $title   = htmlspecialchars($data[0]);
                    $date    = htmlspecialchars($data[1]);
                    $content = htmlspecialchars($data[2]);

                    // Dynamically output the HTML
                    echo "<div class='post-card'>";
                    echo "  <h2>{$title}</h2>";
                    echo "  <p class='post-date'>Posted on: {$date}</p>";
                    echo "  <p>{$content}</p>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>No posts found.</p>";
        }
        ?>
    </div>

</body>
</html>
