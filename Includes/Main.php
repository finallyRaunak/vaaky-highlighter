<?php

namespace VaakyHighlighter\Includes;

use VaakyHighlighter\Includes\I18n;
use VaakyHighlighter\Admin\Admin;
use VaakyHighlighter\Admin\Settings;
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

        /**
         * Includes objects - Register all of the hooks related both to the admin area and to the public-facing functionality of the plugin.
         */
        $i18n = new I18n($this->pluginSlug);
        $i18n->initializeHooks();

        // The Settings' hook initialization runs on Admin area only.
        $settings = new Settings($this->pluginSlug);

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
        /**
         * Only for plugin development purpose, DO NOT uncomment it on production server.
         */
//        add_action('template_redirect', array($this, 'updateCSSFromCDN'), 10);
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
    
    /**
     * Updated all the css (/Frontend/css/) from CDN lib of highlightjs
     * It is only used during the development time not for production use.
     */
//    public function updateCSSFromCDN()
//    {
//        $cdnPath = "https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@" . VAAKY_HIGHLIGHTER_HLJS_VERSION . "/build/styles/";
//        $files   = scandir(VAAKY_HIGHLIGHTER_PLUGIN_PATH . '/Frontend/css/');
//        var_dump($files);
//        
//        foreach ($files as $filename)
//        {
//            $ext = pathinfo($filename, PATHINFO_EXTENSION);
//            if (($ext != 'css') || ($filename == 'core.css'))
//            {
//                continue;
//            }
//            echo $filename . '<br/>';
//            $temp = file_get_contents($cdnPath . $filename);
//            file_put_contents(VAAKY_HIGHLIGHTER_PLUGIN_PATH . '/Frontend/css/' . $filename, $temp);
//        }
//    }
}