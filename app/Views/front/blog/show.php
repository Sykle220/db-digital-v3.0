<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="blog-area pt-120 pb-120">
        <div class="container">
            <div class="inner-blog-wrap">
                <div class="row justify-content-center">
                    <div class="col-71">
                        <article class="blog-details-wrap">
                            <div class="blog-details-thumb">
                                <img src="<?= asset_url('img/blog/' . ($post['image'] ?? 'blog_img01.jpg')) ?>" alt="<?= esc((string) ($post['title'] ?? '')) ?>">
                            </div>
                            <div class="blog-details-content">
                                <div class="blog-meta">
                                    <ul class="list-wrap">
                                        <li><i class="far fa-calendar"></i><?= esc((string) ($post['date'] ?? '')) ?></li>
                                        <li><a href="<?= page_url('blog', $locale) ?>?category=<?= urlencode((string) ($post['category'] ?? '')) ?>"><?= esc((string) ($post['category'] ?? '')) ?></a></li>
                                    </ul>
                                </div>
                                <h1 class="title"><?= esc((string) ($post['title'] ?? '')) ?></h1>
                                <?php if (! empty($post['content'])): ?>
                                    <div class="blog-details-body"><?= $post['content'] ?></div>
                                <?php else: ?>
                                    <p><?= esc((string) ($post['excerpt'] ?? '')) ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
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
