<?php

namespace VaakyHighlighter\Includes;

use VaakyHighlighter\Admin\Settings;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 *
 * It is used to prepare custom files, tables, or any other things that the plugin may need
 * before it actually executes, and that it needs to remove upon uninstallation.
 * 
 * @since      1.0.0
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Includes
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class Activator
{

    /**
     * Main method called on plugin activation
     *
     * @param   bool    $networkWide                Plugin is network-wide activated or not.
     * @param   array   $configuration              The plugin's configuration data.
     * @param   string  $configurationOptionName    The ID for the configuration options in the database.
     * @since   1.0.0
     */
    public static function activate($networkWide, $configuration, $configurationOptionName)
    {
        // Initialize default configuration values. If exist doesn't do anyting.
        // If single site, it is saved in the option table. If multisite, it is saved in the sitemeta table.
        add_network_option(get_current_network_id(), $configurationOptionName, $configuration);

        // If Multisite is enabled, the configuration data is saved as network option.
        if (is_multisite())
        {
            // Network-wide activation
            if ($networkWide)
            {
                // Permission check
                if (!current_user_can('manage_network_plugins'))
                {
                    deactivate_plugins(plugin_basename(__FILE__));
                    // Localization class hasn't been loaded yet.
                    wp_die(__('You don\'t have proper authorization to activate a plugin!', 'vaaky-highlighter'));
                }

                /**
                 * Network setup
                 */
                // Your Network setup code comes here...

                /**
                 * Site specific setup
                 */
                // Loop through the sites
                foreach (get_sites(['fields' => 'ids']) as $blogId)
                {
                    switch_to_blog($blogId);
                    self::onActivation();
                    restore_current_blog();
                }
            }
        }
        else // Single site activation
        {
            // Permission check
            if (!current_user_can('activate_plugins'))
            {
                deactivate_plugins(plugin_basename(__FILE__));
                // Localization class hasn't been loaded yet.
                wp_die(__('You don\'t have proper authorization to activate a plugin!', 'vaaky-highlighter'));
            }

            self::onActivation();
        }
    }

    /**
     * Activate the newly created site if the plugin was network-wide activated.
     * Hook: wpmu_new_blog
     *
     * @param   int $blogId                ID of the newly created site.
     * @since    1.0.0
     */
    public static function activateNewSite($blogId)
    {
        if (is_plugin_active_for_network('vaaky-highlighter/vaaky-highlighter.php'))
        {
            switch_to_blog($blogId);
            self::onActivation();
            restore_current_blog();
        }
    }

    /**
     * The actual tasks performed during activation of a plugin.
     * Should handle only stuff that happens during a single site activation,
     * as the process will repeated for each site on a Multisite/Network installation
     * if the plugin is activated network wide.
     */
    public static function onActivation()
    {
        $obj = new Settings(VAAKY_HIGHLIGHTER_SLUG);
        $obj->getSettingOptions();
    }

}