(function () {
    'use strict';

    function addButtons() {
        var blocks = document.querySelectorAll('.vaaky-highlighter-wrap');
        blocks.forEach(function (block) {
            var pre = block.querySelector('pre');
            if (!pre) return;
            if (pre.querySelector(':scope > .vaaky-copy-btn-floating')) return;
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'vaaky-copy-btn-floating';
            btn.setAttribute('aria-label', 'Copy code to clipboard');
            btn.textContent = 'Copy';
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                handleCopy(btn, pre);
            });
            pre.appendChild(btn);
        });
    }

    function handleCopy(btn, pre) {
        var codeEl = pre.querySelector('code');
        if (!codeEl) return;
        // hljs-line-numbers injects a <table> — innerText preserves visible text per row
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

    // Run after highlight.js has decorated blocks (so line-numbers table is in place
    // and innerText reads cleanly). core.js dispatches this event after highlightAll().
    document.addEventListener('vaaky:highlighted', addButtons);

    // Fallback: also run on DOMContentLoaded in case the event already fired
    // (e.g., scripts loaded out of order) or in case highlightAll runs faster than us.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', addButtons);
    } else {
        addButtons();
    }
})();
