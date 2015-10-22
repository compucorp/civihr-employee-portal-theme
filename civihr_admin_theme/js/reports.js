(function ($) {
    $(document).ready(function () {
        $('#custom-report-details').on('click', '[data-reports-actions-action]', function (event) {
            var $reportsActions = $('[data-reports-actions]');
            var actionIndex = $(this).index()

            $reportsActions.find('.form-select > option').eq(actionIndex).prop('selected', true);
            $reportsActions.find('.form-submit').click();

            event.preventDefault();
        })
    });
})(jQuery);
