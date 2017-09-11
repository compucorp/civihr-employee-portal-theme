<?php
/**
 * @var array $page Contains all data for this page
 */

require_once __DIR__ . '/../../includes/header.inc';
?>

<style>
  #edit-civihr-onboarding-welcome-text-format {
    display: none;
  }
</style>

<div id="onboarding-customization-page">
  <h1>Customize Welcome Wizard</h1>

  <p id="onboarding">
    On this page you can customize the welcome wizard that a new joiner will see
    when they first login to CiviHR. You can add your organization branding,
    welcome text, select which features of CiviHR to promote and also customize
    the information text when they complete the wizard.
  </p>

  <?php print drupal_render($page['content']) ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.inc';
