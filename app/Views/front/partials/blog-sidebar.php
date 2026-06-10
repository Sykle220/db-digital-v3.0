<aside class="blog-sidebar">
    <div class="sidebar-search">
        <form action="<?= page_url('blog', $locale) ?>" method="GET">
            <input type="text" name="search" placeholder="<?= esc(site_trans('search_placeholder', $locale)) ?>" value="<?= esc($filterSearch ?? '') ?>">
            <button type="submit"><i class="flaticon-search"></i></button>
        </form>
    </div>

    <div class="blog-widget">
        <h4 class="bw-title"><?= esc(site_trans('blog_sidebar_categories', $locale)) ?></h4>
        <div class="bs-cat-list">
            <ul class="list-wrap">
                <?php foreach ($categories as $cat): ?>
                <li>
                    <a href="<?= page_url('blog', $locale) ?>?category=<?= urlencode((string) ($cat['name'] ?? '')) ?>">
                        <?= esc((string) ($cat['name'] ?? '')) ?> <span>(<?= (int) ($cat['count'] ?? 0) ?>)</span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="blog-widget">
        <h4 class="bw-title"><?= esc(site_trans('blog_sidebar_recent', $locale)) ?></h4>
        <div class="rc-post-wrap">
            <?php foreach ($recentPosts as $rc): ?>
            <div class="rc-post-item">
                <div class="thumb">
                    <a href="<?= page_url('blog', $locale) . '/' . rawurlencode((string) ($rc['slug'] ?? '')) ?>">
                        <img src="<?= asset_url('img/blog/' . ($rc['image'] ?? 'blog_img01.jpg')) ?>" alt="<?= esc((string) ($rc['title'] ?? '')) ?>">
                    </a>
                </div>
                <div class="content">
                    <span class="date"><i class="far fa-calendar"></i><?= esc((string) ($rc['date'] ?? '')) ?></span>
                    <h2 class="title"><a href="<?= page_url('blog', $locale) . '/' . rawurlencode((string) ($rc['slug'] ?? '')) ?>"><?= esc((string) ($rc['title'] ?? '')) ?></a></h2>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="blog-widget">
        <h4 class="bw-title"><?= esc(site_trans('blog_sidebar_tags', $locale)) ?></h4>
        <div class="bs-tag-list">
            <ul class="list-wrap">
                <?php foreach ($tags as $tag): ?>
                <li><a href="<?= page_url('blog', $locale) ?>?tag=<?= urlencode((string) ($tag['name'] ?? '')) ?>"><?= esc((string) ($tag['name'] ?? '')) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</aside>
