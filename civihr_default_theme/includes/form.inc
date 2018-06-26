<?php
/**
 * @file
 * Theme and preprocess functions for forms
 */


/**
 * Implements theme_button().
 */
function civihr_default_theme_button($variables) {
    $element = $variables['element'];
    $element['#attributes']['type'] = 'submit';
    element_set_attributes($element, array('id', 'name', 'value'));

    $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
    $element['#attributes']['class'][] = 'btn';

    if (!empty($element['#attributes']['disabled'])) {
      $element['#attributes']['class'][] = 'form-button-disabled';
    }
    // print("<pre>".print_r($element['#parents'], true)."</pre>");
    // print("<pre>".print_r($element, true)."</pre>");
    // Add a btn-primary-outline class if submit button.
    if ((isset($element['#parents']) && ($element['#parents'][0] == 'submit') && (strpos($element['#ajax']['wrapper'], 'webform-client-form') === 0)) || ($element['#parents'][0] == 'save')) {
      $element['#attributes']['class'][] = 'btn-gradient';
    } else {
      $element['#attributes']['class'][] = 'btn-primary-outline';
    }

    if (!empty($element['#button_icon'])) {
      $value  = theme('radix_icon', array('icon' => $element['#button_icon']));
      $value .= ' ';
      $value .= '<span class="button-text">' . check_plain($element['#value']) . '</span>';

      return '<button' . drupal_attributes($element['#attributes']) . '>' . $value . '</button>';
    }

    return '<input' . drupal_attributes($element['#attributes']) . ' />';
  }
