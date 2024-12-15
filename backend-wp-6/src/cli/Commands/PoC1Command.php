<?php

namespace SyncSystem\CLI\Commands;

use WP_CLI;

/**
 * Example command for proof of concept.
 */
class PoC1Command {
    /**
     * Says hello to the specified user.
     *
     * ## OPTIONS
     *
     * <name>
     * : The name of the user
     *
     * [--greeting=<greeting>]
     * : Custom greeting to use
     * ---
     * default: Hello
     * ---
     *
     * ## EXAMPLES
     *
     *     # Basic usage
     *     $ wp poc1 hello John
     *     Hello, John!
     *
     *     # Custom greeting
     *     $ wp poc1 hello John --greeting="Hi"
     *     Hi, John!
     */
    public function hello($args, $assoc_args) {
        $name = $args[0];
        $greeting = $assoc_args['greeting'];

        WP_CLI::success("$greeting, $name!");
    }
}

WP_CLI::add_command('poc1', 'SyncSystem\CLI\Commands\Poc1Command');
