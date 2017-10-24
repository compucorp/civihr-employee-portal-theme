<?php
/**
 * @var array
 *   $page Contains all data for this page
 */

require_once __DIR__ . '/../../includes/header.inc';
?>

<div class="container" id="onboarding-customization-page">
  <h1>Customize Welcome Wizard</h1>

  <p class="alert alert-success">
    On this page you can customize the welcome wizard that a new joiner will see
    when they first login to CiviHR. You can add your organization branding,
    welcome text, select which features of CiviHR to promote and also customize
    the information text when they complete the wizard.
  </p>

  <?php print drupal_render($page['content']) ?>
  <img class="onboarding-customize-logo"
    src="../../<?php print drupal_get_path('theme',$GLOBALS['theme']); ?>/assets/images/onboarding_wizard/logo-img.jpg"/>

  <img
    class="onboarding-customize-features"
    src="../../<?php print drupal_get_path('theme',$GLOBALS['theme']); ?>/assets/images/onboarding_wizard/features-img.jpg"/>

  <img
    class="onboarding-customize-welcome"
    src="../../<?php print drupal_get_path('theme',$GLOBALS['theme']); ?>/assets/images/onboarding_wizard/welcome-img.jpg"/>
</div>

<?php require_once __DIR__ . '/../../includes/footer.inc';
