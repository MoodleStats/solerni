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
      
        });
     
    $('input.solerni_checkboxall[type="checkbox"]').change(function () {
            var name = $(this).val();
            var check = $(this).is( ':checked' );
            console.log (this.id);

            $('#ul'+this.id + ' > input').each(function () {
               if (check) $(this).attr('checked','');
               else $(this).attr('checked','checked');
               //$(this).attr('checked','checked');
                console.log (this.value);
            });
            console.log("Change ALL: " + name + " to " + check);
        });
     
})
