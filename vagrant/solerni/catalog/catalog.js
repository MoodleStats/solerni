/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready( function() {

    $('input.solerni_checkbox[type="checkbox"]').change(function () {
        var name = $(this).val();
        var check = $(this).is( ':checked' );
        var ul = $(this).closest('ul');
        var input = $('div.' + $(ul).attr('class') + ' > div.filter > input');
        if (check) {
            $(input).prop('checked', false);
        }
        var allcheck = true;
        $(ul).find('input').each(function () {
            if ($(this).is( ':checked' ) == false) {
                allcheck = false;
            }
        });

        if (allcheck == true) {
            $(ul).find('input').each(function () {
                $(this).prop('checked', false);
            });
            $(input).prop('checked', true);
        }
        $('#coursecatalog').submit();
    });

    $('input.solerni_checkboxall[type="checkbox"]').change(function () {
        var name = $(this).val();
        var check = $(this).is( ':checked' );

        if (check == false) {
            $(this).prop('checked', true);
        } else {
            $('#ul' + this.id + ' > li > input').each(function () {
               if (check) {
                   $(this).prop('checked', false);
               } else {
                   $(this).prop('checked', true);
               }
            });
            $('#coursecatalog').submit();
        }
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
})
