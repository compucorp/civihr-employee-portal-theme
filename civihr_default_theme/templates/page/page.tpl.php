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

  $civicrm_access = user_access("access CiviCRM");
  $admin_link = l(t('CiviHR admin'), 'civicrm/tasksassignments/dashboard', ['fragment' => '/tasks']);
  $ssp_link = l(t('CiviHR SSP'), 'dashboard', array('html' => true));

  $resourceTypeVocabularyID = taxonomy_vocabulary_machine_name_load('hr_resource_type')->vid;
  $mapGearLinks = [
    [
      'permissions' => ["access content overview"],
      'link' => l(t('Manage documents'), 'admin/content', array('html' => true)),
    ],
    [
      'permissions' => ["administer users", "access users overview"],
      'link' => l(t('Manage users'), 'admin/people', array('html' => true)),
    ],
    [
      'permissions' => ["edit terms in {$resourceTypeVocabularyID}"],
      'link' => l(t('HR resource types'), 'hr-resource-types-list', array('html' => true))
    ],
  ];
  $gearLinks = "";
  foreach($mapGearLinks as $link) {
    foreach ($link['permissions'] as $permission) {
      if (user_access($permission)) {
        $gearLinks .= "<li>{$link['link']}</li>";
        break;
      }
    }
  }
?>

<div id="outer-wrapper">
  <header class="chr_header">
    <div class="chr_header__corner">
      <div class="chr_header__nav__toggle">
        <i class="fa fa-2x fa-navicon"></i>
      </div>
      <?php if (!$civicrm_access): ?>
        <a href="/dashboard">
      <?php endif; ?>
        <div class="chr_header__corner__brand chr_brand chr_header__home-menu" title="<?php print htmlspecialchars($site_name); ?>">
          <span class="chr_brand__icon icon-logo"></span>
          <span><?php print t("Home"); ?></span>
          <?php if ($civicrm_access) { ?>
            <ul class="chr_header__sub-menu">
              <li><?php print $admin_link; ?></li>
              <li><?php print $ssp_link; ?></li>
            </ul>
          <?php }?>
        </div>
      <?php if (!$civicrm_access): ?>
        </a>
      <?php endif; ?>
    </div>
    <div class="chr_header__brand chr_brand chr_header__home-menu">
        <span class="chr_brand__icon icon-logo"></span>
        <span class="chr_brand__name"><span><?php print t("CiviHR"); ?></span></span>
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
        <li><?php print $user_guide_link; ?></li>
        <li><?php print $logout_link; ?></li>
      </ul>
    </div>
    <?php } ?>
    <?php if (!empty($gearLinks)) { ?>
    <div class="chr_header__settings-menu">
      <i class="fa fa-cog" aria-hidden="true"></i>
      <ul class="chr_header__sub-menu">
        <?php print $gearLinks ?>
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
        Powered by CiviHR <?php print get_civihr_version(); ?>.
        CiviHR is openly available under the <a target="_blank" href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPL License</a> and can be downloaded from the <a target="_blank" href="https://civihr.org">Project website</a>&nbsp;.
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
