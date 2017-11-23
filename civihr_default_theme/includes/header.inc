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
