<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 *
 * @package    VaakyHighlighter
 */
// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN'))
{
    exit;
}

$currentNetworkId = get_current_network_id();
deleteConfigOptions($currentNetworkId);

// If Multisite is enabled, then uninstall the plugin on every site.
if (is_multisite())
{
    // Permission check
    if (!current_user_can('manage_network_plugins'))
    {
        wp_die('You don\'t have proper authorization to delete a plugin!');
    }

    /**
     * Delete the Network options
     */
    deleteNetworkOptions($currentNetworkId);

    /**
     * Delete the site specific options
     */
    foreach (get_sites(['fields' => 'ids']) as $blogId)
    {
        switch_to_blog($blogId);
        // Site specific uninstall code starts here...
        deleteOptions();
        restore_current_blog();
    }
}
else
{
    // Permission check
    if (!current_user_can('activate_plugins'))
    {
        wp_die('You don\'t have proper authorization to delete a plugin!');
    }

    deleteOptions();
}

/**
 * Delete the plugin's configuration data.
 * 
 * @since    1.0.0
 * @param int $currentNetworkId
 * @return void
 */
function deleteConfigOptions($currentNetworkId)
{
    delete_network_option($currentNetworkId, 'vaaky-highlighter-configuration');
}

/**
 * Delete the plugin's network options.
 * 
 * @since    1.0.0
 * @param int $currentNetworkId
 * @return void
 */
function deleteNetworkOptions($currentNetworkId)
{
    delete_network_option($currentNetworkId, 'vaaky-highlighter-network-general');
}

/**
 * Delete the plugin's options.
 *
 * @since    1.0.0
 */
function deleteOptions()
{
    delete_option('vaaky-highlighter-general');
    delete_option('vaaky-highlighter-example');
}
