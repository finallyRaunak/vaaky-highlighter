<?php

namespace VaakyHighlighter\Admin;

use VaakyHighlighter\Admin\SettingsBase;
use VaakyHighlighter\Admin\SettingsTrait;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * Settings of the admin area.
 * Add the appropriate suffix constant for every field ID to take advantage the standardized sanitizer.
 *
 * @since      1.0.0
 *
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Admin
 */
class Settings extends SettingsBase
{

    use SettingsTrait;

    /**
     * The ID of this plugin.
     * 
     * @var string
     * @since    1.0.0
     */
    private $pluginSlug;

    /**
     * The slug name for the menu.
     * Should be unique for this menu page and only include
     * lowercase alphanumeric, dashes, and underscores characters to be compatible with sanitize_key().
     *
     * @var string
     * @since    1.0.0
     */
    private $menuSlug;

    /**
     * @since    1.0.0
     * @var array General settings'.
     */
    private $settingOptions;

    /**
     * General settings' section.
     * The slug-name of the section of the settings page in which to show the box.
     *
     * @since    1.0.0
     * @var string
     */
    private $appearanceSettingsSectionId;
    private $toolbarSettingsSectionId;

    /**
     * @var string General settings page.
     * The slug-name of the settings page on which to show the section.
     *
     * @since    1.0.0
     */
    private $settingsPage;

    /**
     * @var string Name of general options. Expected to not be SQL-escaped.
     *
     * @since    1.0.0
     */
    private $settingOptionName;

    /**
     * Ids of setting fields.
     */
    private $themeId;
    private $textOverflowId;
    private $codeCopyBtnId;
    private $allowAttributionBtnId;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string $pluginSlug       The name of this plugin.
     */
    public function __construct($pluginSlug)
    {
        $this->pluginSlug         = $pluginSlug;
        $this->menuSlug           = $this->pluginSlug;
        $this->settingsPage       = $this->pluginSlug . '-settings';
        $this->settingOptionGroup = $pluginSlug . '-settings-option-group';
        $this->settingOptionName  = $pluginSlug . '-settings-option';

        /**
         * Appearance Config
         */
        $this->appearanceSettingsSectionId = $pluginSlug . '-appearance-section';

        $this->themeId        = 'theme-appearance' . self::SELECT_SUFFIX;
        $this->textOverflowId = 'text-overflow-appearance' . self::RADIO_SUFFIX;

        /**
         * Toolbar Config
         */
        $this->toolbarSettingsSectionId = $pluginSlug . '-toolbar-section';

        $this->codeCopyBtnId         = 'code-copy-btn-toolbar' . self::CHECKBOX_SUFFIX;
        $this->allowAttributionBtnId = 'attribution-btn-toolbar' . self::CHECKBOX_SUFFIX;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since 1.0.0
     * @param bool  $isAdmin Whether the current request is for an administrative interface page.
     */
    public function initializeHooks($isAdmin)
    {
        // Admin
        if ($isAdmin)
        {
            add_action('admin_menu', array($this, 'setupSettingsMenu'), 10);
            add_action('admin_init', array($this, 'initializeGeneralOptions'), 10);
            add_filter('plugin_action_links_' . VAAKY_HIGHLIGHTER_PLUGIN_BASENAME, array($this, 'buildActionLinks'));
        }
    }

    public function buildActionLinks($actions)
    {
        $actions[] = '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=' . $this->menuSlug)) . '">' . __('Settings', 'vaaky-highlighter') . '</a>';
//        $actions[] = '<a href="#" target="_blank">' . __('Documentation', 'vaaky-highlighter') . '</a>';
        return $actions;
    }

    /**
     * This function introduces the plugin options into the Main menu.
     */
    public function setupSettingsMenu()
    {
        //Add the menu item to the Main menu
        add_options_page(
                __('Vaaky Highlighter Settings', 'vaaky-highlighter'), // Page title: The title to be displayed in the browser window for this page.
                __('Vaaky Highlighter', 'vaaky-highlighter'), // Menu title: The text to be used for the menu.
                'manage_options', // Capability: The capability required for this menu to be displayed to the user.
                $this->menuSlug, // Menu slug: The slug name to refer to this menu by. Should be unique for this menu page.
                array($this, 'renderSettingsPageContent') // Callback: The name of the function to call when rendering this menu's page
        );
    }

    /**
     * Renders the Settings page to display for the Settings menu defined above.
     *
     * @since   1.0.0
     */
    public function renderSettingsPageContent()
    {
        // Check user capabilities
        if (!current_user_can('manage_options'))
        {
            return;
        }

        // Add error/update messages
        // check if the user have submitted the settings. Wordpress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated']))
        {
            // Add settings saved message with the class of "updated"
            add_settings_error($this->pluginSlug, $this->pluginSlug . '-message', __('Settings saved.', 'vaaky-highlighter'), 'success');
        }

        // Show error/update messages
        settings_errors($this->pluginSlug);
        ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">

            <h2><?php esc_html_e('Vaaky Highlighter', 'vaaky-highlighter'); ?></h2>

            <form method="post" action="options.php">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content">

                            <?php
                            settings_fields($this->settingOptionGroup);
                            do_settings_sections($this->settingsPage);

                            submit_button();
                            ?>
                        </div>
                        <div id="postbox-container-1" class="postbox-container">
                            <?php include_once VAAKY_HIGHLIGHTER_PLUGIN_PATH . '/Admin/partials/setting-sidebar.php'; ?>
                        </div>
                    </div>
                </div>
            </form>

        </div><!-- /.wrap -->
        <?php
    }

    /**
     * initializing the plugins's input by registering the Sections, Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initializeGeneralOptions()
    {
        $this->getSettingOptions();

        //Appearance Section
//        add_settings_section($this->appearanceSettingsSectionId, __('Appearance', 'vaaky-highlighter'), array($this, 'inputApperanceCallback'), $this->settingsPage);
        add_settings_section($this->appearanceSettingsSectionId, __('Appearance', 'vaaky-highlighter'), array(), $this->settingsPage);

        add_settings_field($this->themeId, __('Theme', 'vaaky-highlighter'), array($this, 'selectThemeCallback'), $this->settingsPage, $this->appearanceSettingsSectionId, array('label_for' => $this->themeId));

        add_settings_field($this->textOverflowId, __('Code Overflow', 'vaaky-highlighter'), array($this, 'radioOverflowCallback'), $this->settingsPage, $this->appearanceSettingsSectionId, array('label_for' => $this->textOverflowId));

        //Toolbar Section
        add_settings_section($this->toolbarSettingsSectionId, __('Toolbar Button', 'vaaky-highlighter'), array(), $this->settingsPage);

        add_settings_field($this->codeCopyBtnId, __('Copy Code', 'vaaky-highlighter'), array($this, 'checkboxCodeCopyBtnCallback'), $this->settingsPage, $this->toolbarSettingsSectionId, array('label_for' => $this->codeCopyBtnId));

        add_settings_field($this->allowAttributionBtnId, __('Attribution Button', 'vaaky-highlighter'), array($this, 'checkboxAttributionBtnCallback'), $this->settingsPage, $this->toolbarSettingsSectionId, array('label_for' => $this->allowAttributionBtnId));

        $registerSettingArguments = array(
            'type'              => 'array',
            'description'       => '',
            'sanitize_callback' => array($this, 'sanitizeOptionsCallback'),
            'show_in_rest'      => false
        );
        register_setting($this->settingOptionGroup, $this->settingOptionName, $registerSettingArguments);
    }

    public function inputApperanceCallback()
    {
        $this->getSettingOptions();
        echo '<p>' . esc_html__('Settings as stored in the database.', 'vaaky-highlighter') . '</p>';
        var_dump($this->settingOptions);
    }

    /**
     * Return the config
     * 
     * @return array
     */
    public function getSettingOptions()
    {
        if (isset($this->settingOptions))
        {
            return $this->settingOptions;
        }

        $this->settingOptions = get_option($this->settingOptionName, array());

        // If the options don't exist, create them.
        if ($this->settingOptions === array())
        {
            $this->settingOptions = $this->defaultInputOptions();
            update_option($this->settingOptionName, $this->settingOptions);
        }

        return $this->settingOptions;
    }

    /**
     * Provides default values for the Input Options.
     *
     * @return array
     */
    private function defaultInputOptions()
    {
        return array(
            $this->themeId               => 'github',
            $this->textOverflowId        => 'scrollbar',
            $this->codeCopyBtnId         => 1,
            $this->allowAttributionBtnId => 1
        );
    }

    public function getTheme()
    {
        $this->settingOptions = $this->getSettingOptions();
        return !empty($this->settingOptions[$this->themeId]) ? $this->settingOptions[$this->themeId] : 'github';
    }

    public function getTextOverflow()
    {
        $this->settingOptions = $this->getSettingOptions();
        return !empty($this->settingOptions[$this->textOverflowId]) ? $this->settingOptions[$this->textOverflowId] : 'scrollbar';
    }

    public function getCodeCopyBtn()
    {
        $this->settingOptions = $this->getSettingOptions();
        return (bool) !empty($this->settingOptions[$this->codeCopyBtnId]) ? $this->settingOptions[$this->codeCopyBtnId] : false;
    }

    public function getAttributionBtn()
    {
        $this->settingOptions = $this->getSettingOptions();
        return (bool) !empty($this->settingOptions[$this->allowAttributionBtnId]) ? $this->settingOptions[$this->allowAttributionBtnId] : false;
    }

}