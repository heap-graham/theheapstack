<!doctype html>
<!-- Test 11 June 2026 -->

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>WIMS - About Graham</title>

        <meta name="description" content="Know Thyself. Measure. Learn. Adapt." />

        <meta property="og:title" content="WIMS - About Graham" />
        <meta property="og:description" content="Know Thyself. Measure. Learn. Adapt." />
        <meta property="og:url" content="test.theheapstack.com/" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Weight Insight Mentor" />

        <meta property="og:image" content="https://test.theheapstack.com/images/ths-wim-logo-s.jpg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="1069" />
        <meta property="og:image:alt" content="Weight Insight Mentor logo and branding" />

        <!-- Updated path to use your clean, standardized stylesheet -->
        <link rel="stylesheet" href="css/my-styles2.css" />
    </head>

    <body>
        <?php include "WPS1-menu.php"; ?>
        <!-- Main acts as your container wrapper now -->
        <main>
            <!-- Standard graphic box tag replaces .image-box div -->
            <figure>
                <img src="images/ths-wim-logo-s.jpg" alt="Main Website Picture" />
            </figure>

            <!-- Semantic header wrapper for perfect title centering -->
            <header>
                <h1>Weight Insight Mentor</h1>
                <p><strong>Know Thyself <br />Measure. Learn. Adapt.</strong></p>
            </header>

            <!-- Your CSS automatically centers h2 headings globally -->
            <h2>About Graham</h2>

            <p>My background includes project management, research, teaching and lifelong learning.</p>

            <p>
                My interest in weight insight developed through my own experiences with weight change and a desire to
                better understand how the choices we make every day influence our wellbeing. The ideas presented here
                are based on personal experience, observation, measurement and continuous learning.
            </p>
            
             <!-- PULL IN THE HOME RETURN BUTTON -->
            <?php include 'includes/home-button.php'; ?>        
            <!-- Replaced .footer div with standard HTML5 footer element -->
            <footer>
                    <?php include "WPZ1-my-footer.php"; ?>
            </footer>
        </main>
    </body>
</html>
