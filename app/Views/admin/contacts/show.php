<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <span class="fw-semibold"><?= esc($contact['name']) ?></span>
                <span class="badge bg-secondary"><?= esc($contact['status']) ?></span>
            </div>
            <div class="card-body">
                <p><strong>E-mail :</strong> <a href="mailto:<?= esc($contact['email'], 'attr') ?>"><?= esc($contact['email']) ?></a></p>
                <p><strong>Téléphone :</strong> <?= esc($contact['phone']) ?></p>
                <hr>
                <p><?= nl2br(esc($contact['message'])) ?></p>
                <p class="small text-muted">Reçu le <?= esc($contact['created_at']) ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="<?= site_url('admin/contacts/' . $contact['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select mb-3">
                        <?php foreach (['new', 'read', 'replied', 'archived'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($contact['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
        <a href="<?= site_url('admin/contacts') ?>" class="btn btn-link mt-2">← Retour</a>
    </div>
</div>
