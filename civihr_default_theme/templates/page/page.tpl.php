<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 */
?>
<header id="header" class="header" role="header">
    <nav class="navbar navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
          <span class="sr-only"><?php print t('Toggle navigation'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?php print $front_page; ?>" id="logo" class="navbar-brand" title="<?php print $site_name; ?>">
          <i class="icon-logo"></i>
        </a>
      </div> <!-- /.navbar-header -->

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse">

        <?php if ($main_menu): ?>
          <ul id="main-menu" class="menu nav navbar-nav">
            <?php print render($main_menu); ?>
          </ul>
        <?php endif; ?>

      </div><!-- /.navbar-collapse -->

      <?php if ($logged_in) { ?>

      <div class="civihr_user-menu">
        <div class="civihr_user-menu__data">
          <span class="civihr_user-menu__name"><?php print $user_name; ?></span>
          <?php if ($image_url != '') { ?>
            <img class="civihr_user-menu__picture" src="<?php print $image_url; ?>" alt="<?php print htmlspecialchars($user_name); ?>">
          <?php } ?>
          <i class="civihr_user-menu__arrow fa fa-caret-down"></i>
        </div>
        <ul class="civihr_user-menu__sub-menu">
          <li><?php print $edit_account; ?></li>
          <li><?php print $logout_link; ?></li>
        </ul>
      </div>

      <?php } ?>
    </nav><!-- /.navbar -->
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
    <div id="content" class="container collapse">
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
