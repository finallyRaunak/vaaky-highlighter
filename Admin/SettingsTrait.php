<?php

namespace VaakyHighlighter\Admin;

trait SettingsTrait
{
    public function getThemeList()
    {
        $themeDark  = [
            'monokai-sublime'          => 'Monokai (Sublime)',
            'vs2015'                   => 'Visual Studio 2015',
            'tomorrow-night-bright'    => 'Tomorrow Night Bright',
            'tomorrow-night-blue'      => 'Tomorrow Night Blue',
            'stackoverflow-dark'       => 'StackOverflow Dark',
            'shades-of-purple'         => 'Shades of Purple Theme',
            'monokai'                  => 'Monokai',
            'gradient-dark'            => 'Gradient Dark',
            'github-dark'              => 'GitHub Dark',
            'github-dark-dimmed'       => 'GitHub Dark Dimmed',
            'codepen-embed'            => 'codepen.io Embed',
            'atom-one-dark'            => 'Atom One Dark',
            'atom-one-dark-reasonable' => 'Atom One Dark (with ReasonML)',
            'androidstudio'            => 'Android Studio',
            'a11y-dark'                => 'A 11 Y Dark',
            'tokyo-night-dark'         => 'Tokyo Night Dark',
            'rose-pine'                => 'Rose Pine',
            'rose-pine-moon'           => 'Rose Pine Moon',
            'nord'                     => 'Nord',
        ];
        $themeLight = [
            'github'              => 'GitHub',
            'xcode'               => 'XCode',
            'vs'                  => 'Visual Studio',
            'stackoverflow-light' => 'StackOverflow Light',
            'gradient-light'      => 'Gradient Light',
            'googlecode'          => 'Google Code',
            'atom-one-light'      => 'Atom One Light',
            'arduino-light'       => 'Arduino Light',
            'a11y-light'          => 'A 11 Y Light',
            'tokyo-night-light'   => 'Tokyo Night Light',
            'rose-pine-dawn'      => 'Rose Pine Dawn',
        ];

        return array_merge($themeLight, $themeDark);
    }

    public function selectThemeCallback()
    {
        $themes       = $this->getThemeList();
        $currentTheme = $this->getTheme();
        $fieldName    = $this->settingOptionName . '[' . $this->themeId . ']';

        include plugin_dir_path(__FILE__) . 'partials/theme-picker.php';

        echo '<p class="description">' . esc_html__('Select the highlighter theme. Default is GitHub Light.', 'vaaky-highlighter') . '</p>';
    }

    public function inputApperanceCallback()
    {
        $this->getSettingOptions();
        echo '<p>' . esc_html__('Settings as stored in the database.', 'vaaky-highlighter') . '</p>';
        var_dump($this->settingOptions);
    }

    public function radioOverflowCallback()
    {
        $checked = (!empty($this->settingOptions[$this->textOverflowId])) ? $this->settingOptions[$this->textOverflowId] : 'new-line';

        $html    = sprintf('<input type="radio" id="radio-overflow-one" name="%s[%s]" value="new-line" %s />', $this->settingOptionName, $this->textOverflowId, checked($checked, 'new-line', false));
        $html    .= '&nbsp;';
        $html    .= '<label for="radio-overflow-one">' . __('New Line/Line Break', 'vaaky-highlighter') . '</label>';
        $html    .= '&nbsp;';
        $html    .= sprintf('<input type="radio" id="radio-overflow-two" name="%s[%s]" value="scrollbar" %s />', $this->settingOptionName, $this->textOverflowId, checked($checked, 'scrollbar', false));
        $html    .= '&nbsp;';
        $html    .= '<label for="radio-overflow-two">' . __('Show Scrollbar', 'vaaky-highlighter') . '</label>';
        $html    .= '<p class="description">' . __('Set the text/code wrapping behaviour: line break or scrollbar.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }

    public function checkboxDefaultLineNumbersCallback()
    {
        $checked = (!empty($this->settingOptions[$this->defaultLineNumbersId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->defaultLineNumbersId, $this->settingOptionName, $this->defaultLineNumbersId, checked($checked, true, false));
        $html .= '&nbsp;';
        $html .= sprintf('<label for="%s">%s</label>', $this->defaultLineNumbersId, __('Show line numbers by default', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('When enabled, line numbers are shown on code blocks unless the block overrides this setting.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }

    public function checkboxDefaultWordWrapCallback()
    {
        $checked = (!empty($this->settingOptions[$this->defaultWordWrapId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->defaultWordWrapId, $this->settingOptionName, $this->defaultWordWrapId, checked($checked, true, false));
        $html .= '&nbsp;';
        $html .= sprintf('<label for="%s">%s</label>', $this->defaultWordWrapId, __('Enable word wrap by default', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('When enabled, long lines of code wrap instead of showing a horizontal scrollbar, unless the block overrides this setting.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }

}