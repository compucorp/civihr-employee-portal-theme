<?php
/**
 * @file
 * Theme and preprocess functions for forms
 */


/**
 * Implements theme_button().
 * Copied from 'sites/all/themes/radix/includes/form.inc'
 * Removed applying `btn-default` class for all buttons
 *  If the button is used inside a modal 'btn-gradient' class is added
 *  Else 'btn-primary-outline' class is added
 */
function civihr_default_theme_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'btn';
  // Change - Line of code to apply `btn-default` class has been removed

  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  // Change - Start
  // Add a btn-primary-outline class if submit button.
  if (isset($element['#parents']) && $element['#parents'][0] == 'submit') {
    $element['#attributes']['class'][] = 'btn-gradient';
  } else {
    $element['#attributes']['class'][] = 'btn-primary-outline';
  }
  // Change - End

  if (!empty($element['#button_icon'])) {
    $value  = theme('radix_icon', array('icon' => $element['#button_icon']));
    $value .= ' ';
    $value .= '<span class="button-text">' . check_plain($element['#value']) . '</span>';

    return '<button' . drupal_attributes($element['#attributes']) . '>' . $value . '</button>';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}
