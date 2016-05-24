<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="civihrReports">
  <div
    id="<?php print $block_html_id; ?>"
    ng-controller="SettingsController as settings"
    class="panel panel-pane pane-block chr_panel--no-padding panel--sliding-body chr_panel--without-background"
    ng-class="{ 'panel--sliding-body': settings.isCollapsed }">
      <div class="pane-content">
          <div class="chr_search-result__header chr_panel__header chr_search-result__header--border-darker" ng-click="settings.isCollapsed = !settings.isCollapsed">
              <div class="chr_search-result__total">
                  <i
                    class="chr_search-result__icon glyphicon glyphicon-chevron-down"
                    ng-class="{ 'glyphicon-chevron-down': settings.isCollapsed, 'glyphicon-chevron-up': !settings.isCollapsed }">
                  </i>
                  <?php print $block->subject ?>
              </div>
          </div>

          <div
            class="panel-body-wrap panel-body-wrap--collapse"
            ng-class="{ 'panel-body-wrap--collapse': settings.isCollapsed }">
              <div class="panel-body">
                <?php print $content ?>
              </div>
          </div>
      </div>
  </div>
</div>
