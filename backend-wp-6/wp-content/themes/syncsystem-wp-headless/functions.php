<?php
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue block editor assets
function syncsystem_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'syncsystem-blocks',
        get_template_directory_uri() . '/build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor')
    );
}
add_action('enqueue_block_editor_assets', 'syncsystem_enqueue_block_editor_assets');

// Add theme support for required features
function syncsystem_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('custom-spacing');

    // Essential for Gutenberg
    add_theme_support('editor-color-palette');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-units');
}
add_action('after_setup_theme', 'syncsystem_theme_setup');

// Disable front-end styles and scripts since this is a headless theme
function syncsystem_disable_frontend_styles() {
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
}
add_action('wp_enqueue_scripts', 'syncsystem_disable_frontend_styles', 100);
