<?php
/**
 * Theme picker partial — visual grid of available Highlight.js themes.
 *
 * Variables expected in scope:
 *   $themes       array  slug => human label
 *   $currentTheme string current selected slug
 *   $fieldName    string the form field name (matches existing option key)
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="vaaky-theme-picker">
    <?php foreach ($themes as $slug => $label) : ?>
        <label class="vaaky-theme-card<?php echo ($slug === $currentTheme) ? ' is-selected' : ''; ?>">
            <input
                type="radio"
                name="<?php echo esc_attr($fieldName); ?>"
                value="<?php echo esc_attr($slug); ?>"
                <?php checked($slug, $currentTheme); ?>
            />
            <span class="vaaky-theme-preview" data-theme="<?php echo esc_attr($slug); ?>">
                <code>
                    <span class="hl-kw">function</span> <span class="hl-fn">hello</span>() {<br>
                    &nbsp;&nbsp;<span class="hl-str">'world'</span>;<br>
                    }
                </code>
            </span>
            <span class="vaaky-theme-label"><?php echo esc_html($label); ?></span>
        </label>
    <?php endforeach; ?>
</div>
