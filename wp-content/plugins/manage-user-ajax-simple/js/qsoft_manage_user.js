jQuery(function () {
//validate portal
    jQuery('#loginform').submit(function (e) {
        var err = '';
        if (jQuery('#user_login').val() === '') {
            err += '<li>User not empty</li>';
            jQuery('#user_login').prev().addClass('label_err');
            jQuery('#user_login').addClass('input_err');
        }
        if (jQuery('#user_pass').val() === '') {
            err += '<li>Password not empty</li>';
            jQuery('#user_pass').prev().addClass('label_err');
            jQuery('#user_pass').addClass('input_err');
        }
        if (err != '') {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
            e.preventDefault();
        }
        return;
    });
    jQuery('#qsoft_registration_form').submit(function (e) {
        e.preventDefault();
        var err = '';
        var i = 0;
        var status = true;
        jQuery(".autofill").remove();
        jQuery(".form_message").html();
        jQuery('form#qsoft_registration_form').find('input').each(function () {
            if (jQuery(this).prop('required') && jQuery(this).val() == '') {
                i++;
                jQuery(this).addClass('input_err');
                jQuery(this).parent().append('<p class="autofill error"> The field must be require!</p>');
                status = false;
//                if (i === 1) {
//                    jQuery('html,body').animate({
//                        scrollTop: jQuery(this).offset().top - 110},
//                    'slow');
//                }
            }
//check email
            else if (jQuery(this).attr('id') == 'email') {
                jQuery(this).removeClass('input_err');
                var email = jQuery('#register input[name="email'); //change form to id or containment selector
                var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
                if (email.val() == '' || !re.test(email.val()))
                {
                    jQuery(this).addClass('input_err');
                    jQuery(this).parent().append('<p class="autofill error"> Email not valid!</p>');
                    status = false;
                    jQuery('html,body').animate({
                        scrollTop: jQuery(this).offset().top - 110},
                            'slow');
                }
            }
//check repass
            else if (jQuery(this).attr('id') == 'confirmPassword') {
                jQuery(this).removeClass('input_err');
                if (jQuery('#register #password').val() != jQuery(this).val()) {
                    jQuery(this).addClass('input_err');
                    jQuery(this).parent().append('<p class="autofill error"> Re-type password wrong!</p>');
                    if (status == true) {
                        jQuery('html,body').animate({
                            scrollTop: jQuery(this).offset().top - 110},
                                'slow');
                    }
                    status = false;
                }
            } else {
                jQuery(this).removeClass('input_err');
            }
        });
        if (status == false) {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
        } else {
            jQuery('.qsoft_message').html('');
             var obj_user_meta={};
            jQuery('.qsoft_user_meta.q_text').each(function(){
                obj_user_meta[jQuery(this).attr('name')]=jQuery(this).val()
            })
            jQuery('.qsoft_user_meta.q_radio:checked').each(function(){
                obj_user_meta[jQuery(this).attr('name')]=jQuery(this).val()
            })
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                method: "POST",
                dataType: "json",
                data: {qsoft_user_login: jQuery('#qsoft_user_login').val(), qsoft_user_email: jQuery('#qsoft_user_email').val(),
                    qsoft_user_first: jQuery('#qsoft_user_first').val(), qsoft_user_last: jQuery('#qsoft_user_last').val(),
                    qsoft_user_pass: jQuery('#qsoft_user_pass').val(), qsoft_user_pass_confirm: jQuery('#qsoft_user_pass_confirm').val()
                    ,qsoft_user_meta: JSON.stringify(obj_user_meta)
                },
                beforeSend: function (xhr) {
                    jQuery('#wp-submit').attr("disabled", "true");
                    jQuery('.qsoft_message').removeClass('hidden');
                    jQuery('.qsoft_img_loading').removeClass('hidden');
                },
                success: function (result) {
                    jQuery('html,body').animate({
                        scrollTop: jQuery('.qsoft_message').offset().top - 110},
                            'slow');
                    if (result.status) {
                        document.getElementById("qsoft_registration_form").reset();
                        jQuery('#qsoft_registration_form').addClass('hidden');
                    } else {
                        jQuery('.qsoft_message').append(result.err_text);
                    }
                    jQuery('.qsoft_img_loading').addClass('hidden');
                    jQuery(".portal_validate").removeClass('hidden');
                    jQuery('#wp-submit').removeAttr("disabled");
                    jQuery(".qsoft_message").html(result.message);
                }}
            );
        }
        return;
    });
//    profile
    jQuery('#qsoft_profile_form').submit(function (e) {
        e.preventDefault();
        var err = '';
        var i = 0;
        var status = true;
        jQuery(".autofill").remove();
        jQuery(".form_message").html();
        jQuery('form#qsoft_profile_form').find('input').each(function () {
            if (jQuery(this).prop('required') && jQuery(this).val() == '') {
                i++;
                jQuery(this).addClass('input_err');
                jQuery(this).parent().append('<p class="autofill error"> The field must be require!</p>');
                status = false;
//                if (i === 1) {
//                    jQuery('html,body').animate({
//                        scrollTop: jQuery(this).offset().top - 110},
//                    'slow');
//                }
            }
//check email
            else if (jQuery(this).attr('id') == 'email') {
                jQuery(this).removeClass('input_err');
                var email = jQuery('#register input[name="email'); //change form to id or containment selector
                var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
                if (email.val() == '' || !re.test(email.val()))
                {
                    jQuery(this).addClass('input_err');
                    jQuery(this).parent().append('<p class="autofill error"> Email not valid!</p>');
                    status = false;
                    jQuery('html,body').animate({
                        scrollTop: jQuery(this).offset().top - 110},
                            'slow');
                }
            } else {
                jQuery(this).removeClass('input_err');
            }
        });
        if (status == false) {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
        } else {
            jQuery('.qsoft_message').html('');
            var obj_user_meta={};
            jQuery('.qsoft_user_meta.q_text').each(function(){
                obj_user_meta[jQuery(this).attr('name')]=jQuery(this).val()
            })
            jQuery('.qsoft_user_meta.q_radio:checked').each(function(){
                obj_user_meta[jQuery(this).attr('name')]=jQuery(this).val()
            })
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                method: "POST",
                dataType: "json",
                data: {qsoft_user_email: jQuery('#qsoft_user_email').val(),
                    qsoft_display_name: jQuery('#qsoft_display_name').val(),
                    qsoft_user_meta: JSON.stringify(obj_user_meta)
                },
                beforeSend: function (xhr) {
                    jQuery('#wp-submit').attr("disabled", "true");
                    jQuery('.qsoft_message').removeClass('hidden');
                    jQuery('.qsoft_img_loading').removeClass('hidden');
                },
                success: function (result) {
                    jQuery('html,body').animate({
                        scrollTop: jQuery('.qsoft_message').offset().top - 110},
                            'slow');
                    if (result.status) {
                        //nothing
                    } else {
                        jQuery('.qsoft_message').append(result.err_text);
                    }
                    jQuery('.qsoft_img_loading').addClass('hidden');
                    jQuery(".portal_validate").removeClass('hidden');
                    jQuery('#wp-submit').removeAttr("disabled");
                    jQuery(".qsoft_message").html(result.message);
                }}
            );
        }
        return;
    });
    //end profile
    jQuery('#resetPasswordForm').submit(function (e) {
        e.preventDefault();
        var err = '';
        if (jQuery('#pass1').val() === '') {
            err += '<li> Password new not empty</li>';
            jQuery('#pass1').prev().addClass('label_err');
            jQuery('#pass1').addClass('input_err');
        }
        if (jQuery('#pass2').val() === '' || jQuery('#pass2').val() != jQuery('#pass1').val()) {
            err += '<li> Incorrect password authentication</li>';
            jQuery('#pass2').prev().addClass('label_err');
            jQuery('#pass2').addClass('input_err');
        }
        if (err != '') {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
            e.preventDefault();
        } else {
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                method: "POST",
                dataType: "json",
                data: {pass1: jQuery('#pass1').val(), pass2: jQuery('#pass2').val(), user_key: jQuery('#user_key').val(), user_login: jQuery('#user_login').val()},
                beforeSend: function (xhr) {
                    jQuery('#wp-submit').attr("disabled", "true");
                    jQuery('.qsoft_img_loading').removeClass('hidden');
                    jQuery('.wrap_loading').addClass('show');
                },
                success: function (result) {
                    if (result.status) {
                        document.getElementById("resetPasswordForm").reset();
                        jQuery('#resetPasswordForm').addClass('hidden');
                    } else {
                        jQuery('#' + result.field).prev().addClass('label_err');
                        jQuery('#' + result.field).addClass('input_err');
                    }
                    jQuery('.wrap_loading').removeClass('show');
                    jQuery(".portal_validate").removeClass('hidden');
                    jQuery('#wp-submit').removeAttr("disabled");
                    jQuery('.qsoft_img_loading').addClass('hidden');
                    jQuery(".portal_validate").html(result.message);
                }}
            );
        }
        return;
    });
    jQuery('#lostpasswordform').submit(function (e) {
        e.preventDefault();
        var err = '';
        if (jQuery('#user_login').val() === '') {
            err += '<li> Email not empty</li>';
            jQuery('#user_login').prev().addClass('label_err');
            jQuery('#user_login').addClass('input_err');
        }

        if (err != '') {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
        } else {
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                method: "POST",
                dataType: "json",
                data: {user_login: jQuery('#user_login').val()},
                beforeSend: function (xhr) {
                    jQuery('#wp-submit').attr("disabled", "true");
                    jQuery('.qsoft_img_loading').removeClass('hidden');
                    jQuery('.wrap_loading').addClass('show');
                },
                success: function (result) {
                    if (result.status) {
                        document.getElementById("lostpasswordform").reset();
                        jQuery('#lostpasswordform').addClass('hidden');
                    } else {
                        jQuery('#' + result.field).prev().addClass('label_err');
                        jQuery('#' + result.field).addClass('input_err');
                    }
                    jQuery('.wrap_loading').removeClass('show');
                    jQuery(".portal_validate").removeClass('hidden');
                    jQuery('#wp-submit').removeAttr("disabled");
                    jQuery('.qsoft_img_loading').addClass('hidden');
                    jQuery(".portal_validate").html(result.message);
                }}
            );
        }
        return;
    });
    jQuery('#change_password').submit(function (e) {
        e.preventDefault();
        var err = '';
        if (jQuery('#pwd_old').val() === '') {
            err += '<li>Password current not empty</li>';
            jQuery('#pwd_old').prev().addClass('label_err');
            jQuery('#pwd_old').addClass('input_err');
        } else {
            jQuery('#pwd_old').prev().removeClass('label_err');
            jQuery('#pwd_old').removeClass('input_err');
        }
        if (jQuery('#pwd_new').val() === '') {
            err += '<li>Password new not empty</li>';
            jQuery('#pwd_new').prev().addClass('label_err');
            jQuery('#pwd_new').addClass('input_err');
        } else {
            jQuery('#pwd_new').prev().removeClass('label_err');
            jQuery('#pwd_new').removeClass('input_err');
        }
        if (jQuery('#pwd_re_new').val() != jQuery('#pwd_new').val() || jQuery('#pwd_re_new').val() === '') {
            err += '<li>Incorrect password authentication</li>';
            jQuery('#pwd_re_new').prev().addClass('label_err');
            jQuery('#pwd_re_new').addClass('input_err');
        } else {
            jQuery('#pwd_re_new').prev().removeClass('label_err');
            jQuery('#pwd_re_new').removeClass('input_err');
        }
        if (err != '') {
            jQuery('.portal_validate').removeClass('hidden');
            jQuery('.portal_validate').html(err);
            jQuery('.login_fail').addClass('hidden');
        } else {
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                method: "POST",
                dataType: "json",
                data: {pwd_old: jQuery('#pwd_old').val(), pwd_new: jQuery('#pwd_new').val(), pwd_re_new: jQuery('#pwd_re_new').val()},
                beforeSend: function (xhr) {
                    jQuery('#wp-submit').attr("disabled", "true");
                    jQuery('.qsoft_img_loading').removeClass('hidden');
                    jQuery('.wrap_loading').addClass('show');
                },
                success: function (result) {
                    if (result.status) {
                        document.getElementById("change_password").reset();
                        jQuery('#change_password').addClass('hidden');
                    } else {
                        jQuery('#' + result.field).prev().addClass('label_err');
                        jQuery('#' + result.field).addClass('input_err');
                    }
                    jQuery('.wrap_loading').removeClass('show');
                    jQuery(".portal_validate").removeClass('hidden');
                    jQuery('#wp-submit').removeAttr("disabled");
                    jQuery('.qsoft_img_loading').addClass('hidden');
                    jQuery(".portal_validate").html(result.message);
                }}
            );
        }
    }); //end change_pass
    jQuery(document).ready(function () {
        jQuery('.group-document').each(function () {
            var items_length = jQuery(this).find('.item-document').length;
            for (var i = 5; i < items_length; i++) {
                jQuery(this).find('.item-document').eq(i).hide();
            }
            jQuery(this).find('.document_readmore').on('click', function () {
                jQuery(this).parent().find('.item-document').fadeIn('slow');
                jQuery(this).hide();
            });
        });
    });
});


