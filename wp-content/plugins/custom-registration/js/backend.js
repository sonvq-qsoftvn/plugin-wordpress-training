/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function create_custom_registration_page() {
    jQuery.ajax({
        dataType: "json",
        url: ajaxurl,
        data: {'action': 'create_custom_registration_page_action'},
        success: function (data) {
            
        }
    });
}