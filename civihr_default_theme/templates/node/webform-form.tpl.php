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
  $fields = array_filter($form['submitted'], function($value, $key) {
    return substr($key, 0, 1) <> '#' && $value['#type'] != 'hidden';
  }, ARRAY_FILTER_USE_BOTH);
  $fields_keys = array_keys($fields);

  // Wrap each field in Bootstrap's markup, and wrap the entire field group in the modal section
  foreach ($fields as $key => $value) {
    $first_field = $key == $fields_keys[0];
    $last_field = $key == end($fields_keys);
    $label_hidden = $value['#title_display'] == 'none';

    $form['submitted'][$key]['#prefix'] = ''
      . ( $first_field ? '<div class="modal-civihr-custom__section">' : '' ) .
      '<div class="form-group form-group--smaller-gutter">
        <label
         for="'. $value['#id'] .'"
         class="col-sm-3 control-label ' . ( $label_hidden ? 'hidden-xs' : '' ) . '">'
          . ( !$label_hidden ? $value['#title'] : '' ) .
        '</label>
        <div class="col-sm-9">
    ';
    $form['submitted'][$key]['#suffix'] = '</div></div>' . ( $last_field ? '</div>' : '' );

    unset($form['submitted'][$key]['#title']);
  }

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