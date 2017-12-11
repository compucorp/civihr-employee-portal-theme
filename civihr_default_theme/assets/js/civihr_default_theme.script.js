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
   * Delete Emergency contacts and refresh the page
   *
   * @param {String} id
   */
  Drupal.civihr_theme.deleteEmergencyContactAndRefresh = function (id) {
    CRM.api3('contact', 'deleteemergencycontact', { 'id': id });
    location.reload();
  };

  /**
   * Do the stuff related to On boarding wizard
   */
  Drupal.civihr_theme.onBoardingWizard = function () {
    var isOnboardingPage =
      $('.onboarding-wizard-page').length ||
      $('.page-features-in-civihr').length ||
      $('.page-customize-onboarding-wizard').length;

    if (isOnboardingPage) {
      addImagesInCustomizeOnboardingPage();
      addVerticalLineInCustomizeOnboardingPage();
      applyCustomSelectOnRadioClick();
      handleWebformCalendar();
      hideSSNLabelOnCheckboxClick();
      removeTextFromCarouselPager();
      Drupal.civihr_theme.createDragAndDrop('.onboarding_wizard_profile_pic_upload_image input[type="file"]');
      Drupal.civihr_theme.createDragAndDrop('#edit-civihr-onboarding-organization-logo-fid-ajax-wrapper input[type="file"]');
    }
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

    var dropLayer = inputFieldSelector+ '+.drop-zone-overlay';
    if (!$(dropLayer).length) {
      inputField.after('<div class="drop-zone-overlay">' + dropHelper + '</div>');

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

  Drupal.civihr_theme.initMobileNav = function() {
    var $header = $('.chr_header');
    var $nav = $header.find('.chr_header__nav');

    var toggleMenu = function () {
      $nav.toggleClass('is-open');
    };

    $header.on('click', '.chr_header__nav__toggle', toggleMenu);
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
   * Get Date Values for the Desktop Version of the Datepicker
   *
   * @param {String} dateText - Changed Date
   * @return {Object}
   */
  function getDesktopCalendarValues (dateText) {
    var fullDate = dateText.split('/');

    return {
      date: parseInt(fullDate[0]),
      month: parseInt(fullDate[1]),
      year: parseInt(fullDate[2])
    };
  }

  /**
   * Get Date Values for the Mobile Version of the Datepicker
   *
   * @param {String} dateText - Changed Date
   * @return {Object}
   */
  function getMobileCalendarValues (dateText) {
    var fullDate = new Date(dateText);

    return {
      month: fullDate.getMonth() + 1,
      date: fullDate.getDate(),
      year: fullDate.getFullYear()
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
      var mobileCalendar = $('.mobile-webform-calendar');

      $('.mobile .webform-calendar').remove();
      mobileCalendar.change(setWebformCalendarValues);
      mobileCalendar.each(getWebformCalendarValues);
    } else {
      var desktopCalendar = $('.webform-calendar');

      $('body:not(.mobile) .mobile-webform-calendar').remove();

      if(desktopCalendar.length) {
        desktopCalendar.each(getWebformCalendarValues);
        desktopCalendar.datepicker("option", "dateFormat", "dd/mm/yy");
        desktopCalendar.datepicker("option", "beforeShow", null);
        desktopCalendar.datepicker("option", "changeMonth", true);
        desktopCalendar.datepicker("option", "changeYear", true);
        desktopCalendar.datepicker("option", "onSelect", setWebformCalendarValues);
      }
    }
  }

  /**
   * Hide the SSN Label of Onboarding page when the checkbox is checked
   */
  function hideSSNLabelOnCheckboxClick () {
    var ssnCheckbox = $('.onboarding_wizard_payroll_ssin_checkbox input.form-checkbox');
    var ssnLabel = $('.onboarding_wizard_payroll_ssin_textfield');

    // set initial state of the label, based on checkbox's value
    ssnCheckbox.is(':checked') ? ssnLabel.hide() : ssnLabel.show();
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
   *
   * @param {String} dateText - Changed Date
   */
  function setWebformCalendarValues (dateText) {
    var dateValues = Drupal.behaviors.isMobile
      ? getMobileCalendarValues(this.value)
      : getDesktopCalendarValues(dateText);

    $('#' + this.id + '-' + 'month').val(dateValues.month).trigger('change');
    $('#' + this.id + '-' + 'day').val(dateValues.date).trigger('change');
    $('#' + this.id + '-' + 'year').val(dateValues.year).trigger('change');
  }
})(jQuery);
