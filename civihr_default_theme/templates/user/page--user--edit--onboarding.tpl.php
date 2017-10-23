<?php

/**
 * @var array
 *   $page Contains all variables and details for the page
 *
 * When I tried using #access it deleted data (⊙︿⊙)
 * @see https://www.drupal.org/node/1267434
 *
 * @param array $element
 */
$hideElement = function (&$element) {
  $element['#prefix'] = '<div style="display:none;">';
  $element['#suffix'] = '</div>';
};


if (isset($page['content']['system_main'])) {
  $form = &$page['content']['system_main'];
} else {
  $form = [];
}

// Hide all form parts except account and actions
$formParts = element_get_visible_children($form);
$visibleParts = ['account', 'actions', 'form_token'];
$hiddenParts = array_diff($formParts, $visibleParts);
foreach ($hiddenParts as $part) {
  $hideElement($form[$part]);
}

// Hide all account parts except password
$accountParts = element_get_visible_children($form['account']);
$visibleAccountParts = ['pass', 'current_pass'];
$hiddenAccountParts = array_diff($accountParts, $visibleAccountParts);
foreach ($hiddenAccountParts as $accountPart) {
  $hideElement($form['account'][$accountPart]);
}

// Change the label on the form button
if (isset($page['content']['system_main']['actions']['submit']['#value'])) {
  $page['content']['system_main']['actions']['submit']['#value'] = 'Next';
}

// Load the progress bar
$criteria = ['title' => 'Welcome to CiviHR', 'type' => 'webform'];
$node = current(node_load_multiple(NULL, $criteria));
$pageLabels = webform_page_labels($node);
array_unshift($pageLabels, 'Password');
$variables = [
  'node' => $node,
  'page_num' => 1,
  'page_count' => count($pageLabels),
  'page_labels' => $pageLabels,
];
$progressBar = theme('webform_progressbar', $variables);

$prefix = 'civihr_onboarding_';
$logoKey = $prefix . 'organization_logo_fid';
$welcomeTextKey = $prefix . 'welcome_text';

$logoID = variable_get($logoKey);
$organizationLogoUrl = NULL;
if ($logoID) {
  $logo = file_load($logoID);
  $organizationLogoUrl = file_create_url($logo->uri);
}

$welcomeText = variable_get($welcomeTextKey, '');

?>

<?php require_once __DIR__ .  '/../../includes/header_basic.inc'; ?>

<div id="onboarding-password-form" class="onboarding-wizard-page">
  <div id="main-wrapper">
    <div id="main" class="main">
      <div>
        <?php if ($messages): ?>
          <div id="messages">
            <?php print $messages; ?>
          </div>
        <?php endif; ?>
      </div>
      <div id="content" class="collapse">
        <div class="progress_bar">
          <?php print $progressBar; ?>
        </div>
        <div class="onboarding-wizard-container">
          <h1 id="onboarding-welcome-message">
            Welcome to CiviHR
          </h1>
          <?php if($organizationLogoUrl): ?>
            <div id="onboarding-company-logo">
              <img src="<?php print $organizationLogoUrl; ?>">
            </div>
          <?php endif; ?>
          <div id="onboarding-welcome-text">
            <?php print $welcomeText; ?>
          </div>
          <div class="main-container">
            <?php print render($page['content']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once __DIR__ . '/../../includes/footer.inc'; ?>
</div>
