(function () {
    'use strict';

    function ensureHiddenInput(form) {
        var input = form.querySelector('input[name="g-recaptcha-response"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'g-recaptcha-response';
            form.appendChild(input);
        }
        return input;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (!window.RECAPTCHA_SITE_KEY || !window.grecaptcha) {
            return;
        }

        document.querySelectorAll('form.js-recaptcha-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (form.dataset.recaptchaReady === '1') {
                    form.dataset.recaptchaReady = '0';
                    return;
                }

                e.preventDefault();
                var hidden = ensureHiddenInput(form);

                window.grecaptcha.ready(function () {
                    window.grecaptcha.execute(window.RECAPTCHA_SITE_KEY, { action: 'submit' }).then(function (token) {
                        hidden.value = token;
                        form.dataset.recaptchaReady = '1';
                        form.submit();
                    });
                });
            });
        });
    });
})();
