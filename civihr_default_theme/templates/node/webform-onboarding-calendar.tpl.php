<?php
/**
 * @var array $component
 *   A Webform component array
 *
 * @var array $calendar_classes
 *   Array of classes for the Webform Calendar component
 */
$idKey = str_replace('_', '-', $component['form_key']);
?>
<input
  type="text"
  required="<?php $component['required']; ?>"
  id="edit-submitted-<?php print $idKey ?>"
  class="form-text <?php print implode(' ', $calendar_classes); ?>"
  alt="<?php print t('Open popup calendar'); ?>"
  title="<?php print t('Open popup calendar'); ?>" />
<input
  type="date"
  required="<?php $component['required']; ?>"
  id="edit-submitted-<?php print $idKey ?>"
  class="form-text mobile-webform-calendar
    <?php print str_replace('webform-calendar', '', implode(' ', $calendar_classes)); ?>"
  alt="<?php print t('Open popup calendar'); ?>"
  title="<?php print t('Open popup calendar'); ?>" />
<span class="input-group-addon pointer"><i class="fa fa-calendar"></i></span>


