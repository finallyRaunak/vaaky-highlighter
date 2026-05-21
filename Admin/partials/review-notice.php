<?php
if (!defined('ABSPATH')) {
    exit;
}
$ajaxUrl = admin_url('admin-ajax.php');
$nonce   = wp_create_nonce('vaaky_review_notice');
?>
<div class="notice notice-info is-dismissible vaaky-review-notice"
     data-nonce="<?php echo esc_attr($nonce); ?>"
     data-ajax="<?php echo esc_url($ajaxUrl); ?>">
    <p>
        <?php esc_html_e('Enjoying Vaaky Highlighter? A quick review on WordPress.org helps other developers find it.', 'vaaky-highlighter'); ?>
    </p>
    <p>
        <a class="button button-primary"
           target="_blank" rel="noopener noreferrer"
           href="https://wordpress.org/support/plugin/vaaky-highlighter/reviews/#new-post"
           data-vaaky-review-action="leave">
            <?php esc_html_e('Leave a review', 'vaaky-highlighter'); ?>
        </a>
        <button type="button" class="button" data-vaaky-review-action="later">
            <?php esc_html_e('Remind me later', 'vaaky-highlighter'); ?>
        </button>
        <button type="button" class="button-link" data-vaaky-review-action="dismiss">
            <?php esc_html_e('Already did, thanks!', 'vaaky-highlighter'); ?>
        </button>
    </p>
</div>
