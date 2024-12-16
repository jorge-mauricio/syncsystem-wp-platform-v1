<?php
// Minimal index.php file - required for theme
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div>
        <h1>Headless WordPress Theme</h1>
        <p>This theme is designed for headless WordPress. Please access the content through the API.</p>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
