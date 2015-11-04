(function ($) {
    $(document).ready(function () {
        $('[data-graph-section="data"]')
            .on('click', '[data-reports-actions-action]', function (event) {
                var $form = $('[data-reports-actions-form]');

                $form.find('.form-select > option[value="' + $(this).data('action') + '"]').prop('selected', true);
                $form.find('.form-submit').click();

                event.preventDefault();
            })
            .on('click', 'input[class*="vbo-"]', function () {
                var $dropdown = $('[data-reports-actions-dropdown]');

                if ($('input[class*="vbo"]').filter(':checked').length > 0) {
                    $dropdown.show();
                } else {
                    $dropdown.hide();
                }
            });
    });
})(jQuery);
