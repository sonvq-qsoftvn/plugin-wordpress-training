<?php

function qsoft_validate_change_pass($current_user) {
    $pwd_old = filter_var($_POST['pwd_old'], FILTER_SANITIZE_STRING);

    $pwd_new = filter_var($_POST['pwd_new'], FILTER_SANITIZE_STRING);
    $pwd_re_new = filter_var($_POST['pwd_re_new'], FILTER_SANITIZE_STRING);
    $err = '';
    if ($pwd_old == NULL || $pwd_new == NULL || $pwd_re_new == NULL) {
        return $err = json_encode(array('status' => FALSE, 'message' => '<li class="danger">The fields not be empty</li>'));
    }
    if ($pwd_new != $pwd_re_new) {
        return $err = json_encode(array('status' => FALSE, 'message' => '<li class="danger">Incorrect password authentication</li>'));
    }

    if (!wp_check_password($pwd_old, $current_user->user_pass, $current_user->ID)) {
        return $err = json_encode(array('status' => FALSE, 'field' => 'pwd_old', 'message' => '<li class="danger">Current password wrong</li>'));
    }
    return $err;
}

/**
 * desc Change password
 */
add_action('wp_ajax_change_password', 'qsoft_change_password_transfer');

function qsoft_change_password_transfer() {
    if (!is_user_logged_in()) {
//        echo $mess='<li>Bạn phải đăng nhập mới sử dụng được chức năng này!</li>';
        echo json_encode(array('status' => FALSE, 'message' => '<li>you must login!</li>'));
        die();
    }
    if (isset($_POST)) {
        $current_user = get_user_by('id', get_current_user_id());
        $check_valid = qsoft_validate_change_pass($current_user);
        if ($check_valid != '') {
            echo $check_valid;
        } else {
            global $wpdb;
            $pwd_new = filter_var($_POST['pwd_new'], FILTER_SANITIZE_STRING);
            $user_email = ($current_user->data->user_email);
            wp_set_password($pwd_new, get_current_user_id());
            $message_default = "Dear " . $current_user->user_firstname . " " . $current_user->user_lastname . ","
                    . "\n\nThis message confirms that your password has been changed."
                    . "\n\nIf you do not change your password, please contact the system administrator via email"
                    . "\n\n" . get_option('admin_email')
                    . "\n\nRespect,"
                    . "\n\n" . network_site_url();

            //send mail
            $data_specialized = array(
                'email' => $user_email,
                'user_login' => $user_info->data->user_login
            );
            $send_to = $user_email;
            $send_from = get_option('qsoft_change_password_send_from') != '' ? get_option('qsoft_change_password_send_from') : 'UserManagmentSystem';
            $subject = get_option('qsoft_change_password_mail_subject') != '' ? get_option('qsoft_change_password_mail_subject') : 'Password change notifications from the system';
            $send_name = get_option('qsoft_change_password_name') != '' ? get_option('qsoft_change_password_name') : 'UMS';
            $headers = "From: $send_name <$send_from>" . "\r\n";
            $mail_content = get_option('qsoft_change_password_mail_content') != '' ? get_field_mail($user_info->ID, 'qsoft_change_password_mail_content', $data_specialized) : $message_default;
            if (wp_mail($send_to, $subject, $mail_content, $headers)) {
                echo json_encode(array('status' => TRUE, 'message' => '<li class="success text-center">Change password success</li>'));
            } else
                echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Err! not send email! please contact admin</li>'));
        }
    }
    die();
}

//frontend
function qsoft_change_password_form() {
    $output = qsoft_change_password_form_field();
    return $output;
}

add_shortcode('qsoft_change_password_form', 'qsoft_change_password_form');

function qsoft_change_password_form_field() {
    ob_start();
    ?>
    <section class="wrap_content loginForm text-center">
        <h1 class="title_portal"><?php _e('Change password', 'qsoft') ?></h1>
        <div class="portal_content">
            <?php
            global $user_login;
            if (is_user_logged_in()) {
                ?>
                <ul class="portal_validate hidden">
                </ul>
                <div class="wrap_loading"></div>
                <form name="change_password" id="change_password" action="<?php echo admin_url('admin-ajax.php?action=change_password') ?>" method="post">
                    <p class="">
                        <label ><?php _e('Current password', 'qsoft') ?></label>
                        <input id="pwd_old" autocomplete="off" class="demo-form"  type="password"  value="" name="pwd_old">
                    </p>
                    <p class="">
                        <label ><?php _e('New password', 'qsoft') ?></label>
                        <input id="pwd_new"  autocomplete="off"  class="demo-form" label="Mật khẩu mới" type="password" size="20" value="" name="pwd_new">
                    </p>
                    <p class="">
                        <label ><?php _e('New password again', 'qsoft') ?></label>
                        <input id="pwd_re_new"  autocomplete="off"  class="demo-form" label="Nhập lại mật khẩu mới" type="password" size="20" value="" name="pwd_re_new">
                    </p>
                    <p class="clearfix wrap_btn_login">
                        <button type="submit" id="wp-submit" name="wp-submit" class="btn-no-full text-uppercase">
                            <?php _e('Submit'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
                        </button>
                        <!--<input id="wp-submit" class="btn-no-full text-uppercase" type="submit" value="<?php _e('submit') ?>" name="wp-submit">-->
                    </p>
                    <input type="hidden" value="<?php echo get_permalink(); ?>" name="redirect_to">
                    <input type="hidden" value="1" name="testcookie">
                </form>

                <?php
            } else {
                ?>
                <p><?php _e('Please ') ?><a id="wp-submit" href="<?php echo get_permalink(get_option('qsoft_page_login')) ?>" title="Logout">click</a> <?php _e('to login!', 'qsoft') ?></p>
                <?php
            }
            ?> 
        </div>
        <div class="home_direct">
            <a href="<?php echo get_permalink(get_option('qsoft_page_login')) ?>"><?php _e('After changed password. Please click here to login', 'qsoft') ?></a>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
