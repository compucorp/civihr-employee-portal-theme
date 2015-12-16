<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_js_alter().
 *
 * The Bootstrap theme includes an old version of CTool's modal, which doesn't pass
 * a custom class to the modal element. So we swap it with a newer version.
 *
 */
function civihr_admin_theme_js_alter(&$javascript) {

  // Add Ctools modal file included in the Bootstrap theme when required.
  if (module_exists('ctools')) {
    $ctools_modal = drupal_get_path('module', 'ctools') . '/js/modal.js';
    $old_bootstrap_modal_js = drupal_get_path('theme', 'bootstrap') . '/js/modules/ctools/js/modal.js';

    // Unset the old modal.js -> from the parent theme
    unset($javascript[$old_bootstrap_modal_js]);

    // Add the new modal.js
    $new_modal = drupal_get_path('theme', 'civihr_admin_theme') . '/js/modal.js';

    if (!empty($javascript[$ctools_modal]) && empty($javascript[$new_modal])) {
      $javascript[$new_modal] = array_merge(
          drupal_js_defaults(), array('group' => JS_THEME, 'data' => $new_modal));
    }
  }
}

/**
 * Adds JS specific to the civihr_reports page
 * @TODO -> do we actually need this? reports.js is loaded through civihr_employee_portal_module anyways || Needs review
 */
function civihr_admin_theme_preprocess_page(&$variables) {
    if (arg(0) == 'civihr_reports') {
        drupal_add_js(drupal_get_path('theme', 'civihr_admin_theme') . '/js/reports.js');
        $vars['scripts'] = drupal_get_js();
    }
}

/**
 * @param $variables
 * Add custom css from civicrm or fallback to defaults
 */
function civihr_admin_theme_preprocess_html(&$variables) {

    // This will try to load the bootstrapcivihr extension and load the css styles from there
    // Otherwise it will fallback to the theme default styles
    try {
        // @TODO -> we should have a check if these extensions are actually enabled
        $civicrm_path = CRM_Extension_System::singleton()->getMapper()->keyToUrl('org.civicrm.bootstrapcivicrm');
        $civihr_path = CRM_Extension_System::singleton()->getMapper()->keyToUrl('org.civicrm.bootstrapcivihr');

        drupal_add_css($civicrm_path . '/css/bootstrap-civicrm-style.css', array('group' => CSS_THEME, 'preprocess' => FALSE));
        drupal_add_css($civihr_path . '/css/bootstrap-civihr-style.css', array('group' => CSS_THEME, 'preprocess' => FALSE));

        _add_bootstrap_plugins(array('tooltip')); // Uncomment if Bootstrap JS plugins are needed
    }
    catch (Exception $e) {
        // Fallback to default styles (if civi modules not found)
        drupal_add_css(path_to_theme() . '/css/style.css', array('group' => CSS_THEME, 'preprocess' => FALSE));
    }
}

/**
 *  Changes the structure of the report actions form
 *
 *  Hides the select dropdown and submit form, replaced with a Bootstrap's dropdown component
 */
function civihr_admin_theme_views_bulk_operations_form_alter(&$form, &$form_state, $vbo) {
    if ($form_state['step'] == 'views_form_views_form') {
        $form['#attributes'] = array('data-reports-actions-form' => '');
        $form['select']['#attributes'] = array('class' => array('hide'));
        $form['select']['#title'] = NULL;
        $form['foo']['#markup'] = _report_actions_dropdown_html($form['select']['operation']['#options']);
    }
}

/**
 * Loads the Bootstrap JS plugins from the CiviCRM org.civicrm.bootstrap extension
 *
 * @param array $plugins_list The list of plugins to include in the page
 */
function _add_bootstrap_plugins($plugins_list) {
    $bootstrap_path = CRM_Extension_System::singleton()->getMapper()->keyToUrl('org.civicrm.bootstrap');

    foreach ($plugins_list as $index => $plugin) {
        drupal_add_js($bootstrap_path . "/js/$plugin.js");
    }
}

/**
 * Creates the markup of the dropdown component, based on the <select>'s <options>
 *
 * @param array $options
 *   The list of <options>
 * @return string
 *   The dropdown html
 */
function _report_actions_dropdown_html($options) {
    return '
        <div class="dropdown" data-reports-actions-dropdown style="display: none;">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Select Action
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' .
                array_reduce(array_slice($options, 1), function ($html, $label) use ($options) {
                    return $html . "<li data-reports-actions-action data-action=\"" . array_search($label, $options) . "\">
                        <a>$label</a>
                    </li>";
                }, '')
            . '</ul>
        </div>
    ';
}
