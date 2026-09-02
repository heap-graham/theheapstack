<!doctype html>
<!-- Test 11 June 2026 -->

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Weight Insight Mentor - Contact</title>

        <meta name="description" content="Know Thyself. Measure. Learn. Adapt." />

        <meta property="og:title" content="Weight Insight Mentor" />
        <meta property="og:description" content="Know Thyself. Measure. Learn. Adapt." />
        <meta property="og:url" content="test.theheapstack.com/" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Weight Insight Mentor" />

        <meta property="og:image" content="https://test.theheapstack.com/images/ths-wim-logo-s.jpg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="1069" />
        <meta property="og:image:alt" content="Weight Insight Mentor logo and branding" />

        <!-- Updated path to use your clean, standardized stylesheet -->
        <link rel="stylesheet" href="css/my-styles.css" />
    </head>

    <body>
        <!-- Top navigation menu bar -->
        <?php include "includes/my-menu.php"; ?>

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

            <h2>Contact</h2>
            <p>Email: graham@theheapstack.com</p>
            <p>
                <!-- Clean link without inline styles -->
                LinkedIn: <a href="https://www.linkedin.com/in/heapgraham/">Graham Heap</a>
            </p>

            <h2>Contact Form</h2>
            <form action="https://formsubmit.co/graham@theheapstack.com" method="POST">
                <!-- Name Field -->
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required placeholder="Your Name" />

                <!-- Email Field -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Your Email" />

                <!-- Message Field -->
                <label for="message">Message:</label>
                <textarea id="message" name="message" required placeholder="Type your message here"></textarea>

                <!-- Submit Button -->
                <button type="submit">Send Message</button>
            </form>
            
            <hr />

            <!-- Replaced .footer div with standard HTML5 footer element -->
           <footer>
                <?php include "includes/my-footer.php"; ?>
        </footer>
        </main>
    </body>
</html>
