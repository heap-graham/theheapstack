<?php
// Define or include your core structural array data mapping here
$menu_items = [
    'ABOUT WIMS' => [
        'url' => 'about-wims.php',
        'children' => [
            'What is WIMS?' => ['url' => 'what-is-wims.php'],
            'Vision & Purpose' => ['url' => 'vision-purpose.php'],
            'WIMS Philosophy' => [
                'url' => 'philosophy.php',
                'children' => [
                    'Know Thyself' => 'philosophy-know-thyself.php',
                    'Measure' => 'philosophy-measure.php',
                    'Learn' => 'philosophy-learn.php',
                    'Adapt' => 'philosophy-adapt.php'
                ]
            ],
            'Weight Insight Mentor' => ['url' => 'weight-insight-mentor.php'],
            'About Graham' => ['url' => 'about-graham.php']
        ]
    ],
    'LEARN' => [
        'url' => 'learn.php',
        'children' => [
            'Getting Started' => ['url' => 'getting-started.php'],
            'Know Thyself' => [
                'url' => 'know-thyself.php',
                'children' => [
                    'Understanding Yourself' => 'understanding-yourself.php',
                    'Habits & Behaviour' => 'habits-behaviour.php',
                    'Environment & Lifestyle' => 'environment-lifestyle.php'
                ]
            ],
            'Measure' => [
                'url' => 'measure.php',
                'children' => [
                    'Why Measure?' => 'why-measure.php',
                    'Measurement as Commitment' => 'measurement-commitment.php',
                    'Building the Measurement Habit' => 'building-habit.php',
                    'Understanding Weight Data' => 'understanding-data.php',
                    'Using the WIMS Tracker' => 'wims-tracker.php'
                ]
            ],
            'Learn' => [
                'url' => 'learn-patterns.php',
                'children' => [
                    'Finding Patterns' => 'finding-patterns.php',
                    'Reviewing Results' => 'reviewing-results.php',
                    'Personal Experiments' => 'personal-experiments.php'
                ]
            ],
            'Adapt' => [
                'url' => 'adapt.php',
                'children' => [
                    'Making Changes' => 'making-changes.php',
                    'Sustainable Habits' => 'sustainable-habits.php',
                    'Maintaining Progress' => 'maintaining-progress.php'
                ]
            ]
        ]
    ],
    'RESOURCES' => [
        'url' => 'resources.php',
        'children' => [
            'Reports' => ['url' => 'reports.php'],
            'Tools' => ['url' => 'tools.php'],
            'Templates' => ['url' => 'templates.php'],
            'Downloads' => ['url' => 'downloads.php']
        ]
    ],
    'ARTICLES & MEDIA' => [
        'url' => 'articles-media.php',
        'children' => [
            'Articles' => ['url' => 'articles.php'],
            'Videos' => ['url' => 'videos.php'],
            'Updates' => ['url' => 'updates.php'],
            'Release Notes' => ['url' => 'release-notes.php']
        ]
    ],
    'MENTORING' => ['url' => 'mentoring.php'],
    'CONTACT' => ['url' => 'contact.php']
];
?>

<nav class="wims-navbar">
    <ul class="wims-menu">
        <?php foreach ($menu_items as $lvl1_title => $lvl1_data): ?>
            <?php $has_lvl2 = isset($lvl1_data['children']); ?>
            <li class="<?php echo $has_lvl2 ? 'has-children' : ''; ?>">
                <a href="<?php echo $lvl1_data['url']; ?>">
                    <?php echo $lvl1_title; ?><?php echo $has_lvl2 ? ' <span class="arrow">▾</span>' : ''; ?>
                </a>
                
                <?php if ($has_lvl2): ?>
                    <ul class="dropdown level-2">
                        <?php foreach ($lvl1_data['children'] as $lvl2_title => $lvl2_data): ?>
                            <?php $has_lvl3 = isset($lvl2_data['children']); ?>
                            <li class="<?php echo $has_lvl3 ? 'has-children' : ''; ?>">
                                <a href="<?php echo $has_lvl3 ? $lvl2_data['url'] : $lvl2_data['url']; ?>">
                                    <?php echo $lvl2_title; ?><?php echo $has_lvl3 ? ' <span class="arrow">▸</span>' : ''; ?>
                                </a>
                                
                                <?php if ($has_lvl3): ?>
                                    <ul class="dropdown level-3">
                                        <?php foreach ($lvl2_data['children'] as $lvl3_title => $lvl3_url): ?>
                                            <li><a href="<?php echo $lvl3_url; ?>"><?php echo $lvl3_title; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIMS Website</title>
    <!-- Include your global multi-level layout stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Insert the menu framework here -->
    <?php require_once 'my-menu.php'; ?>

    <!-- Main Content Container -->
    <main style="padding: 40px 20px;">
        <h1>Welcome to the WIMS Platform</h1>
        <p>Your content goes right here.</p>
    </main>

</body>
</html>