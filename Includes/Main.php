<?php

namespace VaakyHighlighter\Includes;

use VaakyHighlighter\Includes\I18n;
use VaakyHighlighter\Admin\Admin;
use VaakyHighlighter\Admin\Settings;
use VaakyHighlighter\Admin\NetworkSettings;
use VaakyHighlighter\Frontend\Frontend;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Includes
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class Main
{
    /**
     * The unique identifier of this plugin.
     * 
     * @var string
     * @since    1.0.0
     */
    protected $pluginSlug;

    /**
     * The current version of the plugin.
     * 
     * @var string
     * @since    1.0.0
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     * 
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->version = VAAKY_HIGHLIGHTER_VERSION;
        $this->pluginSlug = VAAKY_HIGHLIGHTER_SLUG;
    }

    /**
     * Create the objects and register all the hooks of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineHooks()
    {
        $isAdmin = is_admin();
        $isNetworkAdmin = is_network_admin();

        /**
         * Includes objects - Register all of the hooks related both to the admin area and to the public-facing functionality of the plugin.
         */
        $i18n = new I18n($this->pluginSlug);
        $i18n->initializeHooks();

        // The Settings' hook initialization runs on Admin area only.
        $settings = new Settings($this->pluginSlug);


        /**
         * Network Admin objects - Register all of the hooks related to the network admin area functionality of the plugin.
         */
        if ($isNetworkAdmin)
        {
            $networkSettings = new NetworkSettings($this->pluginSlug);
            $networkSettings->initializeHooks($isNetworkAdmin);
        }

        /**
         * Admin objects - Register all of the hooks related to the admin area functionality of the plugin.
         */
        if ($isAdmin)
        {
            $admin = new Admin($this->pluginSlug, $this->version, $settings);
            $admin->initializeHooks($isAdmin);

            $settings->initializeHooks($isAdmin);
        }
        /**
         * Frontend objects - Register all of the hooks related to the public-facing functionality of the plugin.
         */
        else
        {
            $frontend = new Frontend($this->pluginSlug, $this->version, $settings);
            $frontend->initializeHooks($isAdmin);
        }
    }

    /**
     * Run the plugin.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->defineHooks();
    }
}