/**
 * @file
 * Custom scripts for theme.
 */

(function($) {
  Drupal.behaviors.civihr_theme = {
    attach: function (context, settings) {

      // on doc ready
      $(document).ready(function () {
        Drupal.civihr_theme.applyMatchHeight();
        Drupal.civihr_theme.applyCustomSelect();
        Drupal.civihr_theme.initMobileNav();
      });

      // on ajax complete (ie: when opening modals)
      $(document).ajaxComplete(function () {
        Drupal.civihr_theme.applyMatchHeight();
        Drupal.civihr_theme.applyCustomSelect();
      });

    }
  }

  // Create theme related functions
  Drupal.civihr_theme = Drupal.civihr_theme || {};

  Drupal.civihr_theme.initMobileNav = function() {
    $header = $('.chr_header');
    $nav = $header.find('.chr_header__nav');

    var toggleMenu = function () {
      $nav.toggleClass('is-open');
    };

    $header.on('click', '.chr_header__nav__toggle', toggleMenu);
  }

  Drupal.civihr_theme.applyMatchHeight = function() {
    $('.view-hr-vacancies li').matchHeight();
    $('.view-hr-documents li').matchHeight();
  }

  Drupal.civihr_theme.applyCustomSelect = function() {
    Drupal.civihr_theme.initCustomSelect();
    Drupal.civihr_theme.onFieldsetLegendClick();
  }

  Drupal.civihr_theme.initCustomSelect = function() {
    $('.form-item select').not('.hasCustomSelect').not('.skip-js-custom-select').filter(':visible').each(function () {
      var $this = $(this);
      if ($('body').hasClass('page-dashboard')) {
        if (!$this.parent().parent().hasClass('views-widget')) {
          $this.customSelect();
        }
      } else {
        $this.customSelect();
      }
    });
  }

  Drupal.civihr_theme.onFieldsetLegendClick = function() {
    $('.fieldset-legend .fieldset-title').click(Drupal.civihr_theme.initCustomSelect);
  }

})(jQuery);
