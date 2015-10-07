<?php

/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 *
 * If a preview is enabled, these keys will be available on the preview page:
 * - $form['preview_message']: The preview message renderable.
 * - $form['preview']: A renderable representing the entire submission preview.
 */
?>
<?php

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
  function apply_bootstrap($fields_structure, $section_wrap = true) {
    $fields = bootstrapable_fields($fields_structure);
    $fields_keys = array_keys($fields);

    foreach ($fields as $key => $value) {
      $open_section = $section_wrap && $key == $fields_keys[0];
      $close_section = $section_wrap && $key == end($fields_keys);
      $label_hidden = $value['#title_display'] == 'none';

      $fields_structure[$key]['#prefix'] = $open_section ? '<div class="modal-civihr-custom__section">' : '';
      $fields_structure[$key]['#suffix'] = $close_section ? '</div>' : '';

      // Recursively apply bootstrap to fieldset fields
      if ($value['#type'] == 'fieldset') {
        $fields_structure[$key] = array_replace_recursive($fields_structure[$key], apply_bootstrap($value, false));
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
    }

    return $fields_structure;
  }

  $form['submitted'] = apply_bootstrap($form['submitted']);

  // Print out the progress bar at the top of the page
  print drupal_render($form['progressbar']);

  // Print out the preview message if on the preview page.
  if (isset($form['preview_message'])) {
    print '<div class="messages warning">';
    print drupal_render($form['preview_message']);
    print '</div>';
  }

  // Print out the main part of the form.
  // Feel free to break this up and move the pieces within the array.
  print drupal_render($form['submitted']);

  // Always print out the entire $form. This renders the remaining pieces of the
  // form that haven't yet been rendered above (buttons, hidden elements, etc).
  print('<div class="modal-civihr-custom__footer">');
  print drupal_render_children($form);
  print('</div>');
