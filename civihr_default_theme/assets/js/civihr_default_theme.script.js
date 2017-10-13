/**
 * @file
 * Custom scripts for theme.
 */

(function ($) {
  Drupal.behaviors.civihr_theme = {
    attach: function () {
      // on doc ready
      $(document).ready(function () {
        Drupal.civihr_theme.addClassToRadioButtons();
        Drupal.civihr_theme.applyMatchHeight();
        Drupal.civihr_theme.applyCustomSelect();
        Drupal.civihr_theme.initMobileNav();
        Drupal.civihr_theme.onBoardingWizard();
      });

      // on ajax complete (ie: when opening modals)
      $(document).ajaxComplete(function () {
        Drupal.civihr_theme.applyMatchHeight();
        Drupal.civihr_theme.applyCustomSelect();
      });
    }
  };

  // Create theme related functions
  Drupal.civihr_theme = Drupal.civihr_theme || {};

  /**
   * Do the stuff related to On boarding wizard
   */
  Drupal.civihr_theme.onBoardingWizard = function () {
    applyCustomSelectOnRadioClick();
    hideSSNLabelOnCheckboxClick();
  };

  /**
   * Add a class to the Radio buttons when they are checked
   */
  Drupal.civihr_theme.addClassToRadioButtons = function () {
    var $radioButtons = $('input[type="radio"]');

    $radioButtons.each(function () {
      $(this).parent().parent().toggleClass('checked', this.checked);
    });

    $radioButtons.click(function () {
      $radioButtons.each(function () {
        $(this).parent().parent().toggleClass('checked', this.checked);
      });
    });
  };

  Drupal.civihr_theme.initMobileNav = function () {
    var $header = $('.chr_header');
    var $mobileLogo = $('.chr_header__brand.chr_brand.chr_header__home-menu');
    var $nav = $header.find('.chr_header__nav');

    var toggleMenu = function () {
      $nav.toggleClass('is-open');
    };

    $header.on('click', '.chr_header__nav__toggle', toggleMenu);
    $mobileLogo.on('click', toggleMenu);
  };

  Drupal.civihr_theme.applyMatchHeight = function () {
    $('.view-hr-vacancies li').matchHeight();
    $('.view-hr-documents li').matchHeight();
  };

  Drupal.civihr_theme.applyCustomSelect = function () {
    Drupal.civihr_theme.initCustomSelect();
    Drupal.civihr_theme.onFieldsetLegendClick();
  };

  Drupal.civihr_theme.initCustomSelect = function () {
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
  };

  Drupal.civihr_theme.onFieldsetLegendClick = function () {
    $('.fieldset-legend .fieldset-title').click(Drupal.civihr_theme.initCustomSelect);
  };

  /**
   * Apply custom select when clicked on radio buttons, which opens new section
   */
  function applyCustomSelectOnRadioClick () {
    var radioBtn = $('.onboarding-wizard-page .form-radios');
    radioBtn.click(function () {
      setTimeout(Drupal.civihr_theme.applyCustomSelect, 0);
    });
  }

  /**
   * Hide the SSN Label of Onboarding page when the checkbox is checked
   */
  function hideSSNLabelOnCheckboxClick () {
    var ssnCheckbox = $('#edit-submitted-civicrm-1-contact-1-cg16-custom-73-1');
    var ssnLabel = $('label[for="edit-submitted-civicrm-1-contact-1-cg16-custom-72"]');

    ssnCheckbox.click(function () {
      ssnLabel.toggle();
    });
  }
})(jQuery);
