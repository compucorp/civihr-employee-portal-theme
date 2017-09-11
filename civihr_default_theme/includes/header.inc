<?php

$civicrm_access = user_access("access CiviCRM");
$admin_link = l(t('CiviHR admin'), 'civicrm/tasksassignments/dashboard', ['fragment' => '/tasks']);
$options = array('html' => TRUE);
$ssp_link = l(t('CiviHR SSP'), 'dashboard', $options);

$resourceTypeVocabularyID = taxonomy_vocabulary_machine_name_load('hr_resource_type')->vid;
$mapGearLinks = [
  [
    'permissions' => ["access content overview"],
    'link' => l(t('Manage documents'), 'admin/content', $options),
  ],
  [
    'permissions' => ["administer users", "access users overview"],
    'link' => l(t('Manage users'), 'admin/people', $options),
  ],
  [
    'permissions' => ["edit terms in {$resourceTypeVocabularyID}"],
    'link' => l(t('HR resource types'), 'hr-resource-types-list', $options)
  ],
  [
    'permissions' => ["customize welcome wizard"],
    'link' => l(t('Customize Webform Wizard'), 'civicrm/customize-webform', $options),
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
