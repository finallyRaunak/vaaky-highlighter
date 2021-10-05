<?php

namespace VaakyHighlighter\Admin;

use VaakyHighlighter\Admin\Settings;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Admin
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class Admin
{
    /**
     * The ID of this plugin.
     * 
     * @var string
     * @since    1.0.0
     */
    private $pluginSlug;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     */
    private $version;

    /**
     * The settings of this plugin.
     *
     * @var Settings
     * @since    1.0.0
     */
    private $settings;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     * @param   string  $pluginSlug     The name of this plugin.
     * @param   string  $version        The version of this plugin.
     * @param   Settings    $settings       The Settings object.
     */
    public function __construct($pluginSlug, $version, $settings)
    {
        $this->pluginSlug = $pluginSlug;
        $this->version    = $version;
        $this->settings   = $settings;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since    1.0.0
     * @param   bool    $isAdmin    Whether the current request is for an administrative interface page.
     */
    public function initializeHooks($isAdmin)
    {
        // Admin
        if ($isAdmin)
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'), 10);
            add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'), 10);
        }
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since   1.0.0
     * @param   string $hook    A screen id to filter the current admin page
     */
    public function enqueueStyles($hook)
    {
        $styleId       = $this->pluginSlug . '-gutenberg';
        $styleUrl      = plugin_dir_url(__FILE__) . 'css/gutenberg.css';
        
        if (wp_register_style($styleId, $styleUrl, array(), $this->version, 'all') === false)
        {
            exit(esc_html__('Style could not be registered: ', 'vaaky-highlighter') . $styleUrl);
        }

        /**
         * If you enque the style here, it will be loaded on every Admin page.
         * To load only on a certain page, use the $hook.
         */
        wp_enqueue_style($styleId);
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since   1.0.0
     * @param   string  $hook    A screen id to filter the current admin page
     */
    public function enqueueScripts($hook)
    {
        $scriptId = $this->pluginSlug . '-gutenberg';

        $scriptUrl = plugin_dir_url(__FILE__) . 'js/gutenberg.js';
        if (wp_register_script($scriptId, $scriptUrl, array('wp-blocks', 'wp-editor'), $this->version, true) === false)
        {
            exit(esc_html__('Script could not be registered: ', 'vaaky-highlighter') . $scriptUrl);
        }

        /**
         * If you enque the script here, it will be loaded on every Admin page.
         * To load only on a certain page, use the $hook.
         */
        wp_enqueue_script($scriptId);
    }

}