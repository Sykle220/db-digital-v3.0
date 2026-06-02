<?php
// components/contact-card.php
// Reçoit un tableau $contact
?>

<div class="preview-wrap">
  <div class="cards-row">
    <div class="contact-card">
      <div class="icon-wrap"><i class="fas fa-shopping-bag" aria-hidden="true"></i></div>
      <div class="body">
        <p class="card-title"><?php echo __('contact_sales_title'); ?></p>
        <p class="card-email">sales@dbdigitalagency.com</p>
        <p class="card-subtitle"><?php echo __('contact_sales_desc'); ?></p>
      </div>
      <span class="chev"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
    </div>
    <div class="contact-card">
      <div class="icon-wrap"><i class="fas fa-envelope-open-text" aria-hidden="true"></i></div>
      <div class="body">
        <p class="card-title"><?php echo __('contact_general_title'); ?></p>
        <p class="card-email">contact@dbdigitalagency.com</p>
        <p class="card-subtitle"><?php echo __('contact_general_desc'); ?></p>
      </div>
      <span class="chev"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
    </div>
    <div class="contact-card">
      <div class="icon-wrap"><i class="fas fa-headset" aria-hidden="true"></i></div>
      <div class="body">
        <p class="card-title"><?php echo __('contact_support_title'); ?></p>
        <p class="card-email">support@dbdigitalagency.com</p>
        <p class="card-subtitle"><?php echo __('contact_support_desc'); ?></p>
      </div>
      <span class="chev"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
    </div>
  </div>
</div>
