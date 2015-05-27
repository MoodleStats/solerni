/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready( function() {


    $('input.solerni_checkbox[type="checkbox"]').change(function () {
            var name = $(this).val();
            var check = $(this).is( ':checked' );
            console.log("Change SINGLE: " + name + " to " + check);
            /*.closest('input.solerni_checkboxall')*/
            var ul = $(this).closest('ul');
            var input = $('div.' +$(ul).attr('class')+ ' > div.filter > input'); 
            console.log(ul);
            console.log('div.' +$(ul).attr('class')+ ' > input');
            console.log(input);
            if (check) {
                /* $(input).removeAttr('checked');*/
                $(input).prop('checked', false);
                console.log("uncheck all");
            }
            var allcheck = true;
            $(ul).find('input').each(function () {
                console.log (this.value);
                if ($(this).is( ':checked' ) == false) allcheck = false;
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
            console.log (this.id);
            if (check == false) {
                $(this).prop('checked', true);
            } else {
                console.log('#ul'+this.id + ' > li > input');
                $('#ul'+this.id + ' > li > input').each(function () {
                   if (check) {
                       /* $(this).removeAttr('checked');*/
                       $(this).prop('checked', false);
                   }
                   else 
                   {
                       /* $(this).attr('checked','checked'); */
                       $(this).prop('checked', true);
                   }
                   //$(this).attr('checked','checked');
                    console.log (this.value);
                });
                console.log("Change ALL: " + name + " to " + check);
                $('#coursecatalog').submit();
            }
        });
     
})
