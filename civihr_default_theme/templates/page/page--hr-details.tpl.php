<?php
$includesDir = __DIR__ . '/../../includes/';
$dependantsView = views_embed_view('emergency_contacts', 'dependant_emergency_contact');
$emergencyContactsView = views_embed_view('emergency_contacts', 'non_dependant_emergency_contact');
?>

<div id="outer-wrapper">
  <?php require_once $includesDir . 'header.inc'; ?>
  <?php require_once __DIR__ . '/page_body.tpl.php'; ?>

  <div class="container region region-content chr_hr_details-emergency_contacts">
    <h1 class="chr_hr_details-header">Emergency Contacts</h1>
    <a
      href="/create-emergency-contact/js/view"
      class="ctools-use-modal ctools-modal-civihr-custom-style chr_hr_details-add_contacts chr_action--icon">
      <i class="fa fa-user-plus" aria-hidden="true"></i> Add Emergency Contact
    </a>
    <?php print $emergencyContactsView; ?>
  </div>

  <div class="container region region-content chr_hr_details-dependents">
    <h1 class="chr_hr_details-header">Dependants</h1>
    <a
      href="/create-dependant/js/view"
      class="ctools-use-modal ctools-modal-civihr-custom-style chr_hr_details-add_contacts chr_action--icon">
      <i class="fa fa-user-plus" aria-hidden="true"></i> Add Dependant
    </a>
    <?php print $dependantsView; ?>
  </div>

  <?php require_once $includesDir . 'footer.inc' ?>
</div>
