/*
 * Manage catalog filters : checkboxes states and paging
 */

$(document).ready( function() {
    var fieldsets = $('.filters-form-fieldset');
    fieldsets.on('change', 'input', function(event) {
        var checkboxes = $(event.delegateTarget).find('.form-fieldset-checkbox');
        var isall = $(this).get(0) === checkboxes.eq(0).get(0);
        var isallcheck = checkboxes.eq(0).is(':checked');
        if (isall && isallcheck) {
            checkboxes.not(':first').each(function() {
                $(this).attr('checked', false);
            });
        } else if (!isall && isallcheck) {
            checkboxes.eq(0).attr('checked', false);
        } else if (isall && !isallcheck ) {
            checkboxes.eq(0).attr('checked', true);
        }
        $('.js-catalog-filters').submit();
    });

    $('.paging a').click(function () {
        var url = $(this).attr('href');
        name = 'page';
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(url);
        var page = match && decodeURIComponent(match[1].replace(/\+/g, ' '));
        $('#pageid').val(page);
        $('#coursecatalog').submit();

        return false;
    });
});
