(function () {
    'use strict';
    var notices = document.querySelectorAll('.vaaky-review-notice');
    notices.forEach(function (n) {
        n.addEventListener('click', function (e) {
            var action = e.target.getAttribute('data-vaaky-review-action');
            if (!action) return;
            var form = new FormData();
            form.append('action', 'vaaky_review_notice');
            form.append('decision', action);
            form.append('_wpnonce', n.dataset.nonce);
            fetch(n.dataset.ajax, {
                method: 'POST',
                body: form,
                credentials: 'same-origin'
            }).finally(function () {
                n.style.display = 'none';
            });
        });
    });
})();
