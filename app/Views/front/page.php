<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="about-area-eleven pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <article class="cms-page-content">
                        <h1 class="title mb-30"><?= esc((string) ($page['title'] ?? '')) ?></h1>
                        <div class="content"><?= $page['body'] ?? $page['content'] ?? '' ?></div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
