<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="blog-area pt-120 pb-120">
        <div class="container">
            <div class="inner-blog-wrap">
                <div class="row justify-content-center">
                    <div class="col-71">
                        <div class="blog-post-wrap">
                            <div class="row">
                                <?php if (empty($posts)): ?>
                                <div class="col-12">
                                    <div class="alert alert-info"><?= esc(site_trans('blog_no_posts', $locale)) ?></div>
                                </div>
                                <?php else: ?>
                                    <?php foreach ($posts as $post): ?>
                                    <div class="col-md-6">
                                        <div class="blog-post-item-two">
                                            <div class="blog-post-thumb-two">
                                                <a href="<?= page_url('blog', $locale) . '/' . rawurlencode((string) ($post['slug'] ?? '')) ?>">
                                                    <img src="<?= asset_url('img/blog/' . ($post['image'] ?? 'blog_img01.jpg')) ?>" alt="<?= esc((string) ($post['title'] ?? '')) ?>">
                                                </a>
                                                <a href="<?= page_url('blog', $locale) ?>?category=<?= urlencode((string) ($post['category'] ?? '')) ?>" class="tag tag-two"><?= esc((string) ($post['category'] ?? '')) ?></a>
                                            </div>
                                            <div class="blog-post-content-two">
                                                <h2 class="title">
                                                    <a href="<?= page_url('blog', $locale) . '/' . rawurlencode((string) ($post['slug'] ?? '')) ?>"><?= esc((string) ($post['title'] ?? '')) ?></a>
                                                </h2>
                                                <p><?= esc((string) ($post['excerpt'] ?? '')) ?></p>
                                                <div class="blog-meta">
                                                    <ul class="list-wrap">
                                                        <li>
                                                            <a href="<?= page_url('blog', $locale) . '/' . rawurlencode((string) ($post['slug'] ?? '')) ?>">
                                                                <img src="<?= asset_url('img/blog/' . ($post['avatar'] ?? 'avatar.png')) ?>" alt="<?= esc((string) ($post['author'] ?? '')) ?>">
                                                                <?= esc((string) ($post['author'] ?? '')) ?>
                                                            </a>
                                                        </li>
                                                        <li><i class="far fa-calendar"></i><?= esc((string) ($post['date'] ?? '')) ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-29">
                        <?= $this->include('front/partials/blog-sidebar') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
