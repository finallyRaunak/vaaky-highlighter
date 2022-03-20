jQuery(document).ready(function ($) {
    hljs.configure({ ignoreUnescapedHTML: true });
    hljs.highlightAll();

    jQuery('.vaaky-toolbar .vaaky-copy-btn').off('click').on('click', function () {
        let codeBlock = jQuery(this).parent().parent().find('pre code');
        let text = codeBlock.text();

        // first version - document.execCommand('copy');
        var element = document.createElement('textarea');
        document.body.appendChild(element);
        element.value = text;
        element.select();
        document.execCommand('copy');
        document.body.removeChild(element);

        jQuery("span", this).text('Copied!');
        setTimeout(() => {
            jQuery("span", this).text('Copy');
        }, 2500);

    });

    jQuery('.vaaky-toolbar .vaaky-website-btn').off('click').on('click', function () {
        window.open("https://www.webhat.in/?page_id=626?utm_source=plugin&utm_medium=code_btn&utm_id=vaaky_highlighter&utm_term=Website&utm_campaign=" + jQuery(location).attr('hostname'));
    });

});