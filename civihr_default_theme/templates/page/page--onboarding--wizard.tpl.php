<?php

/**
 * @var array $page
 */
?>

<div id="outer-wrapper" class="onboarding-wizard-page">
  <?php
    $includesDir = __DIR__ . '/../../includes/';
    require_once $includesDir . 'header_basic.inc';
  ?>

  <div id="main-wrapper">

    <div id="main" class="main">

      <div>
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
          <?php if ($tabs): ?>
            <div class="tabs">
              <?php print render($tabs); ?>
            </div>
          <?php endif; ?>
          <?php if ($action_links): ?>
            <ul class="action-links">
              <?php print render($action_links); ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

      <div class="main-container">
        <?php print render($page['content']); ?>
      </div>

    </div>
  </div>

  <?php require_once $includesDir . 'footer.inc' ?>

</div>
