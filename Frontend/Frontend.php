<?php

namespace VaakyHighlighter\Frontend;

use VaakyHighlighter\Admin\Settings;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * The frontend functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend stylesheet and JavaScript.
 *
 * @since      1.0.0
 *
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Frontend
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class Frontend
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
     * The settings of this plugin.
     *
     * @var Settings
     * @since    1.0.0
     */
    private $settings;

    /**
     * List of all extra modules of highlightjs which are not bundled with core
     *
     * @var array
     * @since 1.0.1
     */
    private $extModule;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     * @param   string  $pluginSlug The name of the plugin.
     * @param   string  $version    The version of this plugin.
     * @param   Settings    $settings   The Settings object.
     */
    public function __construct($pluginSlug, $version, $settings)
    {
        $this->pluginSlug = $pluginSlug;
        $this->version    = $version;
        $this->settings   = $settings;
        $this->extModule  = ['apache', 'dns', 'django', 'dockerfile', 'handlebars', 'nginx', 'pgsql', 'powershell', 'twig', 'dos'];
    }

    /**
     * Register all the hooks of this class.
     *
     * @since    1.0.0
     * @param   bool    $isAdmin    Whether the current request is for an administrative interface page.
     */
    public function initializeHooks($isAdmin)
    {
        // Frontend
        if (!$isAdmin)
        {
            add_action('wp_enqueue_scripts', array($this, 'registerStyles'), 10);
            add_action('wp_enqueue_scripts', array($this, 'registerScripts'), 10);

            add_shortcode('vaakyHighlighterCode', array($this, 'codeBlockShortcode'));
        }
    }

    /**
     * Register the stylesheets for the frontend side of the site.
     *
     * @since    1.0.0
     */
    public function registerStyles()
    {
        $styleBaseUrl = plugin_dir_url(__FILE__) . 'css/';

        $styleId  = $this->pluginSlug . '-theme';
        $styleUrl = $styleBaseUrl . $this->settings->getTheme() . '.min.css';

        $styleCoreId  = $this->pluginSlug . '-frontend';
        $styleCoreUrl = $styleBaseUrl . 'core.css';

        if ((wp_register_style($styleId, $styleUrl, array(), $this->version, 'all') === false) || (wp_register_style($styleCoreId, $styleCoreUrl, array($styleId), $this->version, 'all') === false))
        {
            exit(esc_html__('Style could not be registered: ', 'vaaky-highlighter') . $styleUrl);
        }

        //Loading the style
        wp_enqueue_style($this->pluginSlug . '-theme');
        wp_enqueue_style($this->pluginSlug . '-frontend');
    }

    /**
     * Register the JavaScript for the frontend side of the site.
     *
     * @since    1.0.0
     */
    public function registerScripts()
    {
        $scriptBaseUrl = plugin_dir_url(__FILE__) . 'js/';

        $scriptId  = $this->pluginSlug . '-hljs';
        $scriptUrl = $scriptBaseUrl . 'highlight.min.js';

        $scriptCoreId  = $this->pluginSlug . '-frontend';
        $scriptCoreUrl = $scriptBaseUrl . 'core.js';

        if ((wp_register_script($scriptId, $scriptUrl, array('jquery'), $this->version, false) === false) || (wp_register_script($scriptCoreId, $scriptCoreUrl, array($scriptId), $this->version, false) === false))
        {
            exit(esc_html__('Script could not be registered: ', 'vaaky-highlighter') . $scriptUrl);
        }

        foreach ($this->extModule as $lang)
        {
            wp_register_script($this->pluginSlug . '-hljs-' . $lang, $scriptBaseUrl . $lang . '.min.js', array($scriptId), $this->version, false);
        }
    }

    public function codeBlockShortcode($atts = array(), $content = null, $tag = 'vaakyHighlighterCode')
    {
        $codeClass = [];
        $atts      = array_change_key_case((array) $atts, CASE_LOWER);
        $shAtts    = shortcode_atts(
                array(
                    'lang' => '',
                ), $atts, $tag
        );
        $overflow  = $this->settings->getTextOverflow();

        $this->enqueueNeededAssets(!empty($shAtts['lang']) ? $shAtts['lang'] : null );

        $codeClass[] = ($overflow == 'new-line') ? 'vaaky-line-break' : '';
        $codeClass[] = (!empty($shAtts['lang']) ? ('language-' . $shAtts['lang'] ) : '' );
        $o           = '<pre>';
        $o           .= '<code class="' . implode(' ', $codeClass) . '">';

        // enclosing tags
        if (!is_null($content))
        {
            // secure output by executing the_content filter hook on $content
            $o .= apply_filters('the_content', $content);
        }

        // end box
        $o .= '</code>';
        $o .= '</pre>';
        $o .= '<div class="vaaky-toolbar">';
        if (!empty($this->settings->getCodeCopyBtn()))
        {
            $o .= '<button class="vaaky-btn vaaky-copy-btn" title="' . __('Copy to Clipboard', 'vaaky-highlighter') . '"><span>' . __('Copy', 'vaaky-highlighter') . '</span></button>';
        }
        if (!empty($this->settings->getAttributionBtn()))
        {
            $o .= '<button class="vaaky-btn vaaky-website-btn" title="' . __('Visit Vaaky Highlighter Website', 'vaaky-highlighter') . '">' . __('Website', 'vaaky-highlighter') . '</button>';
        }
        $o .= '</div>';

        return $o;
    }

    /**
     * Enqueue CSS and JS needed by specific short code block
     * 
     * @param string $lang
     * @since 1.0.1
     */
    private function enqueueNeededAssets($lang = null)
    {
        //Loading the style
        wp_enqueue_style($this->pluginSlug . '-theme');
        wp_enqueue_style($this->pluginSlug . '-frontend');

        //Loading the scripts
        wp_enqueue_script($this->pluginSlug . '-hljs');
        wp_enqueue_script($this->pluginSlug . '-frontend');

        if (!empty($lang) && in_array($lang, $this->extModule))
        {
            wp_enqueue_script($this->pluginSlug . '-hljs-' . $lang);
        }
    }

}
