<?php

/** @var array $content */

$form = &$content['webform']['#form'];
$progressbar = &$form['progressbar'];
array_unshift($progressbar['#page_labels'], 'Password');
$progressbar['#page_count'] = count($progressbar['#page_labels']);
$progressbar['#page_num'] = $progressbar['#page_num'] + 1;

print drupal_render($content);
