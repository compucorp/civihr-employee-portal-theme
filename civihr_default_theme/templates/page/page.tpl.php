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
 *
 * @var array $page
 */
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

    require_once __DIR__ . '/page_body.tpl.php';
    require_once $includesDir . 'footer.inc'
  ?>
</div>
