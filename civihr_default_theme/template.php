<?php
/**
 * @file
 * Theme functions
 */

require_once dirname(__FILE__) . '/includes/structure.inc';
require_once dirname(__FILE__) . '/includes/comment.inc';
require_once dirname(__FILE__) . '/includes/form.inc';
require_once dirname(__FILE__) . '/includes/menu.inc';
require_once dirname(__FILE__) . '/includes/node.inc';
require_once dirname(__FILE__) . '/includes/panel.inc';
require_once dirname(__FILE__) . '/includes/user.inc';
require_once dirname(__FILE__) . '/includes/view.inc';

/**
 * Implements hook_css_alter().
 */
function civihr_default_theme_css_alter(&$css) {
  $radix_path = drupal_get_path('theme', 'radix');

  // Radix now includes compiled stylesheets for demo purposes.
  // We remove these from our subtheme since they are already included 
  // in compass_radix.
  unset($css[$radix_path . '/assets/stylesheets/radix-style.css']);
  unset($css[$radix_path . '/assets/stylesheets/radix-print.css']);
}

/**
 * Implements template_preprocess_page().
 */
function civihr_default_theme_preprocess_page(&$variables) {
  // Add custom copyright to theme.
  if ($copyright = theme_get_setting('copyright')) {
    $variables['copyright'] = check_markup($copyright['value'], $copyright['format']);
  }
  else {
    // Set empty copyright message by default
    // This will override the default copyright message from radix
    $variables['copyright'] = '';
  }
}

/**
 * Implements hook_js_alter().
 */
function civihr_default_theme_js_alter(&$javascript) {

  // Add radix-modal when required.
  if (module_exists('ctools')) {
    $ctools_modal = drupal_get_path('module', 'ctools') . '/js/modal.js';

    $old_radix_modal_js = drupal_get_path('theme', 'radix') . '/assets/javascripts/radix-modal.js';

    // Unset the old radix-modal.js -> from the parent theme
    unset($javascript[$old_radix_modal_js]);

    // Add the new radix-modal.js (can be renamed to something else)
    $radix_modal = drupal_get_path('theme', 'civihr_default_theme') . '/assets/javascripts/radix-modal.js';
    if (!empty($javascript[$ctools_modal]) && empty($javascript[$radix_modal])) {
      $javascript[$radix_modal] = array_merge(
          drupal_js_defaults(), array('group' => JS_THEME, 'data' => $radix_modal));
    }
  }
}
