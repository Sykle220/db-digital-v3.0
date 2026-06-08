<?php
// components/contact-card.php
?>

<div class="preview-wrap">
  <div class="cards-row">
    <?php foreach ($contact_departments as $dept): ?>
    <div class="contact-card">
      <div class="icon-wrap"><i class="fas <?php echo htmlspecialchars($dept['icon']); ?>" aria-hidden="true"></i></div>
      <div class="body">
        <p class="card-title"><?php echo __($dept['title_key']); ?></p>
        <p class="card-email"><?php echo htmlspecialchars($dept['email']); ?></p>
        <p class="card-subtitle"><?php echo __($dept['desc_key']); ?></p>
      </div>
      <span class="chev"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>
