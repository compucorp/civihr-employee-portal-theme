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

  $admin_link = l(t('CiviHR admin'), 'civicrm', array('html' => true));
  $ssp_link = l(t('CiviHR SSP'), 'dashboard', array('html' => true));
  $documents_link = l(t('Manage documents'), 'admin/content', array('html' => true));
  $users_link = l(t('Manage users'), 'admin/people', array('html' => true));
?>

<div id="outer-wrapper">
  <header class="chr_header">
    <div class="chr_header__corner">
      <div class="chr_header__nav__toggle">
        <i class="fa fa-2x fa-navicon"></i>
      </div>
      <div class="chr_header__corner__brand chr_brand chr_header__home-menu" title="<?php print htmlspecialchars($site_name); ?>">
          <span class="chr_brand__icon icon-logo"></span>
          <span><?php print t("Home"); ?></span>
        <ul class="chr_header__sub-menu">
          <li><?php print $admin_link; ?></li>
          <li><?php print $ssp_link; ?></li>
        </ul>
      </div>
    </div>
    <div class="chr_header__brand chr_brand chr_header__home-menu">
        <span class="chr_brand__icon icon-logo"></span>
        <span class="chr_brand__name"><span><?php print t("CiviHR"); ?></span></span>
        <ul class="chr_header__sub-menu">
          <li><?php print $admin_link; ?></li>
          <li><?php print $ssp_link; ?></li>
        </ul>
    </div>
    <nav class="chr_header__nav">
      <?php if ($main_menu): ?>
        <ul class="chr_header__nav__menu">
          <?php print render($main_menu); ?>
        </ul>
      <?php endif; ?>
    </nav>
    <?php if ($logged_in) { ?>
    <div class="chr_header__user-menu">
      <div class="chr_header__user-menu__data">
        <span class="chr_header__user-menu__name"><?php print $user_name; ?></span>
        <div class="chr_profile-card">
          <div class="chr_profile-card__picture chr_profile-card__picture--small">
            <?php if ($image_url != '') { ?>
              <img src="<?php print $image_url; ?>" alt="<?php print htmlspecialchars($user_name); ?>">
            <?php } ?>
          </div>
        </div>
        <i class="chr_header__user-menu__arrow fa fa-caret-down"></i>
      </div>
      <ul class="chr_header__sub-menu">
        <li><?php print $edit_account; ?></li>
        <li><?php print $logout_link; ?></li>
      </ul>
    </div>
    <?php } ?>
    <?php if (user_access("administer users") && user_access("administer nodes") ) { ?>
    <div class="chr_header__settings-menu">
      <i class="fa fa-cog" aria-hidden="true"></i>
      <ul class="chr_header__sub-menu">
        <li><?php print $documents_link; ?></li>
        <li><?php print $users_link; ?></li>
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
  </div> <!-- /#main-wrapper -->

  <footer id="footer" class="footer" role="footer">
    <div class="container">
      <div class="text-center">
        <div class="footer-logo">
          <i class="icon-logo-full"></i>
        </div>
        <?php if ($copyright): ?>
          <div class="copyright"><?php print $copyright; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </footer>
</div><!-- /#outer-wrapper -->
