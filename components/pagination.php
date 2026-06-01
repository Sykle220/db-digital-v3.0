<?php
// components/pagination.php
// Paramètres: $current_page, $total_pages, $base_url
$current_page = $current_page ?? 1;
$total_pages = $total_pages ?? 4;
$base_url = $base_url ?? '?page=';
?>
<div class="pagination-wrap mt-30">
    <nav aria-label="Page navigation">
        <ul class="pagination list-wrap">
            <?php if ($current_page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $base_url . ($current_page - 1); ?>"><i class="fas fa-angle-double-left"></i></a>
            </li>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $base_url . $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            
            <?php if ($current_page < $total_pages): ?>
            <li class="page-item next-page">
                <a class="page-link" href="<?php echo $base_url . ($current_page + 1); ?>"><i class="fas fa-angle-double-right"></i></a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>