<header class="chr_header">
  <div class="chr_header__brand chr_brand chr_header__home-menu">
    <span class="chr_brand__icon icon-logo"></span>
    <span class="chr_brand__name"><span><?php print t("CiviHR"); ?></span></span>
  </div>
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
</header>
