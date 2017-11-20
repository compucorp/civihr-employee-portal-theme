<?php
$includesDir = __DIR__ . '/../../includes/';
$dependantsView = views_embed_view('emergency_contacts', 'dependant_emergency_contact');
$emergencyContactsView = views_embed_view('emergency_contacts', 'non_dependant_emergency_contact');
?>

<div id="outer-wrapper">
  <?php require_once $includesDir . 'header.inc'; ?>
  <?php require_once __DIR__ . '/page_body.tpl.php'; ?>

  <div class="container region region-content">
    <h2>Emergency Contacts</h2>
    <a href="/create-emergency-contact/js/view"
       class="ctools-use-modal ctools-modal-civihr-custom-style chr_action--icon--edit">
      Add Emergency Contact
    </a>
    <?php print $emergencyContactsView; ?>
  </div>

  <div class="container region region-content">
    <h2>Dependants</h2>
    <a href="/create-dependant/js/view"
       class="ctools-use-modal ctools-modal-civihr-custom-style chr_action--icon--edit">
      Add Dependant
    </a>
    <?php print $dependantsView; ?>
  </div>

  <? require_once $includesDir . 'footer.inc' ?>
</div>
