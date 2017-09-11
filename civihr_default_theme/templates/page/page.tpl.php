<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * NOTE: The #outer-wrapper element is for the mobile menu to have a way
 * both to stick at the top of the page and to be as tall as the content (necessary because of the Drupal toolbar)
 */
?>

<div id="outer-wrapper">

  <?php require_once __DIR__ . '/../../includes/header.inc' ?>

  <div id="main-wrapper">
    <div id="main" class="main">
      <div class="container">
        <?php if ($breadcrumb): ?>
          <div id="breadcrumb" class="visible-desktop">
            <?php print $breadcrumb; ?>
          </div>
        <?php endif; ?>
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
      <div id="content" class="<?php print $container_class; ?> collapse">
        <div class="main-container">
          <?php print render($page['content']); ?>
        </div>
      </div>
    </div> <!-- /#main -->
    <?php
      module_load_include('inc', 'webform_civicrm', 'includes/wf_crm_admin_help');
      print wf_crm_admin_help::helpTemplate();
    ?>
  </div> <!-- /#main-wrapper -->

  <?php require_once __DIR__ . '/../../includes/footer.inc' ?>

</div><!-- /#outer-wrapper -->
