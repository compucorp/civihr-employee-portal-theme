<?php
$idKey = str_replace('_', '-', $component['form_key']);
?>
<input
  type="text"
  data-date-format="dd/mm/yyyy"
  id="edit-submitted-<?php print $idKey ?>"
  class="form-text <?php print implode(' ', $calendar_classes); ?>"
  alt="<?php print t('Open popup calendar'); ?>"
  title="<?php print t('Open popup calendar'); ?>" />
<span class="input-group-addon pointer"><i class="fa fa-calendar"></i></span>
