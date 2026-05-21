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
 * @author     Raunak Gupta <hello@techunfiltered.dev>
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
        add_action('init', array($this, 'registerBlock'));

        // Admin
        if ($isAdmin)
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'), 10);
            add_action('admin_notices', array($this, 'maybeShowReviewNotice'));
            add_action('wp_ajax_vaaky_review_notice', array($this, 'handleReviewNoticeAjax'));
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

        $screen = get_current_screen();
        if ($screen && false !== strpos($screen->id, 'vaaky-highlighter')) {
            wp_enqueue_style(
                $this->pluginSlug . '-theme-picker',
                plugin_dir_url(__FILE__) . 'css/theme-picker.css',
                array(),
                $this->version
            );
        }
    }

    /**
     * Register the Gutenberg block via block.json.
     *
     * @since   1.2.0
     */
    public function registerBlock()
    {
        register_block_type(plugin_dir_path(dirname(__FILE__)));
    }

    /**
     * Show a review request notice on the plugin's settings page after 7 days.
     *
     * @since   1.2.0
     */
    public function maybeShowReviewNotice()
    {
        $state = get_option('vaaky_review_notice_state', 'pending');
        if ($state === 'dismissed') {
            return;
        }

        $activatedAt = (int) get_option('vaaky_activated_at', time());
        $remindAt    = (int) get_option('vaaky_review_notice_remind_at', 0);
        $now         = time();

        if ($state === 'later' && $now < $remindAt) {
            return;
        }
        if ($state === 'pending' && ($now - $activatedAt) < (7 * DAY_IN_SECONDS)) {
            return;
        }

        $screen = get_current_screen();
        if (!$screen || false === strpos($screen->id, 'vaaky-highlighter')) {
            return;
        }

        wp_enqueue_script(
            $this->pluginSlug . '-review-notice',
            plugin_dir_url(__FILE__) . 'js/review-notice.js',
            array(),
            $this->version,
            true
        );
        include plugin_dir_path(__FILE__) . 'partials/review-notice.php';
    }

    /**
     * Handle AJAX request for the review notice decision.
     *
     * @since   1.2.0
     */
    public function handleReviewNoticeAjax()
    {
        check_ajax_referer('vaaky_review_notice');
        if (!current_user_can('manage_options')) {
            wp_send_json_error('', 403);
        }
        $decision = isset($_POST['decision']) ? sanitize_text_field(wp_unslash($_POST['decision'])) : '';
        if ($decision === 'later') {
            update_option('vaaky_review_notice_state', 'later');
            update_option('vaaky_review_notice_remind_at', time() + (14 * DAY_IN_SECONDS));
        } else {
            update_option('vaaky_review_notice_state', 'dismissed');
        }
        wp_send_json_success();
    }

}