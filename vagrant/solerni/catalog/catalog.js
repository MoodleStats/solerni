/*
 * Manage catalog filters : checkboxes states and paging
 */

$(document).ready( function() {
    var fieldsets = $('.filters-form-fieldset');

    /*
     * Uncheck all checkboes except the first one
     * @param jQuery object list of input tags
     * @returns void
     */
    function uncheck_all_but_first(checkboxes) {
        checkboxes.not(':first').each(function() {
            $(this).prop('checked', false);
        });
    }

    /*
     * Propagate state of checkboxes inside a fieldset to match expected behavior.
     * 1/ Uncheck all checkboxes when the first one (all) is checked.
     * 2/ Recheck the first checkbox when trying to uncheck it directly
     * 3/ Uncheck the first one when any other is checked.
     * 4/ Uncheck all checkboxes and check the first one when all other checkboxes are checked.
     * Then submit the form.
     *
     * NB: does not respect the rule 4 on purpose when we have two checkboxes.
     * Just change the two last rules order to change that.
     */
    fieldsets.on('change', 'input', function(event) {
        var checkboxes = $(event.delegateTarget).find('.form-fieldset-checkbox');
        var checkedboxes = $(event.delegateTarget).find('.form-fieldset-checkbox:checked');
        var isall = $(this).get(0) === checkboxes.eq(0).get(0);
        var isallcheck = checkboxes.eq(0).is(':checked');
        if (isall && isallcheck) {
            uncheck_all_but_first(checkboxes);
        } else if (isall && !isallcheck) {
            checkboxes.eq(0).prop('checked', true);
            return;
        } else if (!isall && isallcheck) {
            checkboxes.eq(0).prop('checked', false);
        } else if (!isall && checkedboxes.length >= (checkboxes.length - 1) ) {
            checkboxes.eq(0).prop('checked', true);
            uncheck_all_but_first(checkboxes);
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
