jQuery(document).ready(function ($) {
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
        window.open("https://www.webhat.in/?utm_source=vaaky-highlighter&utm_medium=website-btn&utm_campaign=" + jQuery(location).attr('hostname'));
    });

});