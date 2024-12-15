<?php
/**
 * Plugin Name: CLI Commands Loader
 * Description: Loads custom WP-CLI commands
 */

if (defined('WP_CLI') && WP_CLI) {
    require_once dirname(dirname(__DIR__)) . '/src/cli/Commands/PoC1Command.php';
}
