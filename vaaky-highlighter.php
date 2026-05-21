<?php

/**
 * Vaaky Highlighter - Syntax Highlighter for Gutenberg
 *
 * @since             1.0.0
 * @package           VaakyHighlighter
 *
 * @wordpress-plugin
 * Plugin Name:       Vaaky Highlighter - Syntax Highlighter for Gutenberg
 * Plugin URI:        https://wordpress.org/plugins/vaaky-highlighter/
 * Description:       Lightweight syntax highlighter for Gutenberg powered by Highlight.js. Add fast, beautiful, and responsive code blocks with automatic language detection.
 * Version:           1.1.0
 * Author:            Raunak Gupta
 * Author URI:        https://techunfiltered.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vaaky-highlighter
 * Domain Path:       /languages
 * Requires PHP:      5.6
 */

namespace VaakyHighlighter;

use VaakyHighlighter\Includes\Activator;
use VaakyHighlighter\Includes\Deactivator;
use VaakyHighlighter\Includes\Main;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

// Autoloader
require_once plugin_dir_path(__FILE__) . 'Autoloader.php';

/**
 * Current plugin version.
 */
define('VAAKY_HIGHLIGHTER_VERSION', '1.1.0');

/**
 * The string used to uniquely identify this plugin.
 */
define('VAAKY_HIGHLIGHTER_SLUG', 'vaaky-highlighter');

/**
 * plugin dir path
 */
define('VAAKY_HIGHLIGHTER_PLUGIN_PATH', dirname(__FILE__));

/**
 * plugin dir base path
 */
define('VAAKY_HIGHLIGHTER_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * highlightjs version
 * @link: https://github.com/highlightjs/highlight.js/releases
 */
define('VAAKY_HIGHLIGHTER_HLJS_VERSION', '11.11.1');

/**
 * Configuration data
 *  - db-version:   Start with 0 and increment by 1. It should not be updated with every plugin update,
 *                  only when database update is required.
 */
$configuration = array(
    'version'    => VAAKY_HIGHLIGHTER_VERSION,
    'db-version' => 0
);

/**
 * The ID for the configuration options in the database.
 */
$configurationOptionName = VAAKY_HIGHLIGHTER_SLUG . '-configuration';

/**
 * The code that runs during plugin activation.
 * This action is documented in Includes/Activator.php
 */
register_activation_hook(__FILE__, function($networkWide) use($configuration, $configurationOptionName)
{
    Activator::activate($networkWide, $configuration, $configurationOptionName);
});

/**
 * Run the activation code when a new site is created.
 */
add_action('wpmu_new_blog', function($blogId)
{
    Activator::activateNewSite($blogId);
});

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Includes/Deactivator.php
 */
register_deactivation_hook(__FILE__, function($networkWide)
{
    Deactivator::deactivate($networkWide);
});

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function vaakyHighlighterStart()
{
    $plugin = new Main();
    $plugin->run();
}

vaakyHighlighterStart();