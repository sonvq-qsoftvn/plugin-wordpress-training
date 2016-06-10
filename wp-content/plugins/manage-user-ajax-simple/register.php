<?php

// user registration login form
function qsoft_registration_form() {
    // only show the registration form to non-logged-in members
    if (!is_user_logged_in()) {
        global $qsoft_load_css;
        // set this to true so the CSS is loaded
        $qsoft_load_css = true;

        // check to make sure user registration is enabled
        $registration_enabled = get_option('users_can_register');

        // only show the registration form if allowed
        if ($registration_enabled) {
            $output = qsoft_registration_form_fields();
        } else {
            $output = __('User registration is not enabled');
        }
    } else {
        $output = qsoft_profile_form_fields();
    }
    return $output;
}

add_shortcode('qsoft_registration_form', 'qsoft_registration_form');

// registration form fields
function qsoft_registration_form_fields() {

    ob_start();
    ?>	
    <h3 class="qsoft_header"><?php _e('Register New Account'); ?></h3>

    <?php
    // show any error messages after form submission
//    var_dump(get_userdata());
    ?>
    <div class="qsoft_message hidden"></div>
    <form id="qsoft_registration_form" class="qsoft_form" action="<?php echo admin_url('admin-ajax.php?action=register_user') ?>" method="POST" novalidate>
        <fieldset>


            <p>
                <label for="qsoft_user_Login"><?php _e('Username'); ?></label>
                <input name="qsoft_user_login" id="qsoft_user_login"  required type="text"/>
            </p>
            <p>
                <label for="qsoft_user_email"><?php _e('Email'); ?></label>
                <input name="qsoft_user_email" id="qsoft_user_email"  required type="email"/>
            </p>
            <p>
                <label for="qsoft_user_first"><?php _e('First Name'); ?></label>
                <input name="qsoft_user_first" id="qsoft_user_first" required type="text"/>
            </p>
            <p>
                <label for="qsoft_user_last"><?php _e('Last Name'); ?></label>
                <input name="qsoft_user_last" id="qsoft_user_last" required type="text"/>
            </p>
            <p>
                <label for="password"><?php _e('Password'); ?></label>
                <input name="qsoft_user_pass" id="qsoft_user_pass"  required type="password"/>
            </p>
            <p>
                <label for="password_again"><?php _e('Password Again'); ?></label>
                <input name="qsoft_user_pass_confirm" id="qsoft_user_pass_confirm" required  type="password"/>
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
                        $value = '';
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
                    <?php _e('Register Your Account'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
                </button>
            </p>
        </fieldset>
    </form>
    <?php
    return ob_get_clean();
}

/**
 * 
 * @global type $wpdb
 * @global PasswordHash $wp_hasher
 * @param type $user_login
 * @param type $user_email
 */
function qsoft_send_link_active($user_login, $user_email) {
    global $wpdb, $wp_hasher;
    $key = wp_generate_password(20, false);
    do_action('retrieve_password_key', $user_login, $key);
    // Now insert the key, hashed, into the DB.
    if (empty($wp_hasher)) {
        require_once ABSPATH . 'wp-includes/class-phpass.php';
        $wp_hasher = new PasswordHash(8, true);
    }
    $hashed = time() . ':' . $wp_hasher->HashPassword($key);
    $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));
    $user_info = get_user_by('email', $user_email);
    $message_default = "Dear " . $user_info->data->display_name . ","
            . "\n\nSomeone register account on the site:"
            . "\n\n" . str_replace(array('https://','http://'), '', network_home_url('/'))
            . "\n\nUser name: " . $user_info->data->user_login
            . "\n\nIf this is an error, please ignore this email"
            . "\n\nTo active your account, please click on the following link:"
            . "\n\n" . str_replace(array('https://','http://'), '', network_site_url("wp-login.php?action=register&key=$key&login=" . rawurlencode($user_info->data->user_login), 'login')) . "\r\n";
    $data_specialized = array(
        'email' => $user_email,
        'link_active' => network_site_url("wp-login.php?action=register&key=$key&login=" . rawurlencode($user_info->data->user_login), 'login'),
        'user_login' => $user_info->data->user_login
    );
    $send_to = $user_email;
    $send_from = get_option('qsoft_active_account_send_from') != '' ? filter_var(get_option('qsoft_active_account_send_from'), FILTER_SANITIZE_EMAIL) : 'qump@gmail.com';
    $subject = get_option('qsoft_active_account_mail_subject') != '' ? get_option('qsoft_active_account_mail_subject') : 'Register new user';
    $send_name = get_option('qsoft_active_account_name') != '' ? get_option('qsoft_active_account_name') : 'UMS';
    $headers = "From: $send_name <$send_from>" . "\r\n";
    $mail_content = get_option('qsoft_active_account_mail_content') != '' ? get_field_mail($user_info->ID, 'qsoft_active_account_mail_content', $data_specialized) : $message_default;

    global $wpms_options, $phpmailer;

    // Make sure the PHPMailer class has been instantiated 
    // (copied verbatim from wp-includes/pluggable.php)
    // (Re)create it, if it's gone missing
    if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer')) {
        require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';
        $phpmailer = new PHPMailer(true);
    }
    if (wp_mail($send_to, $subject, $mail_content, $headers)) {
        return true;
    } else
        return FALSE;

    die();
}

add_action('wp_ajax_nopriv_register_user', 'qsoft_register_user_callback');
add_action('wp_ajax_register_user', 'qsoft_register_user_callback');
/*
 * 	@desc	Process reset password
 */

function qsoft_register_user_callback() {
//    if (isset($_POST["qsoft_user_login"]) && wp_verify_nonce(filter_var($_POST['qsoft_register_nonce'], FILTER_SANITIZE_STRING), 'qsoft-register-nonce')) {
    $user_login = filter_var($_POST['qsoft_user_login'], FILTER_SANITIZE_STRING);
    $user_email = filter_var($_POST['qsoft_user_email'], FILTER_SANITIZE_STRING);
    $user_first = filter_var($_POST['qsoft_user_first'], FILTER_SANITIZE_STRING);
    $user_last = filter_var($_POST['qsoft_user_last'], FILTER_SANITIZE_STRING);
    $user_pass = filter_var($_POST['qsoft_user_pass'], FILTER_SANITIZE_STRING);
    $pass_confirm = filter_var($_POST['qsoft_user_pass_confirm'], FILTER_SANITIZE_STRING);
    // this is required for username checks
    require_once(ABSPATH . WPINC . '/registration.php');
    $qsoft_errors = array();
    if (username_exists($user_login)) {
        $qsoft_errors['qsoft_user_login'] = 'Username already taken';
    }
    if (!validate_username($user_login)) {
        $qsoft_errors['qsoft_user_login'] = 'Invalid username';
    }
    if ($user_login == '') {
        $qsoft_errors['qsoft_user_login'] = 'Please enter a username';
    }
    if (!is_email($user_email)) {
        $qsoft_errors['qsoft_user_email'] = 'Invalid email';
    }
    if (email_exists($user_email)) {
        $qsoft_errors['qsoft_user_email'] = 'Email already registered';
    }
    if ($user_pass == '') {
        $qsoft_errors['qsoft_user_pass'] = 'Please enter a password';
    }
    if ($user_pass != $pass_confirm) {
        $qsoft_errors['qsoft_user_pass_confirm'] = 'Passwords do not match';
    }

    // only create the user in if there are no errors
    if (empty($qsoft_errors)) {

        $new_user_id = wp_insert_user(array(
            'user_login' => $user_login,
            'user_pass' => $user_pass,
            'user_email' => $user_email,
            'first_name' => $user_first,
            'last_name' => $user_last,
            'user_registered' => date('Y-m-d H:i:s'),
            'role' => 'subscriber',
                )
        );
        if ($new_user_id) {
            add_user_meta($new_user_id, 'user_flag', 0, true);
            if ($_POST['qsoft_user_meta'] != '{}' && $_POST['qsoft_user_meta'] != '') {
                $arr_all_field = json_decode(str_replace('\\', '', $_POST['qsoft_user_meta']));
                foreach ($arr_all_field as $key => $val) {
                    update_user_meta($user_id, $key, $val);
                }
            }
            // send an email to the admin alerting them of the registration
            if (qsoft_send_link_active($user_login, $user_email)) {
                echo json_encode(array('status' => TRUE, 'message' => '<li class="success text-center">a link confirmation has been sent to your mailbox!</li>'));
            } else {
                echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Happened error! not send email! Please contact administrator</li>'));
            }
            // log the new user in
//            wp_setcookie($user_login, $user_pass, true);
//            wp_set_current_user($new_user_id, $user_login);
//            do_action('wp_login', $user_login);
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

// used for tracking error messages
function qsoft_errors() {
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function qsoft_show_error_messages() {
    if ($codes = qsoft_errors()->get_error_codes()) {
        echo '<div class="qsoft_errors">';
        // Loop error codes and display errors
        foreach ($codes as $code) {
            $message = qsoft_errors()->get_error_message($code);
            echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
        }
        echo '</div>';
    }
}
