<?php
/**
 * components/contact-map.php
 *
 * Carte plein écran : marqueurs premium + popup riche au clic.
 * Variables optionnelles: $locations, $locations_show_header (bool, défaut true)
 */

if (!isset($locations) || !is_array($locations) || empty($locations)) {
    $locations = [
        [
            'key' => 'douala',
            'city' => 'Douala',
            'label_en' => 'Cameroon · Douala',
            'label_fr' => 'Cameroun · Douala',
            'address' => 'Cité des palmiers',
            'phone' => CONTACT_PHONE_2,
            'email' => 'douala@dbdigitalagency.com',
            'lat' => 4.048839,
            'lng' => 9.704497,
            'zoom' => 15,
        ],
        [
            'key' => 'yaounde',
            'city' => 'Yaoundé',
            'label_en' => 'Cameroon · Yaoundé',
            'label_fr' => 'Cameroun · Yaoundé',
            'address' => 'Nkoabang - Entrée Carrière',
            'phone' => CONTACT_PHONE_1,
            'email' => 'yaounde@dbdigitalagency.com',
            'lat' => 3.8514329,
            'lng' => 11.5765658,
            'zoom' => 15,
        ],
        [
            'key' => 'bafoussam',
            'city' => 'Bafoussam',
            'label_en' => 'Cameroon · Bafoussam',
            'label_fr' => 'Cameroun · Bafoussam',
            'address' => 'Kamkop (face station Tradex)',
            'phone' => CONTACT_PHONE_3,
            'email' => 'bafoussam@dbdigitalagency.com',
            'lat' => 5.500007,
            'lng' => 10.388760,
            'zoom' => 13,
        ],
    ];
}

$office_image = 'assets/img/images/contact_img.jpg';
$googleMapsKey = (string) envv('GOOGLE_MAPS_API_KEY', '');
$useGoogleJsApi = $googleMapsKey !== '';

$map_locations = [];
foreach ($locations as $loc) {
    $label = $current_lang === 'fr'
        ? (string) ($loc['label_fr'] ?? '')
        : (string) ($loc['label_en'] ?? '');
    $map_locations[] = [
        'key' => (string) ($loc['key'] ?? ''),
        'city' => (string) ($loc['city'] ?? ''),
        'label' => $label,
        'address' => (string) ($loc['address'] ?? ''),
        'phone' => (string) ($loc['phone'] ?? ''),
        'email' => (string) ($loc['email'] ?? ''),
        'lat' => (float) ($loc['lat'] ?? 0),
        'lng' => (float) ($loc['lng'] ?? 0),
        'zoom' => (int) ($loc['zoom'] ?? 14),
        'image' => (string) ($loc['image'] ?? $office_image),
        'badge' => (string) ($loc['badge'] ?? __('locations_badge')),
    ];
}

$map_i18n = [
    'badge' => __('locations_badge'),
    'directions' => __('locations_directions'),
    'close' => $current_lang === 'fr' ? 'Fermer' : 'Close',
];

$map_embedded = !empty($map_embedded);
$map_wrapper_tag = $map_embedded ? 'div' : 'section';
$map_wrapper_class = 'locations-map locations-map-pro' . ($map_embedded ? ' locations-map-embed' : '');
$map_stage_outer_class = $map_embedded
    ? 'locations-map-stage-outer'
    : 'container-fluid locations-map-stage-outer';
?>

<<?php echo $map_wrapper_tag; ?> class="<?php echo $map_wrapper_class; ?>" aria-label="<?php echo htmlspecialchars(__('locations_title')); ?>">

    <div class="<?php echo $map_stage_outer_class; ?>">
        <div class="locations-map-stage">
            <div
                id="locationsMapCanvas"
                class="locations-map-frame"
                role="application"
                aria-label="<?php echo htmlspecialchars(__('locations_title')); ?>"
            ></div>

            <div class="locations-map-overlay" aria-hidden="false">
                <div class="locations-map-chips" role="tablist" aria-label="<?php echo htmlspecialchars(__('locations_title')); ?>">
                    <?php foreach ($map_locations as $i => $loc): ?>
                        <button
                            type="button"
                            class="locations-map-chip<?php echo $i === 1 ? ' is-active' : ''; ?>"
                            role="tab"
                            aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>"
                            data-loc-key="<?php echo htmlspecialchars($loc['key']); ?>"
                            data-lat="<?php echo htmlspecialchars((string) $loc['lat']); ?>"
                            data-lng="<?php echo htmlspecialchars((string) $loc['lng']); ?>"
                            data-zoom="<?php echo htmlspecialchars((string) $loc['zoom']); ?>"
                        >
                            <span class="locations-map-chip-dot" aria-hidden="true"></span>
                            <span class="locations-map-chip-label"><?php echo htmlspecialchars($loc['city']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <p class="locations-map-hint">
                    <i class="flaticon-pin" aria-hidden="true"></i>
                    <?php echo __('locations_hint'); ?>
                </p>
            </div>
        </div>
    </div>

    <script type="application/json" id="locationsMapData"><?php
        echo json_encode(
            [
                'locations' => $map_locations,
                'i18n' => $map_i18n,
                'provider' => $useGoogleJsApi ? 'google' : 'leaflet',
            ],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    ?></script>
</<?php echo $map_wrapper_tag; ?>>

<?php if (!$useGoogleJsApi): ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php endif; ?>

<script>
(function () {
    'use strict';

    const PRIMARY = '#0055FF';
    const PRIMARY_DARK = '#003BB8';

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function buildPopupHtml(loc, i18n) {
        const mapsUrl = 'https://www.google.com/maps?q=' + encodeURIComponent(loc.lat + ',' + loc.lng);
        const phoneHref = 'tel:' + String(loc.phone || '').replace(/\s/g, '');
        const closeLabel = escapeHtml(i18n.close || 'Close');

        return (
            '<article class="map-popup-card">' +
                '<button type="button" class="map-popup-close" aria-label="' + closeLabel + '">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<div class="map-popup-inner">' +
                    '<div class="map-popup-media">' +
                        '<img src="' + escapeHtml(loc.image) + '" alt="" loading="lazy" width="80" height="80">' +
                        '<span class="map-popup-badge">' + escapeHtml(loc.badge || i18n.badge || '') + '</span>' +
                    '</div>' +
                    '<div class="map-popup-main">' +
                        '<p class="map-popup-region"><i class="flaticon-pin" aria-hidden="true"></i>' + escapeHtml(loc.label) + '</p>' +
                        '<h3 class="map-popup-title">' + escapeHtml(loc.city) + '</h3>' +
                        '<p class="map-popup-addr">' + escapeHtml(loc.address) + '</p>' +
                        '<div class="map-popup-contacts">' +
                            '<a class="map-popup-contact" href="' + escapeHtml(phoneHref) + '" title="' + escapeHtml(loc.phone) + '">' +
                                '<i class="flaticon-phone-call" aria-hidden="true"></i>' +
                                '<span>' + escapeHtml(loc.phone) + '</span>' +
                            '</a>' +
                            '<a class="map-popup-contact map-popup-contact--mail" href="mailto:' + escapeHtml(loc.email) + '" title="' + escapeHtml(loc.email) + '">' +
                                '<i class="flaticon-mail" aria-hidden="true"></i>' +
                            '</a>' +
                        '</div>' +
                        '<a class="map-popup-link" href="' + escapeHtml(mapsUrl) + '" target="_blank" rel="noopener noreferrer">' +
                            escapeHtml(i18n.directions || '') +
                            '<i class="flaticon-right-arrow" aria-hidden="true"></i>' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</article>'
        );
    }

    function markerHtml(city, key, active) {
        const cls = 'map-marker' + (active ? ' is-active' : '');
        return (
            '<div class="' + cls + '" data-marker-key="' + escapeHtml(key) + '">' +
                '<span class="map-marker-pill">' + escapeHtml(city) + '</span>' +
                '<span class="map-marker-pin" aria-hidden="true"></span>' +
            '</div>'
        );
    }

    function pillIconSvg(city) {
        const text = escapeHtml(city || '');
        const svg =
            '<svg xmlns="http://www.w3.org/2000/svg" width="156" height="52" viewBox="0 0 156 52">' +
            '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">' +
            '<stop offset="0%" stop-color="' + PRIMARY + '"/><stop offset="100%" stop-color="' + PRIMARY_DARK + '"/>' +
            '</linearGradient><filter id="s" x="-20%" y="-20%" width="140%" height="140%">' +
            '<feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="#0055FF" flood-opacity="0.35"/>' +
            '</filter></defs>' +
            '<g filter="url(#s)">' +
            '<rect x="4" y="4" width="148" height="32" rx="16" fill="url(#g)" stroke="#fff" stroke-width="2.5"/>' +
            '<text x="78" y="25" text-anchor="middle" fill="#fff" font-family="Urbanist,Arial,sans-serif" font-size="13" font-weight="700">' + text + '</text>' +
            '<path d="M78 40 L70 52 L86 52 Z" fill="url(#g)" stroke="#fff" stroke-width="2" stroke-linejoin="round"/>' +
            '</g></svg>';
        return {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg),
            scaledSize: new google.maps.Size(156, 52),
            anchor: new google.maps.Point(78, 52),
        };
    }

    function readPayload() {
        const dataEl = document.getElementById('locationsMapData');
        if (!dataEl) return null;
        try {
            return JSON.parse(dataEl.textContent || '{}');
        } catch (e) {
            return null;
        }
    }

    function setActiveChip(key) {
        document.querySelectorAll('.locations-map-chip').forEach(function (chip) {
            const on = chip.getAttribute('data-loc-key') === key;
            chip.classList.toggle('is-active', on);
            chip.setAttribute('aria-selected', on ? 'true' : 'false');
        });
    }

    function setActiveMarker(key) {
        document.querySelectorAll('.map-marker').forEach(function (el) {
            el.classList.toggle('is-active', el.getAttribute('data-marker-key') === key);
        });
    }

    /** Masque le marqueur ouvert ; le réaffiche à la fermeture de la popup. */
    function createMarkerVisibility(store, map, provider) {
        let hiddenKey = null;

        function reveal() {
            if (!hiddenKey) return;
            const entry = store.get(hiddenKey);
            if (entry) {
                if (provider === 'google') {
                    entry.marker.setMap(map);
                } else {
                    entry.marker.setOpacity(1);
                    const el = entry.marker.getElement();
                    if (el) {
                        el.style.pointerEvents = '';
                        el.style.visibility = '';
                    }
                }
            }
            hiddenKey = null;
            setActiveMarker('');
        }

        function conceal(key) {
            if (!key) return;
            if (hiddenKey && hiddenKey !== key) {
                reveal();
            }
            const entry = store.get(key);
            if (!entry) return;
            if (provider === 'google') {
                entry.marker.setMap(null);
            } else {
                entry.marker.setOpacity(0);
                const el = entry.marker.getElement();
                if (el) {
                    el.style.pointerEvents = 'none';
                    el.style.visibility = 'hidden';
                }
            }
            hiddenKey = key;
            setActiveMarker('');
        }

        function revealIfHidden(key) {
            if (hiddenKey === key) {
                reveal();
            }
        }

        return { reveal: reveal, conceal: conceal, revealIfHidden: revealIfHidden };
    }

    function wireChips(controller) {
        document.querySelectorAll('.locations-map-chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                const key = chip.getAttribute('data-loc-key');
                if (!key) return;
                controller.focusLocation(key);
            });
        });
    }

    function isMapMobile() {
        return window.matchMedia('(max-width: 991px)').matches;
    }

    function getOverlayBottomPadding() {
        const overlay = document.querySelector('.locations-map-overlay');
        if (!overlay) return isMapMobile() ? 110 : 80;
        return overlay.offsetHeight + (isMapMobile() ? 16 : 24);
    }

    function getLeafletPopupOffset() {
        if (!isMapMobile()) return [0, -6];
        return document.querySelector('.locations-map-embed') ? [0, 58] : [0, 42];
    }

    function getLeafletPopupOptions() {
        const pad = getOverlayBottomPadding();
        const edge = isMapMobile() ? 14 : 28;
        return {
            className: 'map-leaflet-popup',
            maxWidth: isMapMobile() ? 272 : 292,
            minWidth: isMapMobile() ? 240 : 260,
            offset: getLeafletPopupOffset(),
            autoPan: true,
            keepInView: true,
            autoPanPaddingTopLeft: L.point(edge, edge),
            autoPanPaddingBottomRight: L.point(edge, pad),
        };
    }

    /** Recadre la carte si la popup dépasse en haut (mobile / overlay bas). */
    function ensureLeafletPopupInView(map, mapEl, marker) {
        if (!map || !mapEl || !marker) return;
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                const popup = marker.getPopup();
                const popupEl = popup && popup.getElement();
                if (!popupEl) return;

                const mapRect = mapEl.getBoundingClientRect();
                const popRect = popupEl.getBoundingClientRect();
                const topGap = popRect.top - mapRect.top;
                const minTop = isMapMobile() ? 10 : 16;

                if (topGap < minTop) {
                    map.panBy([0, topGap - minTop], { animate: true, duration: 0.35 });
                }
            });
        });
    }

    function bindPopupClose(infoWindow, visibility) {
        if (!infoWindow || !google || !google.maps) return;
        google.maps.event.addListenerOnce(infoWindow, 'domready', function () {
            const closeBtn = document.querySelector('.map-popup-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    infoWindow.close();
                    visibility.reveal();
                }, { once: true });
            }
        });
    }

    function openGooglePopup(infoWindow, map, loc, i18n, visibility) {
        visibility.conceal(loc.key);
        infoWindow.setContent(buildPopupHtml(loc, i18n));
        infoWindow.open({
            map: map,
            position: { lat: loc.lat, lng: loc.lng },
        });
        bindPopupClose(infoWindow, visibility);
    }

    function initGoogle(payload) {
        const mapEl = document.getElementById('locationsMapCanvas');
        if (!mapEl || typeof google === 'undefined' || !google.maps) return;

        const locations = payload.locations || [];
        const i18n = payload.i18n || {};
        const infoWindow = new google.maps.InfoWindow({ maxWidth: 300 });
        const store = new Map();
        let visibility;

        const map = new google.maps.Map(mapEl, {
            center: { lat: 4.5, lng: 10.5 },
            zoom: 7,
            mapTypeControl: false,
            fullscreenControl: true,
            streetViewControl: false,
            clickableIcons: false,
            styles: [
                { featureType: 'poi', stylers: [{ visibility: 'off' }] },
                { featureType: 'transit', stylers: [{ visibility: 'off' }] },
            ],
        });

        visibility = createMarkerVisibility(store, map, 'google');

        const bounds = new google.maps.LatLngBounds();

        locations.forEach(function (loc) {
            if (!Number.isFinite(loc.lat) || !Number.isFinite(loc.lng)) return;
            const position = { lat: loc.lat, lng: loc.lng };
            bounds.extend(position);

            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: loc.city || '',
                icon: pillIconSvg(loc.city),
            });

            store.set(loc.key, { marker: marker, loc: loc });

            marker.addListener('click', function () {
                setActiveChip(loc.key);
                openGooglePopup(infoWindow, map, loc, i18n, visibility);
            });
        });

        google.maps.event.addListener(infoWindow, 'closeclick', function () {
            visibility.reveal();
        });

        if (!bounds.isEmpty()) {
            map.fitBounds(bounds, 56);
        }

        const controller = {
            focusLocation: function (key) {
                const entry = store.get(key);
                if (!entry) return;
                setActiveChip(key);
                map.setZoom(entry.loc.zoom || 14);
                map.panTo({ lat: entry.loc.lat, lng: entry.loc.lng });
                openGooglePopup(infoWindow, map, entry.loc, i18n, visibility);
            },
        };

        wireChips(controller);
        scheduleMapResize(map, 'google');
    }

    function scheduleMapResize(map, provider) {
        function run() {
            if (provider === 'leaflet' && map && typeof map.invalidateSize === 'function') {
                map.invalidateSize({ animate: false });
            }
            if (provider === 'google' && map && typeof google !== 'undefined' && google.maps) {
                google.maps.event.trigger(map, 'resize');
            }
        }
        setTimeout(run, 120);
        setTimeout(run, 480);
    }

    function initLeaflet(payload) {
        const mapEl = document.getElementById('locationsMapCanvas');
        if (!mapEl || typeof L === 'undefined') return;

        const locations = payload.locations || [];
        const i18n = payload.i18n || {};
        const store = new Map();

        const map = L.map(mapEl, {
            scrollWheelZoom: true,
            zoomControl: false,
        });

        const visibility = createMarkerVisibility(store, map, 'leaflet');

        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 19,
        }).addTo(map);

        const latLngs = [];

        locations.forEach(function (loc, index) {
            if (!Number.isFinite(loc.lat) || !Number.isFinite(loc.lng)) return;
            const latLng = [loc.lat, loc.lng];
            latLngs.push(latLng);

            const icon = L.divIcon({
                className: 'map-marker-leaflet',
                html: markerHtml(loc.city, loc.key, index === 0),
            });

            const marker = L.marker(latLng, { icon: icon }).addTo(map);
            marker.bindPopup(buildPopupHtml(loc, i18n), getLeafletPopupOptions());

            marker.on('popupopen', function () {
                setActiveChip(loc.key);
                visibility.conceal(loc.key);
                ensureLeafletPopupInView(map, mapEl, marker);
                const closeBtn = document.querySelector('.map-popup-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function onClose() {
                        marker.closePopup();
                    }, { once: true });
                }
            });
            marker.on('popupclose', function () {
                visibility.revealIfHidden(loc.key);
            });

            store.set(loc.key, { marker: marker, loc: loc });
        });

        if (latLngs.length) {
            map.fitBounds(latLngs, { padding: [56, 56], maxZoom: 8 });
        }

        const controller = {
            focusLocation: function (key) {
                const entry = store.get(key);
                if (!entry) return;
                setActiveChip(key);
                map.flyTo([entry.loc.lat, entry.loc.lng], entry.loc.zoom || 14, { duration: 0.85 });
                entry.marker.openPopup();
            },
        };

        wireChips(controller);
        scheduleMapResize(map, 'leaflet');
    }

    function boot() {
        const payload = readPayload();
        if (!payload) return;
        if (payload.provider === 'google') {
            initGoogle(payload);
        } else {
            initLeaflet(payload);
        }
    }

    window.initLocationsMap = boot;

    const payload = readPayload();
    if (payload && payload.provider === 'leaflet') {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot);
        } else {
            boot();
        }
    }
})();
</script>

<?php if ($useGoogleJsApi): ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo urlencode($googleMapsKey); ?>&callback=initLocationsMap"></script>
<?php endif; ?>
