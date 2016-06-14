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
  } else {
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

/**
 * Renders icon for file
 * @param $variables
 * @return string
 */
function civihr_default_theme_file_icon($variables) {
  $file = $variables['file'];
  $mime = check_plain($file->filemime);

  return '<i class="fa ' . get_icon_class($mime) . '"></i>';
}

/**
 * Gets font-awesome class depending on file's mime-type
 * @param $mime
 * @return string
 */
function get_icon_class($mime) {
  $type = explode('/', $mime);

  switch ($type[0]) {
    case 'image':
      return 'fa-file-image-o';

    case 'audio':
      return 'fa-file-audio-o';

    case 'video':
      return 'fa-file-video-o';

    case 'text':
      return 'fa-file-text-o';

    default:
      if ($type[1] == 'pdf') {
        return 'fa-file-pdf-o';
      } else {
        return 'fa-file-o';
      }
  }
}

/**
 * Extends radix_form_element_label().
 * This modification allows to set a #label_class attribute on the label element
 */
function civihr_default_theme_form_element_label($variables) {
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // Radios and checkboxes are rendered differently.
  $is_radio_or_checkbox = (isset($element['#type']) && ('checkbox' === $element['#type'] || 'radio' === $element['#type']));

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required']) && !$is_radio_or_checkbox) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = !empty($element['#title']) ? filter_xss_admin($element['#title']) : '';

  $attributes = array();

  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after' && !$is_radio_or_checkbox) {
    $attributes['class'] = 'option';
  } // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible';
  }

  // Applies custom classes to the label element
  if (isset($element['#label_class'])) {
    $attributes['class'] = ($attributes['class'] ? $attributes['class'] . ' ' : '') . $element['#label_class'];
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // Radio and checkboxes goes inside label.
  $output = '';
  if ($is_radio_or_checkbox && isset($element['#children']) && ($element['#title_display'] != 'invisible')) {
    $output .= $element['#children'];
  }

  // Append label.
  $output .= $t('!title !required', array('!title' => $title, '!required' => $required));

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $output . "</label>\n";
}

/**
 * Fields that Bootstrap markup can be applied on
 *
 * @param array $fields_structure
 *   The associative array representive the fields structure
 * @return array
 */
function bootstrapable_fields($fields_structure) {
  return array_filter($fields_structure, function($value, $key) {
    return substr($key, 0, 1) <> '#' && !in_array($value['#type'], ['hidden']);
  }, ARRAY_FILTER_USE_BOTH);
}

/**
 * Recursive function that applies Bootstrap markup to a fields structure
 * Can be called on entire forms or subsets of it, like fieldsets
 *
 * @param array $fields_structure
 *   The associative array representive the fields structure
 * @param boolean $section_wrap
  *  Sets if the fields group must be wrapped in the modal structure element
 * @return array
 */
function civihr_default_theme_form_apply_bootstrap($fields_structure, $section_wrap = true) {
  $fields = bootstrapable_fields($fields_structure);
  $fields_keys = array_keys($fields);

  foreach ($fields as $key => $value) {
    $open_section = $section_wrap && $key == $fields_keys[0];
    $close_section = $section_wrap && $key == end($fields_keys);
    $label_hidden = $value['#title_display'] == 'none';
    $original_prefix = !empty($fields_structure[$key]['#prefix']) ? $fields_structure[$key]['#prefix'] : '';
    $original_suffix = !empty($fields_structure[$key]['#suffix']) ? $fields_structure[$key]['#suffix'] : '';

    $fields_structure[$key]['#prefix'] = $open_section ? '<div class="modal-civihr-custom__section">' : '';
    $fields_structure[$key]['#suffix'] = $close_section ? '</div>' : '';

    // Recursively apply bootstrap to fieldset fields
    if ($value['#type'] == 'fieldset') {
      $fields_structure[$key] = array_replace_recursive($fields_structure[$key], civihr_default_theme_form_apply_bootstrap($value, false));
      $fields_structure[$key]['#attributes']['class'][] = 'civihr_form__fieldset--transparent';
      continue;
    }

    $fields_structure[$key]['#title'] = null;
    $fields_structure[$key]['#prefix'] .= '
      <div class="form-group form-group--smaller-gutter">
        <label
         for="'. $value['#id'] .'"
         class="col-sm-3 control-label ' . ( $label_hidden ? 'hidden-xs' : '' ) . '">'
          . ( !$label_hidden ? $value['#title'] : '' ) .
        '</label>
        <div class="col-sm-9">
    ';
    $fields_structure[$key]['#suffix'] .= '</div></div>';

    $fields_structure[$key]['#prefix'] = $original_prefix . $fields_structure[$key]['#prefix'];
    $fields_structure[$key]['#suffix'] = $fields_structure[$key]['#suffix'] . $original_suffix;
  }

  return $fields_structure;
}
