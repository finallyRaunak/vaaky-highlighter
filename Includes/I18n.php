<?php

namespace VaakyHighlighter\Includes;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Includes
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class I18n
{
    /**
     * Unique identifier for retrieving translated strings.
     * 
     * @var string
     * @since    1.0.0
     */
    protected $domain;

    /**
     * Initialize the text domain for i18n.
     *
     * @since    1.0.0
     * @param   string $domain Textdomain ID.
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }
    
    /**
     * Register all the hooks of this class.
     *
     * @since    1.0.0
     */
    public function initializeHooks()
    {
        add_action('plugins_loaded', array($this, 'loadPluginTextdomain'), 10);
    }
    
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {
        if (load_plugin_textdomain($this->domain, false, dirname(dirname(plugin_basename(__FILE__ ))) . '/Languages/') === false)
        {           
            //exit('Textdomain could not be loaded from: ' . dirname(dirname(plugin_basename(__FILE__ ))) . '/Languages/');
        }
    }
}