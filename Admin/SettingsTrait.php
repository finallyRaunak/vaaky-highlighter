<?php

namespace VaakyHighlighter\Admin;

trait SettingsTrait
{
    public function selectThemeCallback()
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

        $html = sprintf('<select id="%s" name="%s[%s]">', $this->themeId, $this->settingOptionName, $this->themeId);
        $html .= '<option value="">' . esc_html__('Select a theme...', 'vaaky-highlighter') . '</option>';
        $html .= '<optgroup label="' . esc_html__('Light Theme', 'vaaky-highlighter') . '">';
        foreach ($themeLight as $lThemeSlug => $lThemeLabel)
        {
            $html .= sprintf('<option value="%s" %s >%s</option>', $lThemeSlug, selected($this->settingOptions[$this->themeId], $lThemeSlug, false), esc_html__($lThemeLabel, 'vaaky-highlighter'));
        }
        $html .= '</optgroup>';

        $html .= '<optgroup label="' . esc_html__('Dark Theme', 'vaaky-highlighter') . '">';
        foreach ($themeDark as $dThemeSlug => $dThemeLabel)
        {
            $html .= sprintf('<option value="%s" %s >%s</option>', $dThemeSlug, selected($this->settingOptions[$this->themeId], $dThemeSlug, false), esc_html__($dThemeLabel, 'vaaky-highlighter'));
        }
        $html .= '</optgroup>';
        $html .= '</select>';
        $html .= '<p class="description">' . __('Select the highlighter theme. Default is GitHub Light.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }

    public function inputApperanceCallback()
    {
        $this->getSettingOptions();
        echo '<p>' . esc_html__('Settings as stored in the database.', 'vaaky-highlighter') . '</p>';
        var_dump($this->settingOptions);
    }

    public function checkboxCodeCopyBtnCallback()
    {
        $checked = (!empty($this->settingOptions[$this->codeCopyBtnId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->codeCopyBtnId, $this->settingOptionName, $this->codeCopyBtnId, checked($checked, true, false));
        $html .= '&nbsp;';
        $html .= sprintf('<label for="%s">%s</label>', $this->codeCopyBtnId, __('Show Copy Code Button', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('Show the copy-to-clipboard button. Works within all modern web browsers.', 'vaaky-highlighter') . '</p>';

        echo $html;
    }

    public function checkboxAttributionBtnCallback()
    {
        $checked = (!empty($this->settingOptions[$this->allowAttributionBtnId])) ? 1 : 0;

        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->allowAttributionBtnId, $this->settingOptionName, $this->allowAttributionBtnId, checked($checked, true, false));
        $html .= '&nbsp;';

        $html .= sprintf('<label for="%s">%s</label>', $this->allowAttributionBtnId, __('Show Attribution', 'vaaky-highlighter'));
        $html .= '<p class="description">' . __('Show Vaaky Highlighter Website link, so that visiter can get to know about our WordPress plugin.', 'vaaky-highlighter') . '</p>';
        $html .= '<p class="description">' . __('Please keep this option turned on.', 'vaaky-highlighter') . '</p>';

        echo $html;
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

}