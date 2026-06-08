<?php
/**
 * Overlay carte : pastilles villes + hint.
 * Requiert $map_locations (array).
 */
?>
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
        <span class="locations-map-hint-text"><?php echo __('locations_hint'); ?></span>
    </p>
</div>
