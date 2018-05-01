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

$includesDir = __DIR__ . '/../../includes/';

?>

<div id="outer-wrapper">

  <?php
  $includesDir = __DIR__ . '/../../includes/';
  // For some pages we don't want to show the user menu
  $headerStyle = isset($page['header_style']) ? $page['header_style'] : NULL;

  if ($headerStyle === 'basic') {
  require_once $includesDir . 'header_basic.inc';
  } else {
  require_once $includesDir . 'header.inc';
  }
  ?>

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

  <footer id="footer" class="footer" role="footer">
    <div class="container">
      <div class="text-center">
        Powered by CiviHR <?php print get_civihr_version(); ?>.
        CiviHR is openly available under Version 3 of the <a target="_blank" href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPL License</a> and can be downloaded from <a target="_blank" href="https://civihr.org">www.civihr.org</a>&nbsp;.
        <div class="footer-logo">
          <span class="chr_logo chr_logo--full"><i></i></span>
        </div>
        <?php if ($copyright): ?>
          <div class="copyright"><?php print $copyright; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </footer>
</div><!-- /#outer-wrapper -->
