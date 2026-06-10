<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Détail du devis #<?= (int) $quote['id'] ?></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Client</dt><dd class="col-sm-9"><?= esc($quote['fullname']) ?></dd>
                    <dt class="col-sm-3">E-mail</dt><dd class="col-sm-9"><?= esc($quote['email']) ?></dd>
                    <dt class="col-sm-3">WhatsApp</dt><dd class="col-sm-9"><?= esc($quote['whatsapp']) ?></dd>
                    <dt class="col-sm-3">Sujet</dt><dd class="col-sm-9"><?= esc($quote['subject']) ?></dd>
                    <dt class="col-sm-3">Services</dt><dd class="col-sm-9"><?= esc($quote['service']) ?></dd>
                    <dt class="col-sm-3">Budget</dt><dd class="col-sm-9"><?= esc($quote['budget']) ?></dd>
                    <dt class="col-sm-3">Message</dt><dd class="col-sm-9"><?= nl2br(esc($quote['message'] ?? '')) ?></dd>
                </dl>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Journal d'activité</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($logs as $log): ?>
                <li class="list-group-item small">
                    <strong><?= esc($log['action_type']) ?></strong> — <?= esc($log['action_details'] ?? '') ?>
                    <span class="text-muted"><?= esc($log['created_at']) ?></span>
                </li>
                <?php endforeach; ?>
                <?php if (empty($logs)): ?>
                <li class="list-group-item text-muted">Aucun log</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form action="<?= site_url('admin/quotes/' . $quote['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select">
                            <?php foreach (['new', 'contacted', 'in_progress', 'completed', 'cancelled'] as $s): ?>
                            <option value="<?= $s ?>" <?= ($quote['status'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes internes</label>
                        <textarea name="notes" class="form-control" rows="4"><?= esc($quote['notes'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <label class="form-label">Lien magique prospect</label>
                <input type="text" class="form-control form-control-sm mb-2" value="<?= esc($magicUrl) ?>" readonly>
                <form action="<?= site_url('admin/quotes/' . $quote['id'] . '/resend-magic-link') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">Renvoyer par e-mail</button>
                </form>
            </div>
        </div>
        <a href="<?= site_url('admin/quotes') ?>" class="btn btn-link mt-2">← Retour à la liste</a>
    </div>
</div>
