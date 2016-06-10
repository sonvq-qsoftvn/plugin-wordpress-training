<?php

/*
  Plugin Name: Manage user ajax simple
  Description: Create registration and login forms in front end
  Version: 1.0
  Author: Michael7
 */
include_once 'backend/backend.php';
//social
include_once 'backend/social/facebook_connect.php';
include_once 'libs/google_connect/auto_load.php';
include_once 'backend/social/google_connect.php';

include_once 'register.php';
include_once 'q_profile.php';
include_once 'login.php';
include_once 'logout.php';
include_once 'change_password.php';
include_once 'reset_password.php';
include_once 'input_news_password.php';

define('QMUS_PLUGIN_URL', plugins_url('', __FILE__));
//notice const
define('ERR_WRONG_KEY', 'Security key wrong. please check your email');
//link
if (!is_admin()) {
//    define('QSOFT_LINK_PAGE_LOGIN', get_option('qsoft_page_login') != '' ? get_permalink(get_option('qsoft_page_login')) : home_url());
//    define('QSOFT_LINK_LOGIN_SUCCESS', get_option('qsoft_redirect_login_success') != '' ? get_permalink(get_option('qsoft_redirect_login_success')) : home_url());
//    define('QSOFT_LINK_ACTIVE_ACCOUNT_SUCCESS', get_option('qsoft_redirect_active_account') != '' ? get_permalink(get_option('qsoft_redirect_active_account')) : home_url());
}

function qsoft_deliver_mail($email = '', $subject = '[Manage user system] Notifications from the system', $message = '') {
    if ($email == '') {
        $current_user = wp_get_current_user();
        $email = $current_user->user_email;
    }
    $to = $email;
    $from = 'Manage user system';
    $name = 'QMUS';
    $headers = "From: $name <$from>" . "\r\n";
    if (wp_mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return FALSE;
    }
}

/**
 * @desc Procss login
 * @return type
 */
function qsoft_login_init() {
    $action = isset($_REQUEST['action']) ? filter_var($_REQUEST['action'], FILTER_SANITIZE_STRING) : 'login';
    $key = isset($_REQUEST['key']) ? filter_var($_REQUEST['key'], FILTER_SANITIZE_STRING) : '';
    $login = isset($_REQUEST['login']) ? filter_var($_REQUEST['login'], FILTER_SANITIZE_STRING) : '';
    // redirect to change password form
    if ($action == 'rp' || $action == 'resetpass1') {
        if (get_option('qsoft_page_input_new_password') != '') {
            wp_redirect(get_permalink(get_option('qsoft_page_input_new_password')) . '/?key=' . $key . '&' . 'login=' . $login);
        } else {
            _e('Admin not setting page input new pass');
        }
        exit;
    }
    if ($action == 'register') {
        $errors = new WP_Error();
        $user = check_password_reset_key($key, $login);
        if (is_wp_error($user)) {
            if ($user->get_error_code() === 'expired_key')
                $errors->add('expiredkey', __('Expired key!'));
            else
                $errors->add('invalidkey', __('Wrong key! please check email again!'));
        }
        if ($errors->get_error_code()):
            echo $errors->get_error_message($errors->get_error_code());
        else:
            $user_data = get_user_by('login', $login);
            update_user_meta($user_data->ID, 'user_flag', 1);
            $link_active_success = get_option('qsoft_redirect_active_account') != '' ? get_permalink(get_option('qsoft_redirect_active_account')) : home_url();
            qsoft_redirect($link_active_success, __('Your account active successful!'));
        endif;
        exit;
    }

    // redirect from wrong key when resetting password
    if ($action == 'lostpassword' && isset($_GET['error']) && ( filter_var($_REQUEST['error'], FILTER_SANITIZE_STRING) == 'expiredkey' || filter_var($_REQUEST['error'], FILTER_SANITIZE_STRING) == 'invalidkey' )) {
        wp_redirect((get_permalink(PAGE_INPUT_PASS) . '/?failed=wrongkey'));
        exit;
    }
    return;
}

add_action('login_init', 'qsoft_login_init');

// frontend asset
function qsoft_enqueue_scripts_and_styles() {
    wp_enqueue_style('qsoft-form-css1', plugin_dir_url(__FILE__) . 'css/form.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('qsoft_manage_user', plugin_dir_url(__FILE__) . 'js/qsoft_manage_user.js', array(), false, true);
}

add_action('wp_enqueue_scripts', 'qsoft_enqueue_scripts_and_styles');

//backend asset
function qsoft_load_custom_wp_admin_style() {
    wp_enqueue_style('css_backend', plugin_dir_url(__FILE__) . '/css/backend.css');
    wp_enqueue_script('js_backend', plugin_dir_url(__FILE__) . '/js/backend.js', ['jquery'], null, true);
}

add_action('admin_enqueue_scripts', 'qsoft_load_custom_wp_admin_style', 100);

register_deactivation_hook(__FILE__, 'qsoft_deactive_plugin');

function qsoft_deactive_plugin() {
    update_option('qsoft_generate_page_status', '0', '', 'yes');
}

function qsoft_redirect($link, $alert) {
    $show_alert = '';
    if ($alert != '') {
        $show_alert = 'alert("' . $alert . '");';
    }
    if ($link == '') {
        $link = home_url();
    }
    echo '<script>' . $show_alert . ' window.location = "' . $link . '";</script>';
    exit();
}

/**
 * 
 * @param type $user_id
 * @param type $arr_all_field
 * @param type $data_specialized
 */
function get_field_mail($user_id, $field_mail, $data_specialized) {
    $field_mail_value = get_option($field_mail);
    $pattern = '/(\[)([0-9A-Za-z_]+)(\])/i';
    preg_match_all($pattern, $field_mail_value, $item);

    $arrayReplace = [];
    foreach ($item[2] as $field_name) {
        switch ($field_name):
            case 'email':
                $arrayReplace[] = isset($data_specialized['email']) ? $data_specialized['email'] : '[email]';
                break;
            case 'website':
                $arrayReplace[] = str_replace(array('https://','http://'), '', get_site_url());
                break;
            case 'user_login':
                $arrayReplace[] = isset($data_specialized['user_login']) ? $data_specialized['user_login'] : '[user_login]';
                break;
            case 'link_active':
                $arrayReplace[] = isset($data_specialized['link_active']) ? str_replace(array('https://','http://'), '', $data_specialized['link_active']) : '[link_active]';
                break;
            case 'link_forgot_password':
                $arrayReplace[] = isset($data_specialized['link_forgot_password']) ? str_replace(array('https://','http://'), '', $data_specialized['link_forgot_password']) : '[link_forgot_password]';
                break;
            default:
                $arrayReplace[] = get_user_meta($user_id, $field_name, true);
        endswitch;
    }
    $fields = str_replace($item[0], $arrayReplace, $field_mail_value);
    return ($fields);
}

//function qsoft_send_email($send_to, $subject = 'User management system', $mail_content = 'hi', $name = 'Customer') {
//    require 'libs/PHPMailer-master/PHPMailerAutoload.php';
//    $mail = new PHPMailer;
////$mail->SMTPDebug = true;                               // Enable verbose debug output
////$phpmailer->SMTPDebug = true;
//    $mail->isSMTP();                                      // Set mailer to use SMTP
//    $mail->Host = get_option('qsoft_smtp_host') != '' ? get_option('qsoft_smtp_host') : 'smtp.gmail.com';  // Specify main and backup SMTP servers //smtp.gmail.com
//    $mail->SMTPAuth = get_option('qsoft_smtp_auth') != '' ? get_option('qsoft_smtp_auth') : true;                               // Enable SMTP authentication
//    $mail->Username = get_option('qsoft_smtp_user');                 // SMTP username
//    $mail->Password = get_option('qsoft_smtp_pass');                           // SMTP password
//    $mail->SMTPSecure = get_option('qsoft_smtp_ssl') != '' ? get_option('qsoft_smtp_ssl') : 'tls';                            // Enable TLS encryption, `ssl` also accepted
//    $mail->Port = 587;                                    // TCP port to connect to 587
//    $send_from = get_option('qsoft_mail_from') != '' ? get_option('qsoft_mail_from') : get_option('qsoft_smtp_user');
//    $mail->setFrom($send_from, get_option('qsoft_mail_from_name'));
//    $mail->addAddress($send_to, $name);     // Add a recipient
////    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
////    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//    $mail->isHTML(true);                                  // Set email format to HTML
//
//    $mail->Subject = $subject;
//    $mail->Body = $mail_content;
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//   
//    if (!$mail->send()) {
//         var_dump($mail);
//        return FALSE;
////        echo 'Mailer Error: ' . $mail->ErrorInfo;
//    } else {
//        return true;
//    }
//}

