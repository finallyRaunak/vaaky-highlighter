<?php

namespace VaakyHighlighter\Includes;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Includes
 * @author     Raunak Gupta <raunak.gupta@webhat.in>
 */
class Deactivator
{
    /**
     * Main method called on plugin deactivation
     *
     * @param   bool    $networkWide                Plugin is network-wide activated or not.
     * @since    1.0.0
     */
    public static function deactivate($networkWide)
    {
        if (is_multisite() && $networkWide)
        {
            // Permission check
            if (!current_user_can('manage_network_plugins'))
            {
                // Localization class hasn't been loaded yet.
                wp_die(__('You don\'t have proper authorization to deactivate a plugin!', 'vaaky-highlighter'));
            }

            // Loop through the sites
            foreach (get_sites(['fields' => 'ids']) as $blogId)
            {
                switch_to_blog($blogId);
                self::onDeactivation();
                restore_current_blog();
            }
        }
        else
        {
            // Permission check
            if (!current_user_can('activate_plugins'))
            {
                // Localization class hasn't been loaded yet.
                wp_die(__('You don\'t have proper authorization to deactivate a plugin!', 'vaaky-highlighter'));
            }

            self::onDeactivation();
        }
    }

    /**
     * The actual tasks performed during deactivation of a plugin.
     * Should handle only stuff that happens during a single site deactivation,
     * as the process will repeated for each site on a Multisite/Network installation
     * if the plugin is deactivated network wide.
     */
    public static function onDeactivation()
    {
        delete_option(VAAKY_HIGHLIGHTER_SLUG . '-settings-option');
        delete_option(VAAKY_HIGHLIGHTER_SLUG . '-configuration');
    }

}