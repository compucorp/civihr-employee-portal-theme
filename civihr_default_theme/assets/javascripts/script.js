/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {
    // on doc ready
    $(document).ready(function() {

    $('.view-hr-vacancies li').matchHeight();

        applyCustomSelect();
    });

    // on ajax complete (ie: when opening modals)
    $(document).ajaxComplete(function() {

        applyCustomSelect();

    });

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
