<?php

/**
 * @file
 * Default theme implementation to display a block system main.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<!--block-system-main and content div added to support old css-->
<div id="block-system-main" class="block block-system">
  <div class="content">
    <?php print $content ?>
  </div>
</div>
