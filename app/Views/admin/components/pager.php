<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
if (! isset($pager) || $pager->getPageCount() <= 1) {
    return;
}

$pager->setSurroundCount(2);
$total     = (int) ($pager->getTotal() ?? 0);
$start     = (int) ($pager->getPerPageStart() ?? 0);
$end       = (int) ($pager->getPerPageEnd() ?? 0);
$current   = $pager->getCurrentPageNumber();
$pageCount = $pager->getPageCount();
?>
<div class="admin-pagination">
    <div class="admin-pagination__info">
        <?php if ($total > 0 && $start > 0): ?>
            Affichage <strong><?= $start ?>–<?= $end ?></strong> sur <strong><?= $total ?></strong>
            · page <?= $current ?> / <?= $pageCount ?>
        <?php else: ?>
            Page <?= $current ?> / <?= $pageCount ?>
        <?php endif; ?>
    </div>
    <nav aria-label="Pagination">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item<?= $current <= 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="<?= $current <= 1 ? '#' : esc($pager->getFirst(), 'attr') ?>" aria-label="Première page">
                    <i class="bi bi-chevron-double-left" aria-hidden="true"></i>
                </a>
            </li>
            <li class="page-item<?= $pager->getPreviousPageNumber() === null ? ' disabled' : '' ?>">
                <a class="page-link" href="<?= $pager->getPreviousPageNumber() === null ? '#' : esc($pager->getPreviousPage() ?? '#', 'attr') ?>" aria-label="Page précédente">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </a>
            </li>
            <?php foreach ($pager->links() as $link): ?>
            <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                <a class="page-link" href="<?= esc($link['uri'], 'attr') ?>"><?= (int) $link['title'] ?></a>
            </li>
            <?php endforeach; ?>
            <li class="page-item<?= $pager->getNextPageNumber() === null ? ' disabled' : '' ?>">
                <a class="page-link" href="<?= $pager->getNextPageNumber() === null ? '#' : esc($pager->getNextPage() ?? '#', 'attr') ?>" aria-label="Page suivante">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </a>
            </li>
            <li class="page-item<?= $current >= $pageCount ? ' disabled' : '' ?>">
                <a class="page-link" href="<?= $current >= $pageCount ? '#' : esc($pager->getLast(), 'attr') ?>" aria-label="Dernière page">
                    <i class="bi bi-chevron-double-right" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
