<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WIMS First Post</title>
    <!-- Link to the external newspaper stylesheet -->
    <link rel="stylesheet" href="css/my-style.css" />
</head>
<body>

    <!-- Dynamic Newspaper Masthead Banner -->
    <header class="newspaper-masthead">
        <div class="masthead-top-bar">
            <span>First Post</span>
            <span>
                <?php
                // Set the local timezone to Dublin
                date_default_timezone_set("Europe/Dublin");

                // Automatically format and print the current live date in uppercase
                echo "DUBLIN, " . strtoupper(date("l, F j, Y"));
                ?>
            </span>
            <span>Online Copy</span>
        </div>

        <div class="masthead-main-row">
            <!-- Left Ear: Weather Widget -->
            <div class="masthead-ear left-ear">
                <strong>TODAY</strong><br>
                座️ Rain<br>
                High: 16°C
            </div>

            <!-- Central Publication Title -->
            <h1 class="masthead-title">WIMS DIGEST</h1>

            <!-- Right Ear: Feature Teaser Widget -->
            <div class="masthead-ear right-ear">
                <strong>INSIDE</strong><br>
                Crossword... P. 8<br>
                Coffee Guide... P. 3
            </div>
        </div>

        <div class="masthead-motto">
            "Know Thyself. Measure. Learn. Adapt."
        </div>
    </header>

    <!-- Main Editorial Layout Wrapper -->
    <div class="container">
        
       <!-- Central Main Content Block -->
        <main>
            <!-- Featured Full-Width Video Entry -->
             <a href="https://youtu.be/gX8GAOlV_DM" target="_blank" rel="noopener noreferrer"> "Going For The One" </a>

            <!-- News Column Flow Content -->
            <article class="newspaper-article">
                <h2>LOCAL COFFEE SHOP DISCOVERS SECRET TO PERFECT BREW</h2>

                <p>
                    <strong>DUBLIN, Aug 5</strong> — In a quiet corner of the city, a small independent café has
                    sent shockwaves through the local culinary scene by unveiling what experts are calling the most
                    scientifically perfect cup of coffee ever roasted.
                </p>

                <p>
                    The breakthrough occurred early Tuesday morning after months of quiet experimentation with water
                    temperature variations, precise pressure metrics, and ethically sourced heirloom beans from
                    high-altitude farms.
                </p>

                <p>
                    According to the head barista, the secret lies entirely in a highly unconventional, proprietary
                    filtration technique that balances acidity while maximizing the natural sweetness of the bean.
                </p>

                <p>
                    "We threw out the traditional rules of brewing," the owner stated during a packed press
                    conference outside the shop this morning. "We wanted to create a flavor profile that challenges
                    the palate while remaining incredibly smooth."
                </p>

                <p>
                    Local residents queued around the block today to secure a taste of the new beverage, with the
                    initial batch selling out completely in under two hours.
                </p>

                <p>
                    Food critics have already praised the achievement, noting that the unique aromatic qualities and
                    distinct notes of dark chocolate and citrus could set a brand-new standard for independent
                    coffee roasters worldwide.
                </p>
            </article>
        </main>

    </div>

    <!-- Page Footer -->
    <footer>
        <p>WIMS Digest &copy; 2026 WIMS Digest. All rights reserved.</p>
    </footer>

</body>
</html>
