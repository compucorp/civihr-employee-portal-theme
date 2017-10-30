/**
 * @file
 * Custom scripts for theme.
 */

(function ($) {
  Drupal.behaviors.isMobile = false;
  Drupal.behaviors.civihr_theme = {
    attach: function () {
      // on doc ready
      $(document).ready(function () {
        Drupal.behaviors.isMobile = $('body.mobile').length;

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
    addImagesInCustomizeOnboardingPage();
    addVerticalLineInCustomizeOnboardingPage();
    applyCustomSelectOnRadioClick();
    handleWebformCalendar();
    hideSSNLabelOnCheckboxClick();
    removeTextFromCarouselPager();
    Drupal.civihr_theme.createDragAndDrop('.onboarding_wizard_profile_pic_upload_image input[type="file"]');
    Drupal.civihr_theme.createDragAndDrop('#edit-civihr-onboarding-organization-logo-fid-ajax-wrapper input[type="file"]');
  };

  /**
   * Apply the Drag and Drop Behaviour to the given input field
   *
   * @param {string} inputFieldSelector
   */
  Drupal.civihr_theme.createDragAndDrop = function (inputFieldSelector) {
    var dropHelper;
    var inputField = $(inputFieldSelector);

    if (!Drupal.behaviors.isMobile) {
      dropHelper = '<span><i class="fa fa-cloud-upload" aria-hidden="true"></i><br>' +
      '<b>Drop file here</b><br>or click to browse</span>';
    } else {
      dropHelper = 'Select Image';
    }

    var dropLayer = inputFieldSelector+ '+.drop-layer';
    if (!$(dropLayer).length) {
      inputField.after('<div class="drop-layer">' + dropHelper + '</div>');

      inputField.on('change', function () {
        $(dropLayer).html('File Selected');
        $(dropLayer).removeClass('is-dragover');
      });

      if (!Drupal.behaviors.isMobile) {
        inputField.on('dragenter', function () {
          $(dropLayer).addClass('is-dragover');
        });
        inputField.on('dragleave', function () {
          $(dropLayer).removeClass('is-dragover');
        });
      }
    }
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
   * Add Images in Customize Onboarding Page
   */
  function addImagesInCustomizeOnboardingPage () {
    var onBoardingWizardImageDirectory = '../../' + Drupal.settings.civihr_default_theme.path + '/assets/images/onboarding_wizard/';

    if (!$('.onboarding-customize-logo').length) {
      $('#edit-civihr-onboarding-organization-logo-fid-ajax-wrapper').before('<img class="onboarding-customize-logo" src="'+ onBoardingWizardImageDirectory +'logo-img.jpg"/>');
    }

    if (!$('.onboarding-customize-features').length) {
      $('.form-item-civihr-onboarding-carousel-options').before('<img class="onboarding-customize-features" src="'+ onBoardingWizardImageDirectory +'/features-img.jpg"/>')
    }

    if (!$('.onboarding-customize-welcome').length) {
      $('.form-item-civihr-onboarding-intro-text').before('<img class="onboarding-customize-welcome" src="'+ onBoardingWizardImageDirectory +'/welcome-img.jpg"/>')
    }
  }

  /**
   * Add Vertical Line in Customize Onboarding Page
   */
  function addVerticalLineInCustomizeOnboardingPage () {
    if(!$('.form-item-civihr-onboarding-welcome-text+hr').length) {
      $('.form-item-civihr-onboarding-welcome-text').after('<hr/>');
    }
    if(!$('.form-item-civihr-onboarding-intro-text+hr').length) {
      $('.form-item-civihr-onboarding-intro-text').after('<hr/>');
    }
    if(!$('.form-item-civihr-onboarding-carousel-options+hr').length) {
      $('.form-item-civihr-onboarding-carousel-options').after('<hr/>');
    }
  }

  /**
   * Get values from Webform's SELECT input type calendar values and set it to
   * Native Datepicker
   */
  function getWebformCalendarValues() {
    var day = $('#' + this.id + '-' + 'day').val();
    day = (day < 10 ? '0' : '') + day;

    var month = $('#' + this.id + '-' + 'month').val();
    month = (month < 10 ? '0' : '') + month;

    var year = $('#' + this.id + '-' + 'year').val();
    var date = year + '-' + month + '-' + day;

    $(this).val(date).trigger('change');
  }

  /**
   * Handle Webform Calendar element
   */
  function handleWebformCalendar () {
    // Remove Required attribute from default select datepicker, which is not used
    $('.webform-container-inline.webform-datepicker div.form-item.form-type-select select').attr('required', false);
    if (Drupal.behaviors.isMobile) {
      $('.mobile .webform-calendar').remove();
      $('.mobile-webform-calendar').change(setWebformCalendarValues);
      $('.mobile-webform-calendar').each(getWebformCalendarValues);
    } else {
      $('body:not(.mobile) .mobile-webform-calendar').remove();
      $('.webform-calendar').each(getWebformCalendarValues);
      $('.webform-calendar').datepicker("option", "dateFormat", "dd-mm-yy");
      $('.webform-calendar').datepicker("option", "beforeShow", null);
      $('.webform-calendar').datepicker("option", "onSelect", setWebformCalendarValues);
    }
  }

  /**
   * Hide the SSN Label of Onboarding page when the checkbox is checked
   */
  function hideSSNLabelOnCheckboxClick () {
    var ssnCheckbox = $('.onboarding_wizard_payroll_ssin_checkbox input.form-checkbox');
    var ssnLabel = $('.onboarding_wizard_payroll_ssin_textfield');

    ssnCheckbox.click(function () {
      ssnLabel.toggle();
    });
  }

  /**
   * Remove carousel pager text
   */
  function removeTextFromCarouselPager () {
    $('.views-slideshow-pager-fields .views-content-title').html('');
  }

  /**
   * Set values to Webform's SELECT input type calendar values from
   * Native Datepicker
   */
  function setWebformCalendarValues (dateText) {
    var month, date, year, fullDate;

    if (Drupal.behaviors.isMobile) {
      fullDate = new Date(this.value);
      month = fullDate.getMonth() + 1;
      date = fullDate.getDate();
      year = fullDate.getFullYear();
    } else {
      fullDate = dateText.split('-');
      date = fullDate[0];
      month = fullDate[1];
      year = fullDate[2];
    }
    $('#' + this.id + '-' + 'month').val(month).trigger('change');
    $('#' + this.id + '-' + 'day').val(date).trigger('change');
    $('#' + this.id + '-' + 'year').val(year).trigger('change');
  }
})(jQuery);
