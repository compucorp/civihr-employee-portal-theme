<?php

/**
 * @file
 * template.php
 */

/**
 * Adds JS specific to the civihr_reports page
 */
function civihr_admin_theme_preprocess_page(&$variables) {
    if (arg(0) == 'civihr_reports') {
        drupal_add_js(drupal_get_path('theme', 'civihr_admin_theme') . '/js/reports.js');
        $vars['scripts'] = drupal_get_js();
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
                array_reduce($options, function ($html, $label) {
                    return $html . "<li data-reports-actions-action><a>$label</a></li>";
                }, '')
            . '</ul>
        </div>
    ';
}
