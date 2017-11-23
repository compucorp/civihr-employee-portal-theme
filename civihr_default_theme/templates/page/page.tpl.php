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
  <header class="chr_header">
    <div class="chr_header__corner">
      <div class="chr_header__nav__toggle">
        <i class="fa fa-2x fa-navicon"></i>
      </div>
      <a href="/dashboard" class="chr_header__logo">
        <span class="chr_logo"></span>
      </a>
    </div>
    <div class="chr_header__logo">
      <span class="chr_logo chr_logo--full"><i></i></span>
    </div>
    <nav class="chr_header__nav">
      <?php if ($main_menu): ?>
        <ul class="chr_header__nav__menu">
          <?php print render($main_menu); ?>
        </ul>
      <?php endif; ?>
    </nav>
    <?php
      if ($logged_in) {
        print((new CRM_HRCore_UserMenuMarkup())->getMarkup());
      }
    ?>
    <?php if (!empty($cog_menu_markup)) { ?>
    <div class="chr_header__settings-menu">
      <i class="fa fa-cog" aria-hidden="true"></i>
      <ul class="chr_header__sub-menu">
        <?php print $cog_menu_markup; ?>
      </ul>
    </div>
    <?php } ?>
  </header>

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
        CiviHR is openly available under the <a target="_blank" href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPL License</a> and can be downloaded from the <a target="_blank" href="https://civihr.org">Project website</a>&nbsp;.
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
