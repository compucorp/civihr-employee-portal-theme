<?php
/**
 * @file
 * Display the progress bar for onboarding forms
 *
 * Available variables:
 * @var $node: The webform node.
 * @var $progressbar_page_number: TRUE if the actual page number should be
 *   displayed.
 * @var $progressbar_percent: TRUE if the percentage complete should be displayed.
 * @var $progressbar_bar: TRUE if the bar should be displayed.
 * @var $progressbar_pagebreak_labels: TRUE if the page break labels shoud be
 *   displayed.
 * @var $page_num: The current page number.
 * @var $page_count: The total number of pages in this form.
 * @var $page_labels: The labels for the pages. This typically includes a label for
 *   the starting page (index 0), each page in the form based on page break
 *   labels, and then the confirmation page (index number of pages + 1).
 * @var $percent: The percentage complete.
 */
?>

<div class="panel panel-default crm_wizard__title">
  <div class="panel-body">
    <ul class="nav nav-pills">
      <?php for ($n = 1; $n <= $page_count; $n++): ?>
        <li class="<?php if ($n < $page_num) { print 'completed'; }; ?><?php if ($n == $page_num) { print ' active'; }; ?>">
          <a>
            <span class="crm_wizard__title__number">
              <?php
              if ($n < $page_num) {
                print '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
              } else {
                print $n;
              }
              ?>
            </span>
            <?php print check_plain($page_labels[$n - 1]); ?>
          </a>
        </li>
      <?php endfor; ?>
    </ul>
  </div>
</div>
