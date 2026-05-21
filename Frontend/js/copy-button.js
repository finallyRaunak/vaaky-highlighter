(function () {
    'use strict';

    function init() {
        var blocks = document.querySelectorAll('.vaaky-highlighter-wrap');
        blocks.forEach(function (block) {
            if (block.querySelector('.vaaky-copy-btn-floating')) return;
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'vaaky-copy-btn-floating';
            btn.setAttribute('aria-label', 'Copy code to clipboard');
            btn.textContent = 'Copy';
            btn.addEventListener('click', function () { handleCopy(btn, block); });
            block.appendChild(btn);
        });

        if (window.hljs && typeof window.hljs.initLineNumbersOnLoad === 'function') {
            window.hljs.initLineNumbersOnLoad({ singleLine: true });
        }
    }

    function handleCopy(btn, block) {
        var codeEl = block.querySelector('pre code');
        if (!codeEl) return;
        var text = codeEl.innerText;
        var done = function () {
            var original = btn.textContent;
            btn.textContent = 'Copied!';
            btn.classList.add('is-copied');
            setTimeout(function () {
                btn.textContent = original;
                btn.classList.remove('is-copied');
            }, 1500);
        };
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(done).catch(function () { fallback(text, done); });
        } else {
            fallback(text, done);
        }
    }

    function fallback(text, done) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); done(); } catch (e) {}
        document.body.removeChild(ta);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
