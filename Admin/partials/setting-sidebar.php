<?php

// If this file is called directly, abort.
if (!defined('ABSPATH'))
{
    exit();
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    VaakyHighlighter
 * @subpackage VaakyHighlighter/Admin/partials
 */
?>

<div class="postbox">
    <h3 class="hndle"><?= __('System Information', 'vaaky-highlighter'); ?></h3>
    <div class="inside">
        <ul>
            <li><strong><?= __('Server', 'vaaky-highlighter'); ?></strong></li>
            <?php echo '<li>', __('PHP Version:', 'vaaky-highlighter'), ' <span>', phpversion(), '</span></li>'; ?>
            <?php echo '<li>', __('PHP JSON Extension:', 'vaaky-highlighter'), '<span>', __(((function_exists('json_encode')) ? '':' not').' installed', 'vaaky-highlighter'), '</span></li>'; ?>
            <?php echo '<li>', __('Operating System:', 'vaaky-highlighter'), ' <span>', PHP_OS, '</span></li>'; ?>
        </ul>
        <hr>
        <ul>
            <li><strong><?= __('Components', 'vaaky-highlighter'); ?></strong></li>
            <?php echo '<li>', __('Vaaky Highlighter Plugin:', 'vaaky-highlighter'), ' <span>', VAAKY_HIGHLIGHTER_VERSION, '</span></li>'; ?>
            <?php echo '<li>', __('HighlightJs Version:', 'vaaky-highlighter'), ' <span>', VAAKY_HIGHLIGHTER_HLJS_VERSION, '</span></li>'; ?>
        </ul>

    </div>
</div> 
<div class="postbox vaaky-postbox">
    <h3 class="hndle"><?= __('Quick Links', 'vaaky-highlighter'); ?></h3>
    <div class="inside">
        <ul>
            <li>
                <span class="dashicons dashicons-media-document"></span>
                <a target="_blank" href="https://github.com/finallyRaunak/vaaky-highlighter"><?= __('Documentation', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-format-chat"></span>
                <a target="_blank" href="https://wordpress.org/plugins/vaaky-highlighter/#faq-header"><?= __('FAQs', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-art"></span>
                <a target="_blank" href="#"><?= __('Theme Demo', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-sos"></span>
                <a target="_blank" href="https://wordpress.org/support/plugin/vaaky-highlighter"><?= __('Support Forum', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-buddicons-replies"></span>
                <a target="_blank" href="https://github.com/finallyRaunak/vaaky-highlighter/issues"><?= __('Report a Bug', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-star-filled"></span>
                <a target="_blank" href="https://wordpress.org/support/plugin/vaaky-highlighter/reviews/#new-post"><?= __('Review us!', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-lightbulb"></span>
                <a target="_blank" href="https://github.com/finallyRaunak/vaaky-highlighter/issues"><?= __('Request for a feature', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-facebook"></span>
                <a target="_blank" href="https://www.facebook.com/webhat.in/"><?= __('Catch us on Facebook', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-twitter"></span>
                <a target="_blank" href="https://twitter.com/webhat14"><?= __('Catch us on Twitter', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-wordpress-alt"></span>
                <a target="_blank" href="https://wordpress.org/plugin/vaaky-highlighter"><?= __('Catch us on WordPress', 'vaaky-highlighter'); ?></a>
            </li>
            <li>
                <span class="dashicons dashicons-external"></span>
                <a target="_blank" href="https://www.webhat.in/?utm_source=vaaky-highlighter&utm_medium=wp-admin-link&utm_campaign=<?= $_SERVER['HTTP_HOST']; ?>"><?= __('Author\'s Website', 'vaaky-highlighter'); ?></a>
            </li>
        </ul>
    </div>
</div>