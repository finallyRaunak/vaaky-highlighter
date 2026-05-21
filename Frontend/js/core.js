jQuery(document).ready(function ($) {
    hljs.configure({ ignoreUnescapedHTML: true });
    hljs.highlightAll();

    // Apply line numbers directly to blocks we marked (sync API — sidesteps
    // the lib's initLineNumbersOnLoad which uses for-in over a NodeList and
    // can swallow errors silently on some browsers).
    if (typeof hljs.lineNumbersBlockSync === 'function') {
        document.querySelectorAll('.vaaky-line-numbers code.hljs').forEach(function (block) {
            try {
                hljs.lineNumbersBlockSync(block, { singleLine: true });
            } catch (e) {
                if (window.console) console.error('vaaky line-numbers:', e);
            }
        });
    }

    document.dispatchEvent(new CustomEvent('vaaky:highlighted'));
});