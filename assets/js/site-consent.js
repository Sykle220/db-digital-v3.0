(function () {
    'use strict';

    var STORAGE_KEY = 'dba_cookie_consent';
    var banner      = document.getElementById('cookie-consent');

    function getConsent() {
        try {
            return localStorage.getItem(STORAGE_KEY);
        } catch (e) {
            return null;
        }
    }

    function saveConsent(value) {
        try {
            localStorage.setItem(STORAGE_KEY, value);
            localStorage.removeItem('dba_cookie_consent_dismissed');
        } catch (e) {}
        document.dispatchEvent(new CustomEvent('dba:consent', { detail: { value: value } }));
    }

    function hideBanner() {
        if (!banner) {
            return;
        }
        banner.classList.remove('cookie-consent--visible');
        window.setTimeout(function () {
            banner.setAttribute('hidden', '');
        }, 280);
    }

    function showBanner() {
        if (!banner) {
            return;
        }
        banner.removeAttribute('hidden');
        requestAnimationFrame(function () {
            banner.classList.add('cookie-consent--visible');
        });
    }

    function resolveConsent(action) {
        if (action === 'accept') {
            return 'accepted';
        }
        return 'rejected';
    }

    if (!banner) {
        return;
    }

    var existing = getConsent();
    if (existing === 'accepted' || existing === 'rejected') {
        if (existing === 'accepted') {
            document.dispatchEvent(new CustomEvent('dba:consent', { detail: { value: 'accepted' } }));
        }
        return;
    }

    showBanner();

    banner.addEventListener('click', function (e) {
        var target = e.target.closest('[data-consent]');
        if (!target) {
            return;
        }

        var action = target.getAttribute('data-consent');
        var value  = resolveConsent(action === 'accept' ? 'accept' : 'reject');
        saveConsent(value);
        hideBanner();
    });
})();
