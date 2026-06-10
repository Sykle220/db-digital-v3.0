(function () {
    'use strict';

    var cfg = window.SITE_TRACKING || {};
    var loaded = false;

    function consentGranted() {
        try {
            return localStorage.getItem('dba_cookie_consent') === 'accepted';
        } catch (e) {
            return false;
        }
    }

    function loadScript(src, attrs) {
        var s = document.createElement('script');
        s.async = true;
        s.src = src;
        if (attrs) {
            Object.keys(attrs).forEach(function (k) { s.setAttribute(k, attrs[k]); });
        }
        document.head.appendChild(s);
    }

    function injectGtm(id) {
        if (!id || window.dataLayer) return;
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
        loadScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(id));
    }

    function injectGa4(id) {
        if (!id || window.gtag) return;
        loadScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id));
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { window.dataLayer.push(arguments); };
        window.gtag('js', new Date());
        window.gtag('config', id, { anonymize_ip: true });
    }

    function injectMetaPixel(id) {
        if (!id || window.fbq) return;
        var n = window.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
        if (!window._fbq) window._fbq = n;
        n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
        loadScript('https://connect.facebook.net/en_US/fbevents.js');
        window.fbq('init', id);
        window.fbq('track', 'PageView');
    }

    function injectLinkedIn(id) {
        if (!id || window._linkedin_data_partner_ids) return;
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push(id);
        loadScript('https://snap.licdn.com/li.lms-analytics/insight.min.js');
    }

    function injectHotjar(id) {
        if (!id || window.hj) return;
        window.hj = window.hj || function () { (window.hj.q = window.hj.q || []).push(arguments); };
        window._hjSettings = { hjid: parseInt(id, 10), hjsv: 6 };
        loadScript('https://static.hotjar.com/c/hotjar-' + id + '.js?sv=6');
    }

    function injectClarity(id) {
        if (!id || window.clarity) return;
        window.clarity = window.clarity || function () { (window.clarity.q = window.clarity.q || []).push(arguments); };
        loadScript('https://www.clarity.ms/tag/' + encodeURIComponent(id));
    }

    function loadAll() {
        if (!cfg.enabled || loaded) return;
        if (!consentGranted()) return;
        loaded = true;
        if (cfg.gtm) injectGtm(cfg.gtm);
        if (cfg.ga4) injectGa4(cfg.ga4);
        if (cfg.metaPixel) injectMetaPixel(cfg.metaPixel);
        if (cfg.linkedin) injectLinkedIn(cfg.linkedin);
        if (cfg.hotjar) injectHotjar(cfg.hotjar);
        if (cfg.clarity) injectClarity(cfg.clarity);
    }

    var ga4EventMap = {
        quote_submit: 'generate_lead',
        newsletter_signup: 'sign_up',
        whatsapp_click: 'contact'
    };

    window.dbaTrack = function (eventName, params) {
        params = params || {};
        if (!cfg.enabled || !consentGranted()) {
            return;
        }

        var ga4Event = ga4EventMap[eventName] || eventName;
        if (window.gtag) window.gtag('event', ga4Event, params);
        if (window.fbq) window.fbq('trackCustom', eventName, params);
        if (window.dataLayer) window.dataLayer.push(Object.assign({ event: eventName, ga4_event: ga4Event }, params));
    };

    document.addEventListener('dba:consent', function (e) {
        if (e.detail && e.detail.value === 'accepted') loadAll();
    });

    if (consentGranted()) loadAll();

    document.addEventListener('click', function (e) {
        var wa = e.target.closest('.js-track-whatsapp, [data-track="whatsapp_click"]');
        if (wa) window.dbaTrack('whatsapp_click', { link_url: wa.href || '' });
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (document.body.dataset.trackConversion) {
            window.dbaTrack(document.body.dataset.trackConversion, {});
        }
    });
})();
