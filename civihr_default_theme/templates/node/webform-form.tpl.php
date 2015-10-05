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
  $fields = [];
  $fields_keys = [];

  // Store only the visible fields in a separate array
  foreach ($form['submitted'] as $key => $value) {
    if (substr($key, 0, 1) <> '#' && $value['#type'] != 'hidden') {
      $fields[$key] = $value;
      array_push($fields_keys, $key);
    }
  }

  // Wrap each field in Bootstrap's markup, and wrap the entire field group in the modal section
  foreach ($fields as $key => $value) {
    $prefix = $key == $fields_keys[0] ? '<div class="modal-civihr-custom__section">' : '';
    $suffix = $key == $fields_keys[count($fields_keys) -1]? '</div>' : '';

    $form['submitted'][$key]['#prefix'] = $prefix . '
        <div class="form-group">
          <label for="edit-submitted-'.$key.'" class="col-sm-3 control-label">'.$value['#title'].'</label>
          <div class="col-sm-9">
      ';

    $form['submitted'][$key]['#suffix'] = '</div></div>' . $suffix;

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
