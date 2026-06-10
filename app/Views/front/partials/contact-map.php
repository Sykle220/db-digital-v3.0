<?php
/**
 * Carte contact intégrée (colonne droite du split).
 * Parité avec components/contact-map.php
 *
 * Variables : $locations, $map_embedded (true par défaut ici)
 */
$locations = $locations ?? ($offices ?? []);
if (! is_array($locations) || $locations === []) {
    $locations = service('content')->getOffices($locale ?? service('request')->getLocale());
}

$map_embedded = $map_embedded ?? true;
$locale       = $locale ?? service('request')->getLocale();

$googleMapsKey  = (string) env('GOOGLE_MAPS_API_KEY', '');
$useGoogleJsApi = $googleMapsKey !== '';
$map_locations  = build_map_locations($locations, $locale);

$map_i18n = [
    'badge'      => site_trans('locations_badge', $locale),
    'directions' => site_trans('locations_directions', $locale),
    'close'      => $locale === 'fr' ? 'Fermer' : 'Close',
];

$map_wrapper_tag   = $map_embedded ? 'div' : 'section';
$map_wrapper_class = 'locations-map locations-map-pro' . ($map_embedded ? ' locations-map-embed' : '');
$map_stage_outer   = $map_embedded ? 'locations-map-stage-outer' : 'container-fluid locations-map-stage-outer';
?>
<<?= $map_wrapper_tag ?> class="<?= esc($map_wrapper_class, 'attr') ?>" aria-label="<?= esc(site_trans('locations_title', $locale)) ?>">

    <div class="<?= esc($map_stage_outer, 'attr') ?>">
        <div class="locations-map-stage">
            <div
                id="locationsMapCanvas"
                class="locations-map-frame"
                role="application"
                aria-label="<?= esc(site_trans('locations_title', $locale)) ?>"
            ></div>
            <?php $this->setData(['map_locations' => $map_locations, 'locale' => $locale]); ?>
            <?= $this->include('front/partials/locations-map-chips') ?>
        </div>
    </div>

    <script type="application/json" id="locationsMapData"><?= json_encode([
        'locations' => $map_locations,
        'i18n'      => $map_i18n,
        'provider'  => $useGoogleJsApi ? 'google' : 'leaflet',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</<?= $map_wrapper_tag ?>>

<?php if (! $useGoogleJsApi): ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php endif; ?>

<script src="<?= esc(asset_url('js/locations-map.js', true), 'attr') ?>"></script>
<?php if ($useGoogleJsApi): ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= urlencode($googleMapsKey) ?>&callback=initLocationsMap"></script>
<?php endif; ?>
