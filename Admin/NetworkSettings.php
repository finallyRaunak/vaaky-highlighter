<?php

namespace VaakyHighlighter\Admin;

use VaakyHighlighter\Admin\SettingsBase;
// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

/**
 * Network-wide Settings of the admin area.
 * Add the appropriate suffix constant for every field ID to take advantage the standardized sanitizer.
 *
 * @since      1.0.0
 *
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Admin
 */
class NetworkSettings extends SettingsBase
{
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
     * @since    1.0.0
     */
    private $menuSlug;
    private $networkSettingOptions;

    /**
     * General settings' group name.
     *
     * @since    1.0.0
     */
    private $networkSettingOptionGroup;

    /**
     * General settings' section.
     * The slug-name of the section of the settings page in which to show the box.
     *
     * @since    1.0.0
     */
    private $generalSettingsSectionId;

    /**
     * General settings page.
     * The slug-name of the settings page on which to show the section.
     *
     * @since    1.0.0
     */
    private $generalPage;

    /**
     * Name of general options. Expected to not be SQL-escaped.
     *
     * @since    1.0.0
     */
    private $networkSettingOptionName;

    /**
     * Collection of network options.
     *
     * @since    1.0.0
     */
    private $networkGeneralOptions;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string $pluginSlug       The name of this plugin.
     */
    public function __construct($pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
        $this->menuSlug   = $this->pluginSlug;

        /**
         * General
         */
        $this->settingsPage              = $this->pluginSlug . '-settings';
        $this->networkSettingOptionGroup = $pluginSlug . '-network-settings-option-group';
        $this->networkSettingOptionName  = $pluginSlug . '-network-general';

        /**
         * Appearance Config
         */
        $this->appearanceSettingsSectionId = $pluginSlug . '-n-appearance-section';

        $this->themeId         = 'n-theme-appearance' . self::SELECT_SUFFIX;
        $this->textOverflowId  = 'n-text-overflow-appearance' . self::RADIO_SUFFIX;

        /**
         * Toolbar Config
         */
        $this->toolbarSettingsSectionId = $pluginSlug . '-n-toolbar-section';

        $this->codeCopyBtnId         = 'n-code-copy-btn-toolbar' . self::CHECKBOX_SUFFIX;
        $this->allowAttributionBtnId = 'n-attribution-btn-toolbar' . self::CHECKBOX_SUFFIX;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since    1.0.0
     * @param   bool    $isNetworkAdmin    Whether the current request is for a network administrative interface page.
     */
    public function initializeHooks($isNetworkAdmin)
    {
        // Network Admin
        if ($isNetworkAdmin)
        {
            add_action('network_admin_menu', array($this, 'setupNetworkSettingsMenu'));
            add_action('admin_init', array($this, 'nInitializeGeneralOptions'), 10);
            add_action('network_admin_edit_vaaky_highlighter_update_network_options', array($this, 'vaaky_highlighter_update_network_options'));
        }
    }

    /**
     * This function introduces the plugin options into the Network Main menu.
     */
    public function setupNetworkSettingsMenu()
    {
        //Add the menu item under Main > Settings' menu
        add_submenu_page(
                'settings.php',
                __('Vaaky Highlighter Network Wide Settings', 'vaaky-highlighter'), // Page title: The title to be displayed in the browser window for this page.
                __('Vaaky Highlighter', 'vaaky-highlighter'), // Menu title: The text to be used for the menu.
                'manage_network_options', // Capability: The capability required for this menu to be displayed to the user.
                $this->menuSlug, // Menu slug: The slug name to refer to this menu by. Should be unique for this menu page.
                array($this, 'renderNetworkSettingsPageContent'), // Callback: The name of the function to call when rendering this menu's page
        );
    }

    /**
     * Renders the Settings page to display for the Settings menu defined above.
     *
     * @since   1.0.0
     * @param   string  activeTab       The name of the active tab.
     */
    public function renderNetworkSettingsPageContent($activeTab = '')
    {
        // Check user capabilities
        if (!current_user_can('manage_network_options'))
        {
            return;
        }

        // Add error/update messages.
        // Check if the user have submitted the settings. Wordpress will add the "updated" $_GET parameter to the url
        if (isset($_GET['updated']))
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

            <form method="post" action="edit.php?action=vaaky_highlighter_update_network_options">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content">

                            <?php
                            settings_fields($this->networkSettingOptionGroup);
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
     * This function here is hooked up to a special action and necessary to process
     * the saving of the options. This is the big difference with a normal options page.
     */
    public function vaaky_highlighter_update_network_options()
    {
        var_dump($_POST);
        die();
        // Security check.
        // On the settings page we used the '$this->networkSettingOptionGroup' slug when calling 'settings_fields'
        // but we must add the '-options' postfix when we check the nonce.
        if (wp_verify_nonce($_POST['_wpnonce'], $this->networkSettingOptionGroup . '-options') === false)
        {
            wp_die(__('Failed security check.', 'vaaky-highlighter'));
        }

        // Get the options.
        $options = $_POST[$this->networkSettingOptionName];
        var_dump($options);
        die();
        // Sanitize the option values
        $sanitizedOptions = $this->sanitizeOptionsCallback($options);

        // Update the options
        update_network_option(get_current_network_id(), $this->networkSettingOptionName, $sanitizedOptions);

        // At last we redirect back to our options page.
        wp_redirect(add_query_arg(array('page' => $this->menuSlug, 'updated' => 'true'), network_admin_url('settings.php')));
        exit();
    }

    public function nInitializeGeneralOptions()
    {
        $this->getNetworkGeneralOptions();

        //Appearance Section
        add_settings_section($this->appearanceSettingsSectionId, __('Appearance', 'vaaky-highlighter'), array(), $this->settingsPage);

        add_settings_field($this->themeId, __('Theme', 'vaaky-highlighter'), array($this, 'nSelectThemeCallback'), $this->settingsPage, $this->appearanceSettingsSectionId, array('label_for' => $this->themeId));

        add_settings_field($this->textOverflowId, __('Code Overflow', 'vaaky-highlighter'), array($this, 'nRadioOverflowCallback'), $this->settingsPage, $this->appearanceSettingsSectionId, array('label_for' => $this->textOverflowId));

        //Toolbar Section
        add_settings_section($this->toolbarSettingsSectionId, __('Toolbar Button', 'vaaky-highlighter'), array(), $this->settingsPage);

        add_settings_field($this->codeCopyBtnId, __('Copy Code', 'vaaky-highlighter'), array($this, 'nCheckboxCodeCopyBtnCallback'), $this->settingsPage, $this->toolbarSettingsSectionId, array('label_for' => $this->codeCopyBtnId));

        add_settings_field($this->allowAttributionBtnId, __('Attribution Button', 'vaaky-highlighter'), array($this, 'nCheckboxAttributionBtnCallback'), $this->settingsPage, $this->toolbarSettingsSectionId, array('label_for' => $this->allowAttributionBtnId));

        $registerSettingArguments = array(
            'type'              => 'array',
            'description'       => '',
            'sanitize_callback' => array($this, 'sanitizeOptionsCallback'),
            'show_in_rest'      => false
        );
        register_setting($this->networkSettingOptionGroup, $this->networkSettingOptionName, $registerSettingArguments);
    }

    /**
     * Return the General options.
     * 
     * @return array
     */
    public function getNetworkGeneralOptions()
    {
        if (isset($this->networkSettingOptions))
        {
            return $this->networkSettingOptions;
        }

        $currentNetworkId            = get_current_network_id();
        $this->networkSettingOptions = get_network_option($currentNetworkId, $this->networkSettingOptionName, array());

        // If options don't exist, create them.
        if ($this->networkSettingOptions === array())
        {
            $this->networkSettingOptions = $this->defaultNetworkGeneralOptions();
            update_network_option($currentNetworkId, $this->networkSettingOptionName, $this->networkSettingOptions);
        }

        return $this->networkSettingOptions;
    }

    /**
     * Provide default values for the Network General Options.
     *
     * @return array
     */
    private function defaultNetworkGeneralOptions()
    {
        return array(
            $this->themeId               => 'github',
            $this->textOverflowId        => 'scrollbar',
//            $this->lineNumberingId       => 0,
//            $this->lineHoverId           => 0,
//            $this->showRawCodeId         => 0,
//            $this->rawCodeBtnId          => 0,
            $this->codeCopyBtnId         => 1,
            $this->allowAttributionBtnId => 1
        );
    }

    /**
     * This function provides a simple description for the General Options page.
     *
     * It's called from the initializeNetworkGeneralOptions function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function networkGeneralOptionsCallback()
    {
        // Display the settings data for easier examination. Delete it, if you don't need it.
        echo '<p>Display the settings as stored in the database:</p>';
        $this->getNetworkGeneralOptions();
        var_dump($this->networkSettingOptions);

        echo '<p>' . esc_html__('Network General Options.', 'vaaky-highlighter') . '</p>';
    }

    # Common function
    
    public function nSelectThemeCallback()
    {
        $themeDark  = [
            'monokai-sublime'          => 'Monokai (Sublime)',
            'vs2015'                   => 'Visual Studio 2015',
            'tomorrow-night-bright'    => 'Tomorrow Night Bright',
            'tomorrow-night-blue'      => 'Tomorrow Night Blue',
            'stackoverflow-dark'       => 'StackOverflow Dark',
            'shades-of-purple'         => 'Shades of Purple Theme',
            'monokai'                  => 'Monokai',
            'monokai-sublime'          => 'Sublime (Monokai)',
            'gradient-dark'            => 'Gradient Dark',
            'github-dark'              => 'GitHub Dark',
            'github-dark-dimmed'       => 'GitHub Dark Dimmed',
            'codepen-embed'            => 'codepen.io Embed',
            'atom-one-dark'            => 'Atom One Dark',
            'atom-one-dark-reasonable' => 'Atom One Dark (with ReasonML)',
            'androidstudio'            => 'Android Studio',
            'a11y-dark'                => 'A 11 Y Dark',
        ];
        $themeLight = [
            'github'              => 'Github',
            'xcode'               => 'XCode',
            'vs'                  => 'Visual Studio',
            'stackoverflow-light' => 'StackOverflow Light',
            'gradient-light'      => 'Gradient Light',
            'googlecode'          => 'Google Code',
            'github'              => 'GitHub',
            'atom-one-light'      => 'Atom One Light',
            'arduino-light'       => 'Arduino Light',
            'a11y-light'          => 'A 11 Y Light',
        ];

        $html = sprintf('<select id="%s" name="%s[%s]">', $this->themeId, $this->networkSettingOptionName, $this->themeId);
        $html .= '<option value="">' . esc_html__('Select a theme...', 'vaaky-highlighter') . '</option>';
        $html .= '<optgroup label="' . esc_html__('Light Theme', 'vaaky-highlighter') . '">';
        foreach ($themeLight as $lThemeSlug => $lThemeLabel)
        {
            $html .= sprintf('<option value="%s" %s >%s</option>', $lThemeSlug, selected($this->networkSettingOptions[$this->themeId], $lThemeSlug, false), esc_html__($lThemeLabel, 'vaaky-highlighter'));
        }
        $html .= '</optgroup>';

        $html .= '<optgroup label="' . esc_html__('Dark Theme', 'vaaky-highlighter') . '">';
        foreach ($themeDark as $dThemeSlug => $dThemeLabel)
        {
            $html .= sprintf('<option value="%s" %s >%s</option>', $dThemeSlug, selected($this->networkSettingOptions[$this->themeId], $dThemeSlug, false), esc_html__($dThemeLabel, 'vaaky-highlighter'));
        }
        $html .= '</optgroup>';
        $html .= '</select>';
        $html .= '<p class="description">' . __('Select the highlighter theme. Default is GitHub Light.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }
    
    public function nRadioOverflowCallback()
    {
        $checked = (!empty($this->networkSettingOptions[$this->textOverflowId])) ? $this->networkSettingOptions[$this->textOverflowId] : 'new-line';
        
        $html    = sprintf('<input type="radio" id="radio-overflow-one" name="%s[%s]" value="new-line" %s />', $this->networkSettingOptionName, $this->textOverflowId, checked($checked, 'new-line', false));
        $html    .= '&nbsp;';
        $html    .= '<label for="radio-overflow-one">' . __('New Line/Line Break', 'vaaky-highlighter') . '</label>';
        $html    .= '&nbsp;';
        $html    .= sprintf('<input type="radio" id="radio-overflow-two" name="%s[%s]" value="scrollbar" %s />', $this->networkSettingOptionName, $this->textOverflowId, checked($checked, 'scrollbar', false));
        $html    .= '&nbsp;';
        $html    .= '<label for="radio-overflow-two">' . __('Show Scrollbar', 'vaaky-highlighter') . '</label>';
        $html    .= '<p class="description">' . __('Set the text/code wrapping behaviour: line break or scrollbar.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }
    
    public function nCheckboxAttributionBtnCallback()
    {
        $checked = (!empty($this->networkSettingOptions[$this->allowAttributionBtnId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->allowAttributionBtnId, $this->networkSettingOptionName, $this->allowAttributionBtnId, checked($checked, true, false));
        $html .= '&nbsp;';

        $html .= sprintf('<label for="%s">%s</label>', $this->allowAttributionBtnId, __('Show Attribution', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('Show Vaaky Highlighter Website link, so that visiter can get to know about our WordPress plugin.', 'vaaky-highlighter') . '</p>';
        $html .= '<p class="description">' . __('Please keep this option turned on.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }
    
    public function nCheckboxCodeCopyBtnCallback()
    {
        $checked = (!empty($this->networkSettingOptions[$this->codeCopyBtnId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->codeCopyBtnId, $this->networkSettingOptionName, $this->codeCopyBtnId, checked($checked, true, false));
        $html .= '&nbsp;';
        $html .= sprintf('<label for="%s">%s</label>', $this->codeCopyBtnId, __('Show Copy Code Button', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('Show the copy-to-clipboard button. Works within all modern web browsers.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }
}