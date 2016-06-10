/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    var current_status = Number(jQuery('#ebook_status').val());
    jQuery('.reject_ebook').click(function () {
        jQuery("#hdn_ebook_status").val(current_status - 1);
        jQuery("#ebook_status").val(current_status - 1);
        jQuery('.change_status_ebook').html('Đã thay đổi trạng thái. ấn nút cập nhật để lưu lại');
    });
    jQuery('.approve_ebook').click(function () {
        jQuery("#hdn_ebook_status").val(current_status + 1);
        jQuery("#ebook_status").val(current_status + 1);
        jQuery('.change_status_ebook').html('Đã thay đổi trạng thái. ấn nút cập nhật để lưu lại');
    });

});
function qsoft_delete_field(e, field_name, elm) {
    e.preventDefault();
    var is_confirm = confirm('Are you sure delete field?');
    if (is_confirm == true) {
        jQuery.ajax({
            dataType: "json",
            url: ajaxurl,
            data: {'action': 'qsoft_delete_field', 'field_name': field_name, },
            success: function (data) {
                if (data.status == true) {
                    jQuery(elm).parent().parent().fadeOut();
                }
            }
        });
    }
}
function change_status(elm) {
    var status = 0;
    if (jQuery(elm).is(':checked')) {
        status = 1;
    }
    jQuery.ajax({
        dataType: "json",
        url: ajaxurl,
        data: {'action': 'change_status_user', 'user_id': jQuery(elm).attr('id'), 'status': status},
        success: function (data) {
            alert('Thay doi trang thai thanh cong');
        }
    });
}
function q_add_option() {
    jQuery('.list_field_option').append('<p><input type="text" name="field_option_data[]"> <a href="" class="button" onclick="qsoft_remove_option(event,this)">Remove</a></p>');
}
function qsoft_remove_option(e, elm) {
    e.preventDefault();
    jQuery(elm).parent().html('');
}
function qsoft_field_type_onchange(elm) {
    var type = jQuery(elm).val();
    if (type == 'checkbox' || type == 'select') {
        jQuery('#qsoft_dropdown_option').show();
//        jQuery('.qsoft_dropdown_option_label').show();
    } else {
        jQuery('#qsoft_dropdown_option').hide();
//        jQuery('.qsoft_dropdown_option_label').hide();
    }
}
function qsoft_edit_field(e, field_name, elm) {
    
    e.preventDefault();
    jQuery.ajax({
        dataType: "json",
        url: ajaxurl,
        data: {'action': 'qsoft_edit_field', 'field_name': field_name},
        success: function (data) {
            jQuery('#qsoft_field_name').val(data.data.field_name);
            jQuery('#qsoft_field_label').val(data.data.field_label);
            jQuery('#qsoft_field_type_select').val(data.data.field_type);
            jQuery('#qsoft_field_order').val(data.data.field_order);
            if (data.data.field_required == 1) {
                jQuery('#qsoft_field_required').attr('checked', true);
            } else {
                jQuery('#qsoft_field_required').removeAttr('checked');
            }
            if (data.data.field_type == 'select' || data.data.field_type == 'radio') {
                jQuery('#qsoft_dropdown_option').show();
            } else {
                jQuery('#qsoft_dropdown_option').hide();
            }
            var options = data.data.field_option;
            jQuery('.list_field_option').html('');
            for (var key in options) {
                if (options.hasOwnProperty(key)) {
                    jQuery('.list_field_option').append('<p><input type="text" name="field_option_data[]" value="' + options[key] + '"><a href="" class="button" onclick="qsoft_remove_option(event,this)">Remove</a></p>');
                }
            }
            jQuery('html,body').animate({
                scrollTop: jQuery('.form_manage_field').offset().top - 110},
            'slow');

        }
    });
}
function qsoft_add_field(e, elm) {

    jQuery('.form_manage_field input').removeClass('input_err');
    jQuery('.form_manage_field .show_message').html('');
    var status = true;
    if (jQuery('#qsoft_field_name').val() == '') {
        jQuery('#qsoft_field_name').addClass('input_err');
        jQuery('.form_manage_field .show_message').append('<li class="show_err">Field name is require!</li>');
        status = false;
    }
    if (jQuery('#qsoft_field_label').val() == '') {
        jQuery('#qsoft_field_label').addClass('input_err');
        jQuery('.form_manage_field .show_message').append('<li class="show_err">Field label is require!</li>');
        status = false;
    }
    if (jQuery('#qsoft_field_type_select').val() == '') {
        jQuery('#qsoft_field_type_select').addClass('input_err');
        jQuery('.form_manage_field .show_message').append('<li class="show_err">Field type is require!</li>');
        status = false;
    }
    if (status === false) {
        e.preventDefault();
    }
}
function qsoft_set_generate_page_status(elm) {
    jQuery.ajax({
        dataType: "json",
        url: ajaxurl,
        data: {'action': 'qsoft_set_generate_page_status'},
        success: function (data) {
            jQuery(elm).parent().fadeOut();
        }
    });
}