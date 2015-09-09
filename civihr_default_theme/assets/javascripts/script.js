/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {
    // on doc ready
    $(document).ready(function() {
        applyMatchHeight();
        applyCustomSelect();
        initMobileNav();
    });

    // on ajax complete (ie: when opening modals)
    $(document).ajaxComplete(function() {
        applyMatchHeight();
        applyCustomSelect();
    });

    function initMobileNav() {
        $header = $('.chr_header');
        $nav = $header.find('.chr_header__nav');

        $header.on('click', '.chr_header__nav__toggle', function () {
            $nav.toggleClass('is-open');
        })
    }

    function applyMatchHeight() {
        $('.view-hr-vacancies li').matchHeight();
        $('.view-hr-documents li').matchHeight();
    }

    function applyCustomSelect() {
        initCustomSelect();
        onFieldsetLegendClick();
    }

    // when toggling expanding areas, apply customSelect to unaffected select elements
    function onFieldsetLegendClick() {
        $('.fieldset-legend .fieldset-title').click(initCustomSelect);
    }

    // initialize customSelect for unaffected visible select elements
    function initCustomSelect() {
        $('.form-item select').not('.hasCustomSelect').filter(':visible').each(function() {
            var $this = $(this);
            if ( $('body').hasClass('page-dashboard') ) {
                if ( !$this.parent().parent().hasClass('views-widget') ) {
                    $this.customSelect();
                }
            } else {
                $this.customSelect();
            }
        });
    }
})(jQuery);
