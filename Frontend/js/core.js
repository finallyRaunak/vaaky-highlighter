jQuery(document).ready(function ($) {
    hljs.configure({ ignoreUnescapedHTML: true });
    hljs.highlightAll();

    if (typeof hljs.initLineNumbersOnLoad === 'function') {
        hljs.initLineNumbersOnLoad({ singleLine: true });
    }

    document.dispatchEvent(new CustomEvent('vaaky:highlighted'));
});