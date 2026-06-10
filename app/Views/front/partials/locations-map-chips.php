<?php
/**
 * Overlay carte : pastilles villes + hint.
 * Requiert $map_locations (array).
 */
/** @var list<array<string, mixed>> $map_locations */
$locale = $locale ?? service('request')->getLocale();
?>
<div class="locations-map-overlay" aria-hidden="false">
    <div class="locations-map-chips" role="tablist" aria-label="<?= esc(site_trans('locations_title', $locale)) ?>">
        <?php foreach ($map_locations as $i => $loc): ?>
            <button
                type="button"
                class="locations-map-chip<?= $i === 1 ? ' is-active' : '' ?>"
                role="tab"
                aria-selected="<?= $i === 1 ? 'true' : 'false' ?>"
                data-loc-key="<?= esc((string) ($loc['key'] ?? ''), 'attr') ?>"
                data-lat="<?= esc((string) ($loc['lat'] ?? ''), 'attr') ?>"
                data-lng="<?= esc((string) ($loc['lng'] ?? ''), 'attr') ?>"
                data-zoom="<?= esc((string) ($loc['zoom'] ?? ''), 'attr') ?>"
            >
                <span class="locations-map-chip-dot" aria-hidden="true"></span>
                <span class="locations-map-chip-label"><?= esc((string) ($loc['city'] ?? '')) ?></span>
            </button>
        <?php endforeach; ?>
    </div>
    <p class="locations-map-hint">
        <i class="flaticon-pin" aria-hidden="true"></i>
        <span class="locations-map-hint-text"><?= esc(site_trans('locations_hint', $locale)) ?></span>
    </p>
</div>
