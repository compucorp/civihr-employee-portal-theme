<?php

/**
 * @var array $page Contains all variables and details for the page
 * @var string $container_class
 */

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
  hide($form[$part]);
}

// Hide all account parts except password
$accountParts = element_get_visible_children($form['account']);
$visibleAccountParts = ['pass', 'current_pass'];
$hiddenAccountParts = array_diff($accountParts, $visibleAccountParts);
foreach ($hiddenAccountParts as $accountPart) {
  hide($form['account'][$accountPart]);
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

?>

<div id="outer-wrapper">
  <div id="main-wrapper">
    <div id="main" class="main">
      <div class="container">
        <?php if ($messages): ?>
          <div id="messages">
            <?php print $messages; ?>
          </div>
        <?php endif; ?>
      </div>

      <div id="content" class="<?php print $container_class; ?> collapse">

        <div class="progress_bar">
          <?php print $progressBar; ?>
        </div>

        <div class="main-container">
          <?php print render($page['content']); ?>
        </div>
      </div>
    </div>
  </div>

  <?php require_once __DIR__ . '/../../includes/footer.inc'; ?>
</div>
