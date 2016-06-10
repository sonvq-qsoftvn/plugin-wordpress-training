<?php

// user profile login form
function qsoft_profile_form() {
    // only show the profile form to non-logged-in members
    if (is_user_logged_in()) {

        // only show the profile form if allowed
        if ($profile_enabled) {
            $output = qsoft_profile_form_fields();
        } else {
            $output = __('User profile is not enabled');
        }
    } else {
        $output = 'You are not login!';
    }
    return $output;
}

add_shortcode('qsoft_profile_form', 'qsoft_profile_form');

// profile form fields
function qsoft_profile_form_fields() {
    ob_start();
    ?>	
    <h3 class="qsoft_header"><?php _e('Manage Account'); ?></h3>

    <?php
    // show any error messages after form submission
    qsoft_show_error_messages();
    $user_id = get_current_user_id();
    $arr_single_user = get_userdata($user_id);
    ?>

    <form id="qsoft_profile_form" class="qsoft_form" action="<?php echo admin_url('admin-ajax.php?action=update_user') ?>" method="POST" novalidate>
        <fieldset>
            <div class="qsoft_message hidden"></div>
            <p>
                <label for="qsoft_user_Login"><?php _e('Username'); ?></label>
                <input disabled id="qsoft_user_login" value="<?php echo $arr_single_user->data->user_login ?>"  required type="text"/>
            </p>
            <p>
                <label for="qsoft_display_name"><?php _e('Full Name'); ?></label>
                <input name="qsoft_display_name" id="qsoft_display_name" value="<?php echo $arr_single_user->data->display_name ?>" required type="text"/>
            </p>
            <p>
                <label for="qsoft_user_email"><?php _e('Email'); ?></label>
                <input name="qsoft_user_email" id="qsoft_user_email" value="<?php echo $arr_single_user->data->user_email ?>"  required type="email"/>
            </p>
            <?php
            $arr_all_field = get_option('qsoft_fields');
            if ($arr_all_field != ''):
                foreach ($arr_all_field as $arr_single_field):
                    $required = $arr_single_field['field_required'] == 1 ? 'required' : '';
                    ?>
                    <p>
                        <label for="qsoft_<?php echo $arr_single_field['field_name'] ?>"><?php echo $arr_single_field['field_label'] ?></label>
                        <?php
                        $file_type = $arr_single_field['field_type'];
                        $name = $arr_single_field['field_name'];
                        $field_option = $arr_single_field['field_option'];
                        $value = get_user_meta($user_id, "qsoft_user_meta_" . $arr_single_field['field_name'], true);
                        echo qsoft_get_input_by_file_type($file_type, $name, $value, $required, $field_option);
                        ?>
                    </p>
                    <?php
                endforeach;
            endif;
            ?>

            <p>
                <input type="hidden" name="qsoft_register_nonce" value="<?php echo wp_create_nonce('qsoft-register-nonce'); ?>"/>
                <button type="submit" id="btn_register">
                    <?php _e('Change'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
                </button>
            </p>
        </fieldset>
    </form>
    <?php
    return ob_get_clean();
}

add_action('wp_ajax_nopriv_update_user', 'qsoft_update_user_callback');
add_action('wp_ajax_update_user', 'qsoft_update_user_callback');

function qsoft_update_user_callback() {
    $arr_single_user = get_userdata(get_current_user_id());
//    if (isset($_POST["qsoft_user_login"]) && wp_verify_nonce(filter_var($_POST['qsoft_register_nonce'], FILTER_SANITIZE_STRING), 'qsoft-register-nonce')) {
    $user_email = filter_var($_POST['qsoft_user_email'], FILTER_SANITIZE_STRING);
    $user_display_name = filter_var($_POST['qsoft_display_name'], FILTER_SANITIZE_STRING);
    $qsoft_errors = array();
    if (!is_email($user_email)) {
        $qsoft_errors['qsoft_user_email'] = 'Invalid email';
    }
    if ($user_email != $arr_single_user->data->user_email) {
        if (email_exists($user_email)) {
            $qsoft_errors['qsoft_user_email'] = 'Email already registered';
        }
    }
//    var_dump($_POST);
    // only create the user in if there are no errors
    if (empty($qsoft_errors)) {
        $user_id = wp_update_user(array(
            'ID' => get_current_user_id(),
            'user_email' => $user_email,
            'display_name' => $user_display_name
                )
        );
        if ($user_id) {
            if ($_POST['qsoft_user_meta'] != '{}') {
                $arr_all_field = json_decode(str_replace('\\', '', $_POST['qsoft_user_meta']));
                foreach ($arr_all_field as $key => $val) {
                    update_user_meta($user_id, $key, $val);
                }
            }
            echo json_encode(array('status' => TRUE, 'message' => '<li class="success text-center">Update success</li>'));
        }
    } else {
        $str_error = '';
        foreach ($qsoft_errors as $error) {
            $str_error .='<li class="err_text text-center">' . $error . '</li>';
        }
        echo json_encode(array('status' => FALSE, 'err_text' => $str_error));
    }

//    }
    exit;
}

function qsoft_get_input_by_file_type($file_type = 'text', $name, $value, $required, $all_field_option = '') {
//    var_dump($field_option);
    switch ($file_type):
        case 'email':
        case 'text':
        case 'password':
        case 'number':
        case 'url':
        case 'hidden':
            return '<input type="' . $file_type . '" name="qsoft_user_meta_' . $name . '" '
                    . 'id="qsoft_' . $name . '" class="qsoft_user_meta q_text" value="' . $value . '" ' . $required . ' />';
            break;
        case 'textarea':
            return '<textarea name="qsoft_user_meta_' . $name . '" id="qsoft_' . $name . '" '
                    . 'class="qsoft_user_meta q_text" ' . $required . '>' . $value . '</textarea>';
            break;
        case 'checkbox':
            $html = '<br>checkbox is not available';
//            foreach ($all_field_option as $single_field_option) {
//                $arr_single_field_option = explode('|', $single_field_option);
//                if ($value == '') {
//                    $checked = $arr_single_field_option[2] == 1 ? 'checked' : '';
//                } else {
//                    $checked = $value == $arr_single_field_option[0] ? 'checked' : '';
//                }
//
//                $html .= '<label>' . $arr_single_field_option[1] . '</label><input type="' . $file_type . '" name="qsoft_user_meta_' . $name . '" '
//                        . 'id="qsoft_' . $name . '" class="qsoft_user_meta" value="' . $arr_single_field_option[0] . '" ' . $checked . ' />';
//            }
            return $html;
            break;
        case 'radio':
            $html = '<br>';
            foreach ($all_field_option as $single_field_option) {
                $arr_single_field_option = explode('|', $single_field_option);
                if ($value == '') {
                    $checked = $arr_single_field_option[2] == 1 ? 'checked' : '';
                } else {
                    $checked = $value == $arr_single_field_option[0] ? 'checked' : '';
                }
                $html .= '<label>' . $arr_single_field_option[1] . '</label>'
                        . '<input type="' . $file_type . '" name="qsoft_user_meta_' . $name . '" id="qsoft_' . $name . '" '
                        . 'class="qsoft_user_meta q_radio" value="' . $arr_single_field_option[0] . '" ' . $checked . ' />';
            }
            return $html;
            break;
        case 'select':
            $html = '<br>';
            $html .= '<select  name="qsoft_user_meta_' . $name . '" id="qsoft_' . $name . '" '
                    . 'class="qsoft_user_meta q_text">';
            foreach ($all_field_option as $single_field_option) {
                $arr_single_field_option = explode('|', $single_field_option);
                if ($value == '') {
                    $selected = $arr_single_field_option[2] == 1 ? 'selected' : '';
                } else {
                    $selected = $value == $arr_single_field_option[0] ? 'selected' : '';
                }

                $html .= '<option  value="' . $arr_single_field_option[0] . '" ' . $selected . ' /> ' . $arr_single_field_option[1] . '</option>';
            }
            $html.='</select>';
            return $html;
            break;
    endswitch;
}
