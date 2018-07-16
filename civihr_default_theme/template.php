<?php
/**
 * @file
 * Theme functions
 */

require_once dirname(__FILE__) . '/includes/structure.inc';
require_once dirname(__FILE__) . '/includes/comment.inc';
require_once dirname(__FILE__) . '/includes/form.inc';
//require_once dirname(__FILE__) . '/includes/menu.inc';
require_once dirname(__FILE__) . '/includes/node.inc';
require_once dirname(__FILE__) . '/includes/panel.inc';
require_once dirname(__FILE__) . '/includes/user.inc';
require_once dirname(__FILE__) . '/includes/view.inc';

/**
 * Implements template_preprocess_views_view_table().
 */
function civihr_default_theme_preprocess_views_view_table(&$variables) {
  $variables['classes_array'] = array_diff($variables['classes_array'], array('table-striped', 'table-bordered'));
}

/**
 * @param array $variables
 */
function civihr_default_theme_preprocess_webform_progressbar(&$variables) {
  global $user;
  $onboardingPages = ['onboarding-form'];

  if ($user && $user->uid) {
    $userEditPage = sprintf('user/%d/edit', $user->uid);
    $onboardingPages[] = $userEditPage;
  }

  // use different template for progress bar for onboarding form / user edit
  if (in_array(request_path(), $onboardingPages)) {
    $variables['theme_hook_suggestions'][] = 'webform_onboarding_progressbar';
  }
}

/**
 * @param array $variables
 */
function civihr_default_theme_preprocess_webform_calendar(&$variables) {
  $onboardingPages = ['onboarding-form'];

  // use different template for calendar for onboarding form / user edit
  if (in_array(request_path(), $onboardingPages)) {
    $variables['theme_hook_suggestions'][] = 'webform_onboarding_calendar';
  }
}

/**
 * Implements hook_theme().
 * This adds a new theme for the onboarding form progress bar. This theme is not
 * directly used, but is suggested conditionally in
 *
 * @see civihr_default_theme_preprocess_webform_progressbar.
 */
function civihr_default_theme_theme() {

  $defaultProgressBarVars = [
    'node' => NULL,
    'page_num' => NULL,
    'page_count' => NULL,
    'page_labels' => []
  ];

  return [
    'webform_onboarding_progressbar' => [
      'variables' => $defaultProgressBarVars,
      'template' => 'templates/contrib/webform-onboarding-progressbar',
    ],
    'webform_onboarding_calendar' => [
      'variables' => $defaultProgressBarVars,
      'template' => 'templates/node/webform-onboarding-calendar',
    ],
  ];
}

/**
 * Implements theme_table().
 * Copied from sites/all/themes/radix/includes/structure.inc
 */
function civihr_default_theme_table($variables) {
  // Add default classes to table elements.
  $variables['attributes']['class'] = (isset($variables['attributes']['class'])) ? $variables['attributes']['class'] : array();
  $variables['attributes']['class'] = (is_array($variables['attributes']['class'])) ? $variables['attributes']['class'] : array($variables['attributes']['class']);
    // REMOVED THE table-striped' and 'table-bordered' classes
  $variables['attributes']['class'] = array_merge($variables['attributes']['class'], array(
    'table'
  ));

  $header = $variables['header'];
  $rows = $variables['rows'];
  $attributes = $variables['attributes'];
  $caption = $variables['caption'];
  $colgroups = $variables['colgroups'];
  $sticky = $variables['sticky'];
  $empty = $variables['empty'];

  // Add sticky headers, if applicable.
  if (count($header) && $sticky) {
    drupal_add_js('misc/tableheader.js');
    // Add 'sticky-enabled' class to the table to identify it for JS.
    // This is needed to target tables constructed by this function.
    $attributes['class'][] = 'sticky-enabled';
  }

  $output = '<div class="table-responsive">';
  $output .= '<table' . drupal_attributes($attributes) . ">\n";

  if (isset($caption)) {
    $output .= '<caption>' . $caption . "</caption>\n";
  }

  // Format the table columns:
  if (count($colgroups)) {
    foreach ($colgroups as $number => $colgroup) {
      $attributes = array();

      // Check if we're dealing with a simple or complex column.
      if (isset($colgroup['data'])) {
        foreach ($colgroup as $key => $value) {
          if ($key == 'data') {
            $cols = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $cols = $colgroup;
      }

      // Build colgroup.
      if (is_array($cols) && count($cols)) {
        $output .= ' <colgroup' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cols as $col) {
          $output .= ' <col' . drupal_attributes($col) . ' />';
        }
        $output .= " </colgroup>\n";
      }
      else {
        $output .= ' <colgroup' . drupal_attributes($attributes) . " />\n";
      }
    }
  }

  // Add the 'empty' row message if available.
  if (!count($rows) && $empty) {
    $header_count = 0;
    foreach ($header as $header_cell) {
      if (is_array($header_cell)) {
        $header_count += isset($header_cell['colspan']) ? $header_cell['colspan'] : 1;
      }
      else {
        $header_count++;
      }
    }
    $rows[] = array(array(
      'data' => $empty,
      'colspan' => $header_count,
      'class' => array('empty', 'message'),
    ));
  }

  // Format the table header:
  if (count($header)) {
    $ts = tablesort_init($header);
    // HTML requires that the thead tag has tr tags in it followed by tbody
    // tags. Using ternary operator to check and see if we have any rows.
    $output .= (count($rows) ? ' <thead><tr>' : ' <tr>');
    foreach ($header as $cell) {
      $cell = tablesort_header($cell, $header, $ts);
      $output .= _theme_table_cell($cell, TRUE);
    }
    // Using ternary operator to close the tags
    // based on whether or not there are rows.
    $output .= (count($rows) ? " </tr></thead>\n" : "</tr>\n");
  }
  else {
    $ts = array();
  }

  // Format the table rows:
  if (count($rows)) {
    $output .= "<tbody>\n";
    $flip = array(
      'even' => 'odd',
      'odd' => 'even',
    );
    $class = 'even';
    foreach ($rows as $number => $row) {
      $attributes = array();

      // Check if we're dealing with a simple or complex row.
      if (isset($row['data'])) {
        foreach ($row as $key => $value) {
          if ($key == 'data') {
            $cells = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $cells = $row;
      }
      if (count($cells)) {
        // Add odd/even class.
        if (empty($row['no_striping'])) {
          $class = $flip[$class];
          $attributes['class'][] = $class;
        }

        // Build row.
        $output .= ' <tr' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cells as $cell) {
          $cell = tablesort_cell($cell, $header, $ts, $i++);
          $output .= _theme_table_cell($cell);
        }
        $output .= " </tr>\n";
      }
    }
    $output .= "</tbody>\n";
  }

  $output .= "</table>\n";
  $output .= "</div>";

  return $output;
}

/**
 * Implements theme_pager()
 */
function civihr_default_theme_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (1), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('Previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('Next')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => ($pager_total[0]), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    $items[] = array(
      'class' => array('pager-first'),
      'data' => 'Page:',
    );

    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 2) {
        $items[] = array(
          'class' => array('pager-firt-count'),
          'data' => $li_first,
        );
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
        $items[] = array(
          'class' => array('pager-last-count'),
          'data' => $li_last,
        );
      }
    }

    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }

    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
}

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

  // Welcome page optimization
  if (current_path() == 'welcome-page') {
    $requiredCSS = [
      'modules/system/system.base.css',
      'modules/system/system.theme.css',
      'sites/all/modules/civicrm/bower_components/font-awesome/css/font-awesome.css',
      'sites/all/modules/civihr-contrib-required/fancy_login/css/fancy_login.css',
      'sites/all/modules/civihr-contrib-required/radix_layouts/radix_layouts.css',
      'sites/all/themes/civihr_employee_portal_theme/civihr_default_theme/assets/css/civihr_default_theme.style.css',
      'sites/all/modules/civihr-signup/css/civihr-signup.css'
    ];
    foreach (array_keys($css) as $file) {
      $found = false;
      foreach ($requiredCSS as $allowedFile) {
        if (stripos($file, $allowedFile) !== false) {
          $found = true;
        }
      }
      if (!$found) {
        unset($css[$file]);
      }
    }
  }
}

/**
 * @param array $node
 */
function civihr_default_theme_preprocess_node(&$node) {
  // Set a different template for the onboarding form
  $onboardingTitle = 'Welcome to CiviHR';
  if ($node && $node['type'] === 'webform' && $node['title'] === $onboardingTitle) {
    $node['theme_hook_suggestions'][] = 'page__webform__onboarding';
  }
}

/**
 * Implements template_preprocess_page().
 */
function civihr_default_theme_preprocess_page(&$variables) {
  // Adds the theme path to Javascript variable.
  $path = drupal_get_path('theme', 'civihr_default_theme');
  drupal_add_js(array('civihr_default_theme' => array('path' => $path)), 'setting');
  drupal_add_library('system', 'ui.datepicker');

  // Add custom copyright to theme.
  if ($copyright = theme_get_setting('copyright')) {
    $variables['copyright'] = check_markup($copyright['value'], $copyright['format']);
  } else {
    // Set empty copyright message by default
    // This will override the default copyright message from radix
    $variables['copyright'] = '';
  }
  $container_class = 'container';
  if (_is_hrreports_current_path()) {
    $container_class = 'container-fluid';
  }
  $variables['container_class'] = $container_class;
  $variables['cog_menu_markup'] = $variables['logged_in'] ? _build_cog_menu_markup() : NULL;

  // Use a different template if the user should start the onboarding process
  if (_civihr_default_theme_should_start_onboarding()) {
    $variables['theme_hook_suggestions'][] = 'page__user__edit__onboarding';
  }

  $plainPages = ['onboarding-form', 'features-in-civihr'];
  if (in_array(request_path(), $plainPages)) {
    $variables['page']['header_style'] = 'basic';
  }

  if (request_path() === 'onboarding-form') {
    $variables['theme_hook_suggestions'][] = 'page__onboarding__wizard';
  }
}

/**
 * Implements hook_js_alter().
 */
function civihr_default_theme_js_alter(&$javascript) {
  // Add radix-modal when required.
  if (module_exists('ctools')) {
    $ctools_modal = drupal_get_path('module', 'ctools') . '/js/modal.js';

    $old_radix_modal_js = drupal_get_path('theme', 'radix') . '/assets/js/radix.modal.js';

    // Unset the old radix-modal.js -> from the parent theme
    unset($javascript[$old_radix_modal_js]);

    // Add the new radix-modal.js (can be renamed to something else)
    $radix_modal = drupal_get_path('theme', 'civihr_default_theme') . '/assets/js/radix.modal.js';
    if (!empty($javascript[$ctools_modal]) && empty($javascript[$radix_modal])) {
      $javascript[$radix_modal] = array_merge(
        drupal_js_defaults(), array('group' => JS_THEME, 'data' => $radix_modal));
    }
  }

  // Welcome page optimization
  if (current_path() == 'welcome-page') {
    $requiredJS = [
      'settings',
      'misc/drupal.js',
      'sites/all/modules/civihr-contrib-required/jquery_update/replace/jquery/1.8/jquery.min.js',
      'misc/jquery.once.js',
      'sites/all/modules/civicrm/js/noconflict.js',
      'sites/all/modules/civihr-custom/civihr_employee_portal/js/scripts.js',
      'sites/all/modules/civihr-contrib-required/ctools/js/modal.js',
      'sites/all/modules/civicrm/bower_components/jquery/dist/jquery.js',
      'sites/all/modules/civicrm/bower_components/jquery/dist/jquery.min.js',
      'sites/all/modules/civicrm/bower_components/jquery-ui/jquery-ui.js',
      'sites/all/modules/civicrm/bower_components/jquery-ui/jquery-ui.min.js',
      'sites/all/modules/civicrm/bower_components/lodash-compat/lodash.js',
      'sites/all/modules/civicrm/bower_components/lodash-compat/lodash.min.js',
      'sites/all/modules/civicrm/js/crm.ajax.js',
      'sites/all/modules/civihr-contrib-required/jquery_update/replace/misc/jquery.form.min.js',
      'misc/ajax.js',
      'sites/all/modules/civihr-contrib-required/fancy_login/js/fancy_login.js',
      'sites/all/themes/civihr_employee_portal_theme/civihr_default_theme/assets/js/radix.modal.js',
      'sites/all/modules/civicrm/packages/jquery/plugins/jquery.blockUI.min.js',
      'sites/all/modules/civihr-signup/js/civihr-signup.js',
      'https://use.typekit.net/mhr5yod.js',
    ];

    if (module_exists('yoti')) {
      require_once drupal_get_path('module', 'yoti') . '/YotiHelper.php';
      $requiredJS[] = YotiHelper::YOTI_SDK_JAVASCRIPT_LIBRARY;
    }

    foreach (array_keys($javascript) as $file) {
      $found = false;
      foreach ($requiredJS as $allowedFile) {
        if (stripos($file, $allowedFile) !== false) {
          $found = true;
        }
      }
      if (!$found) {
        unset($javascript[$file]);
      }
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
 * Implements hook_html_head_alter() - alters html head tags.
 *
 * Sets viewport "maximum-scale" to 1 to prevent auto zooming on input focus.
 * @see https://stackoverflow.com/questions/11064237/prevent-iphone-from-zooming-form
 *
 * @param object $head_elements
 */
function civihr_default_theme_html_head_alter(&$head_elements) {
  _set_maximum_scale_to_viewport_meta_tag($head_elements);
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
  $fields = $fields_structure;
  foreach($fields as $key => $value)  {
    if (!(substr($key, 0, 1) <> '#' && !in_array(CRM_Utils_Array::value('#type', $value), ['hidden'])))  {
      unset($fields[$key]);
    }
  }
  return $fields;
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
    if (CRM_Utils_Array::value('#type', $value) == 'fieldset') {
      $fields_structure[$key] = array_replace_recursive($fields_structure[$key], civihr_default_theme_form_apply_bootstrap($value, false));
      $fields_structure[$key]['#attributes']['class'][] = 'civihr_form__fieldset civihr_form__fieldset--transparent';
      continue;
    }

    $wrapperAttr = CRM_Utils_Array::value('#wrapper_attributes', $value, []);
    $wrappperClasses = CRM_Utils_Array::value('class', $wrapperAttr, []);

    // Without this the prefix will not be hidden by conditionals
    $wrappperClasses[] = 'webform-component--' . str_replace('_', '-', $key);

    $wrappperClasses = implode(' ', $wrappperClasses);
    unset($fields_structure[$key]['#wrapper_attributes']); // once is enough

    $fields_structure[$key]['#title'] = null;
    $fields_structure[$key]['#prefix'] .= '
      <div class="form-group form-group--smaller-gutter ' . $wrappperClasses . '">
        <label
         for="'. $value['#id'] .'"
         class="col-sm-3 control-label ' . ( $label_hidden ? 'hidden-xs' : '' )
          . ( $fields_structure[$key]['#required'] ? 'required-mark' : '' ) . '">'
          . ( !$label_hidden ? CRM_Utils_Array::value('#title', $value) : '' ) .
        '</label>
        <div class="col-sm-9">
    ';
    $fields_structure[$key]['#suffix'] .= '</div></div>';

    $fields_structure[$key]['#prefix'] = $original_prefix . $fields_structure[$key]['#prefix'];
    $fields_structure[$key]['#suffix'] = $fields_structure[$key]['#suffix'] . $original_suffix;
  }

  return $fields_structure;
}

/**
 * Returns HTML for a menu link and submenu.
 * Copied from Radix theme
 * Added functionality to Hide Menu items based on condition
 *
 * @param $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @ingroup themeable
 */
function civihr_default_theme_menu_link__dropdown($variables) {
  $element = $variables['element'];

  _add_active_class_if_menu_link_is_current($element);
  _add_unique_class_to_menu_link($element);
  _hide_admin_menu_link_to_basic_users($element);

  return '<li' . drupal_attributes($element['#attributes']) . '>' . _get_menu_link_markup($element) . "</li>\n";
}

/**
 * If the menu link is for the current page, or is in its path trail,
 * then it adds the active class to it
 *
 * @param array $link
 */
function _add_active_class_if_menu_link_is_current(&$link) {
  if (_is_menu_link_current($link) || _is_menu_link_in_trail($link)) {
    $link['#attributes']['class'][] = 'active';
  }
}

/**
 * Builds and returns the markup of the link's submenu
 *
 * @param array $link
 *
 * @return string
 */
function _add_sub_menu_to_link(&$link) {
  unset($link['#below']['#theme_wrappers']);

  $link['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
  $link['#localized_options']['attributes']['data-toggle'] = 'dropdown';

  // Check if link is nested.
  if ((!empty($link['#original_link']['depth'])) && ($link['#original_link']['depth'] > 1)) {
    $link['#attributes']['class'][] = 'dropdown-submenu';
  } else {
    $link['#attributes']['class'][] = 'dropdown';
    $link['#localized_options']['html'] = TRUE;
    $link['#title'] .= '<span class="caret"></span>';
  }

  $link['#localized_options']['attributes']['data-target'] = '#';

  return '<ul class="dropdown-menu">' . drupal_render($link['#below']) . '</ul>';
}

/**
 * Adds a unique class to a link using its title
 *
 * @param array $link
 */
function _add_unique_class_to_menu_link(&$link) {
  $title = strip_tags($link['#title']);
  $link['#attributes']['class'][] = 'menu-link-' . drupal_html_class($title);
}

/**
 * Builds the markup of the cog menu
 *
 * @return string
 */
function _build_cog_menu_markup() {
  $menuItems = _get_cog_menu_items();
  $markup = "";

  foreach($menuItems as $menuItem) {
    foreach ($menuItem['permissions'] as $permission) {
      if (user_access($permission)) {
        $markup .= _get_cog_menu_item_markup($menuItem);
        break;
      }
    }
  }

  return $markup;
}

/**
 * Uses function from employee portal to check if user should do onboarding.
 *
 * @return bool
 *   TRUE if they have no submissions and can are editing their own account.
 */
function _civihr_default_theme_should_start_onboarding() {
  global $user;
  $shouldDoOnboarding = FALSE;
  $userEditPath = sprintf('user/%d/edit', $user->uid);
  $isEditSelfPage = (current_path() === $userEditPath);
  $onboardingChecker = '_civihr_employee_portal_should_do_onboarding';
  if (function_exists($onboardingChecker)) {
    $shouldDoOnboarding = $isEditSelfPage && $onboardingChecker($user);
  }

  return $shouldDoOnboarding;
}

/**
 * Builds and returns the markup of the given menu item
 *
 * @param array $menuItem
 *
 * @return string
 */
function _get_cog_menu_item_markup($menuItem) {
  $class = '';

  if (isset($menuItem['separator']) && $menuItem['separator'] == TRUE) {
    $class = 'chr_header__sub-menu__separator';
  }

  return "<li class=\"{$class}\">{$menuItem['link']}</li>";
}

/**
 * Gets the structure of the cog menu
 *
 * @return array
 */
function _get_cog_menu_items() {
  $resourceTypeVocabularyID = taxonomy_vocabulary_machine_name_load('hr_resource_type')->vid;

  $options = ['html' => TRUE];

  return [
    [
      'permissions' => ["create hr_documents content"],
      'link' => l(t('Manage HR Resources'), 'manage-hr-resources', $options),
    ],
    [
      'permissions' => ["edit terms in {$resourceTypeVocabularyID}"],
      'link' => l(t('HR Resource Types'), 'hr-resource-types-list', $options),
      'separator' => TRUE,
    ],
    [
      'permissions' => ['administer staff accounts'],
      'link' => l(t('Manage Users'), 'users-list', $options),
    ],
    [
      'permissions' => ['customize welcome wizard'],
      'link' => l(t('Customize Welcome Wizard'), 'customize-onboarding-wizard', $options),
    ],
  ];
}

/**
 * Build and returns the markup of the given link (and submenu, if present)
 *
 * @param array $link
 *
 * @return string
 */
function _get_menu_link_markup(&$link) {
  if ($link['#title'] === 'Manager Leave') {
    $link['#localized_options']['html'] = true;
    $link['#title'] .= civihr_employee_portal_get_markup_for_extension(
      'manager-notification-badge',
      'uk.co.compucorp.civicrm.hrleaveandabsences',
      'civihr_leave_absences');
  } else if ($link['#title'] === 'Tasks') {
    $link['#localized_options']['html'] = true;
    $link['#title'] .= civihr_employee_portal_get_markup_for_extension(
      'tasks-notification-badge',
      'uk.co.compucorp.civicrm.tasksassignments',
      'civihr_employee_portal');
  }

  $linkMarkup = l($link['#title'], $link['#href'], $link['#localized_options']);
  $subMenuMarkup = !empty($link['#below']) ? _add_sub_menu_to_link($link) : '';

  return $linkMarkup . $subMenuMarkup;
}

/**
 * Hide the menu link to the admin if the current user does not
 * have administer access
 *
 * @param array $link
 */
function _hide_admin_menu_link_to_basic_users(&$link) {
  $adminAccess = user_access("administer CiviCRM");
  $localOptions = $link['#localized_options'];
  $isAdminLink = isset($localOptions['identifier']) && $localOptions['identifier'] === 'main-menu_hr-admin:civicrm';

  if ($isAdminLink && !$adminAccess) {
    $link['#attributes']['class'][] = 'hidden';
  }
}

/**
 * Check if we are displaying custom Report page.
 *
 * @return boolean
 */
function _is_hrreports_current_path() {
  return substr(current_path(), 0, 8) === 'reports/';
}

/**
 * Checks if the given menu link is the link of the current page
 *
 * @param array $link
 *
 * @return boolean
 */
function _is_menu_link_current($link) {
  $localOptions = $link['#localized_options'];
  $language = !empty($localOptions['language']) ? $localOptions['language'] : NULL;

  $isLinkOfCurrentPath = $link['#href'] == current_path();
  $isLinkOfFrontPage = $link['#href'] == '<front>' && drupal_is_front_page();
  $isLanguageUndefinedOrCurrent = !$language || $language->language == $language_url->language;

  return ($isLinkOfCurrentPath || $isLinkOfFrontPage) && $isLanguageUndefinedOrCurrent;
}

/**
 * Checks if the given menu link is in the trail of the current page
 * (as in, it's part of the hierarchy of the current page)
 *
 * @param aray $link
 *
 * @return boolean
 */
function _is_menu_link_in_trail($link) {
  return in_array('active-trail', $link['#attributes']['class']);
}

/**
 * Sets the maximum viewport scale to 1.
 * @NOTE this still allows users to pinch/zoom with 2 fingers.
 * @NOTE this function expects that the Meta Viewport tag is already set.
 *
 * @param object $head_elements
 */
function _set_maximum_scale_to_viewport_meta_tag(&$head_elements) {
  // Get the meta tag by reference
  foreach ($head_elements as $tagKey => $tag) {
    if (isset($tag['#attributes']['name']) && $tag['#attributes']['name'] === 'viewport') {
      $viewportTagValue = &$head_elements[$tagKey]['#attributes']['content'];
    }
  }

  // Filter out "maximum-scale" property if exists
  $rules = array_filter(preg_split('/\s*,\s*/', $viewportTagValue), function ($rule) {
    return !preg_match('/^maximum-scale\s*=/i', $rule);
  });

  // Push new "maximum-scale" property
  array_push($rules, 'maximum-scale=1');

  // Set updated rules to the tag
  $viewportTagValue = implode(', ', $rules);
}

/**
 * Implements theme_menu_local_tasks().
 */
function civihr_default_theme_menu_local_tasks(&$variable) {
  // Remove primary and secondary tabs from user_profile_form page
  if (arg(0) === 'user' && is_numeric(arg(1)) && arg(2) === 'edit') {
    $variables['primary']['#access'] = false;
    $variables['secondary']['#access'] = false;
  }

  return radix_menu_local_tasks($variables);
}
