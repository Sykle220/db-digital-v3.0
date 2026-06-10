<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="pb-80 pt-50">
        <div class="container">
            <div class="alert alert-success" role="alert">
                <strong><i class="fas fa-check-circle"></i> <?= $locale === 'fr' ? 'Demande envoyée !' : 'Request sent!' ?></strong>
                <p class="mb-0 mt-2">
                    <?php if ($quoteEmailOk): ?>
                        <i class="fas fa-envelope text-success"></i>
                        <?= $locale === 'fr' ? 'Votre demande a été envoyée par email. ' : 'Your request has been sent by email. ' ?>
                    <?php else: ?>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <?= $locale === 'fr' ? "L'email n'a pas pu être envoyé, mais " : 'Email could not be sent, but ' ?>
                    <?php endif; ?>
                    <?= $locale === 'fr' ? 'cliquez ci-dessous pour ouvrir WhatsApp et finaliser votre demande.' : 'click below to open WhatsApp and finalize your request.' ?>
                </p>
            </div>

            <div class="whatsapp-success-card text-center">
                <div class="whatsapp-icon"><i class="fab fa-whatsapp"></i></div>
                <h4><?= $locale === 'fr' ? 'Finalisez sur WhatsApp' : 'Finalize on WhatsApp' ?></h4>
                <p class="mb-4">
                    <?= $locale === 'fr'
                        ? 'Votre message est pré-rempli avec les détails de votre projet. Cliquez pour envoyer.'
                        : 'Your message is pre-filled with your project details. Click to send.' ?>
                </p>
                <a href="<?= esc($quoteWhatsappUrl ?? '', 'attr') ?>" class="btn btn-whatsapp-lg btn-has-i" target="_blank" id="waBtn">
                    <?= btn_icon('whatsapp') ?>
                    <?= $locale === 'fr' ? 'Ouvrir WhatsApp' : 'Open WhatsApp' ?>
                </a>
                <p class="auto-redirect-text mt-3">
                    <small><i class="fas fa-clock"></i>
                        <?= $locale === 'fr' ? 'Redirection automatique dans 3 secondes...' : 'Auto-redirecting in 3 seconds...' ?>
                    </small>
                </p>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
setTimeout(function() {
    document.getElementById('waBtn')?.click();
}, 3000);
</script>
<?= $this->endSection() ?>
