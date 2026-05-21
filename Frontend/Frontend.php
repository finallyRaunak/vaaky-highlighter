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
 * @author     Raunak Gupta <hello@techunfiltered.dev>
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
        $this->extModule  = ['apache', 'bash', 'c', 'cpp', 'csharp', 'css', 'django', 'dns', 'dockerfile', 'dos', 'go', 'handlebars', 'java', 'javascript', 'json', 'markdown', 'nginx', 'objectivec', 'pgsql', 'php', 'plaintext', 'powershell', 'python', 'r', 'ruby', 'rust', 'scss', 'shell', 'sql', 'twig', 'typescript', 'xml', 'yaml'];
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

        $scriptLineNumbersId = $this->pluginSlug . '-line-numbers';
        $scriptCoreId        = $this->pluginSlug . '-frontend';
        $scriptCoreUrl       = $scriptBaseUrl . 'core.js';

        if (wp_register_script($scriptId, $scriptUrl, array('jquery'), $this->version, false) === false)
        {
            exit(esc_html__('Script could not be registered: ', 'vaaky-highlighter') . $scriptUrl);
        }

        // Line numbers plugin — must load BEFORE core.js so hljs.initLineNumbersOnLoad is defined when core runs.
        wp_register_script(
            $scriptLineNumbersId,
            $scriptBaseUrl . 'line-numbers.min.js',
            array($scriptId),
            $this->version,
            false
        );

        // core.js — depends on both hljs core and the line-numbers plugin so the load order is deterministic.
        if (wp_register_script($scriptCoreId, $scriptCoreUrl, array($scriptId, $scriptLineNumbersId), $this->version, false) === false)
        {
            exit(esc_html__('Script could not be registered: ', 'vaaky-highlighter') . $scriptCoreUrl);
        }

        foreach ($this->extModule as $lang)
        {
            wp_register_script($this->pluginSlug . '-hljs-' . $lang, $scriptBaseUrl . $lang . '.min.js', array($scriptId), $this->version, false);
        }

        wp_register_script(
            $this->pluginSlug . '-copy-button',
            $scriptBaseUrl . 'copy-button.js',
            array($scriptCoreId),
            $this->version,
            true
        );
    }

    public function codeBlockShortcode($atts = array(), $content = null, $tag = 'vaakyHighlighterCode')
    {
        $codeClass = [];
        $atts      = array_change_key_case((array) $atts, CASE_LOWER);
        $shAtts    = shortcode_atts(
                array(
                    'lang'        => '',
                    'filename'    => '',
                    'linenumbers' => '', // '' = use global default, '0' or '1' = explicit
                    'wrap'        => '', // '' = use global default, '0' or '1' = explicit
                ), $atts, $tag
        );

        $showLineNumbers = ($shAtts['linenumbers'] === '')
            ? $this->settings->getDefaultLineNumbers()
            : ($shAtts['linenumbers'] === '1');

        $wordWrap = ($shAtts['wrap'] === '')
            ? $this->settings->getDefaultWordWrap()
            : ($shAtts['wrap'] === '1');

        $overflow  = $this->settings->getTextOverflow();

        $this->enqueueNeededAssets(
            !empty($shAtts['lang']) ? $shAtts['lang'] : null,
            $showLineNumbers
        );

        $codeClass[] = ($overflow == 'new-line') ? 'vaaky-line-break' : '';
        $codeClass[] = (!empty($shAtts['lang']) ? ('language-' . $shAtts['lang'] ) : '' );

        if ($wordWrap) {
            $codeClass[] = 'vaaky-line-break';
        }

        $preClass = [];
        if ($showLineNumbers) {
            $preClass[] = 'vaaky-line-numbers';
        }

        $o = '<div class="vaaky-highlighter-wrap">';
        if (!empty($shAtts['filename'])) {
            $o .= '<div class="vaaky-filename">' . esc_html($shAtts['filename']) . '</div>';
        }
        $o .= '<pre class="' . esc_attr(implode(' ', array_filter($preClass))) . '">';
        $o .= '<code class="' . esc_attr(implode(' ', array_filter($codeClass))) . '">';

        // enclosing tags
        if (!is_null($content))
        {
            // secure output by executing the_content filter hook on $content
            $o .= apply_filters('the_content', $content);
        }

        // end box
        $o .= '</code>';
        $o .= '</pre>';
        $o .= '</div>'; // close .vaaky-highlighter-wrap

        return $o;
    }

    /**
     * Enqueue CSS and JS needed by specific short code block
     * 
     * @param string $lang
     * @since 1.0.1
     */
    private function enqueueNeededAssets($lang = null, $needLineNumbers = false)
    {
        //Loading the style
        wp_enqueue_style($this->pluginSlug . '-theme');
        wp_enqueue_style($this->pluginSlug . '-frontend');

        //Loading the scripts — '-line-numbers' is a registered dependency of '-frontend',
        //so enqueueing '-frontend' transitively enqueues '-hljs' AND '-line-numbers' in the right order.
        wp_enqueue_script($this->pluginSlug . '-frontend');

        if (!empty($lang) && in_array($lang, $this->extModule))
        {
            wp_enqueue_script($this->pluginSlug . '-hljs-' . $lang);
        }

        wp_enqueue_script($this->pluginSlug . '-copy-button');
    }

}
