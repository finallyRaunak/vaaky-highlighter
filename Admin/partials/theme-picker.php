<?php
/**
 * Theme picker partial — visual grid of available Highlight.js themes.
 *
 * Each preview is a sandboxed <iframe srcdoc> that loads the theme's actual
 * CSS file and renders a pre-highlighted sample using Highlight.js's class
 * conventions (.hljs-keyword, .hljs-title, .hljs-string, etc.). This shows
 * the real theme colors instead of a stylized facsimile.
 *
 * Variables expected in scope:
 *   $themes       array  slug => human label
 *   $currentTheme string current selected slug
 *   $fieldName    string the form field name (matches existing option key)
 */
if (!defined('ABSPATH')) {
    exit;
}

// Resolve the URL to Frontend/css via the plugin root file.
$frontendCssBaseUrl = plugins_url('Frontend/css/', VAAKY_HIGHLIGHTER_PLUGIN_PATH . '/vaaky-highlighter.php');

// Pre-rendered hljs sample. Themes style these class names directly.
$sampleHtml = '<pre><code class="hljs language-javascript">'
    . '<span class="hljs-keyword">function</span> '
    . '<span class="hljs-title">hello</span>() {' . "\n"
    . '  <span class="hljs-keyword">return</span> '
    . '<span class="hljs-string">\'world\'</span>;' . "\n"
    . '}'
    . '</code></pre>';
?>
<div class="vaaky-theme-picker">
    <?php foreach ($themes as $slug => $label) :
        $themeCssUrl = esc_url($frontendCssBaseUrl . $slug . '.min.css');
        $previewDoc  = '<!DOCTYPE html><html><head><meta charset="utf-8">'
            . '<link rel="stylesheet" href="' . $themeCssUrl . '">'
            . '<style>'
            . 'html,body{margin:0;padding:0;height:100%;overflow:hidden;font-size:11px;line-height:1.45;'
            . 'font-family:ui-monospace,SFMono-Regular,Menlo,monospace;}'
            . 'pre{margin:0;height:100%;box-sizing:border-box;overflow:hidden;}'
            . 'pre code.hljs{display:block;height:100%;padding:10px;box-sizing:border-box;overflow:hidden;}'
            . '</style></head><body>' . $sampleHtml . '</body></html>';
    ?>
        <label class="vaaky-theme-card<?php echo ($slug === $currentTheme) ? ' is-selected' : ''; ?>">
            <input
                type="radio"
                name="<?php echo esc_attr($fieldName); ?>"
                value="<?php echo esc_attr($slug); ?>"
                <?php checked($slug, $currentTheme); ?>
            />
            <iframe
                class="vaaky-theme-preview"
                data-theme="<?php echo esc_attr($slug); ?>"
                sandbox=""
                loading="lazy"
                tabindex="-1"
                aria-hidden="true"
                srcdoc="<?php echo esc_attr($previewDoc); ?>"
            ></iframe>
            <span class="vaaky-theme-label"><?php echo esc_html($label); ?></span>
        </label>
    <?php endforeach; ?>
</div>
