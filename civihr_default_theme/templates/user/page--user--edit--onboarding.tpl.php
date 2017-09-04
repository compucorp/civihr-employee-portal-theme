<?php

/** @var array $page Contains all variables and details for the page */
if (isset($page['content']['system_main'])) {
  $form = &$page['content']['system_main'];
} else {
  $form = [];
}

// hide all form parts except account and actions
$formParts = element_get_visible_children($form);
$visibleParts = ['account', 'actions', 'form_token'];
$hiddenParts = array_diff($formParts, $visibleParts);
foreach ($hiddenParts as $part) {
  hide($form[$part]);
}

// hide all account parts except password
$accountParts = element_get_visible_children($form['account']);
$visibleAccountParts = ['pass', 'current_pass'];
$hiddenAccountParts = array_diff($accountParts, $visibleAccountParts);
foreach ($hiddenAccountParts as $accountPart) {
  hide($form['account'][$accountPart]);
}
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
        <div id="page-header">
          <?php if ($title): ?>
            <div class="page-header">
              <h1 class="title"><?php print $title; ?></h1>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div id="content" class="<?php print $container_class; ?> collapse">
        <div class="main-container">
          <?php print render($page['content']); ?>
        </div>
      </div>
    </div>
  </div>

  <?php require_once __DIR__ . '/../../includes/footer.inc'; ?>
</div>
