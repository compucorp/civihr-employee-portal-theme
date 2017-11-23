
<!--This page is just for importing by other pages -->

<?php
/**
 * @var array $page
 * @var array $variables
 */
?>

<div id="main-wrapper">
    <div id="main" class="main">
      <div class="container">
        <?php if ($breadcrumb): ?>
  <div id="breadcrumb" class="visible-desktop">
    <?php print $breadcrumb; ?>
  </div>
<?php endif; ?>
<?php if ($messages): ?>
  <div id="messages">
    <?php print $messages; ?>
  </div>
<?php endif; ?>
<div id="page-header">
  <?php if ($title): ?>
    <div class="page-header">
      <h1 class="title"><?php print $title; ?></h1>
    </div>
  <?php endif; ?>
  <?php if ($tabs): ?>
    <div class="tabs">
      <?php print render($tabs); ?>
    </div>
  <?php endif; ?>
  <?php if ($action_links): ?>
    <ul class="action-links">
      <?php print render($action_links); ?>
    </ul>
  <?php endif; ?>
</div>
</div>
<div id="content" class="<?php print $container_class; ?> collapse">
  <div class="main-container">
    <?php print render($page['content']); ?>
  </div>
</div>
</div> <!-- /#main -->
<?php
module_load_include('inc', 'webform_civicrm', 'includes/wf_crm_admin_help');
print wf_crm_admin_help::helpTemplate();
?>
</div> <!-- /#main-wrapper -->
