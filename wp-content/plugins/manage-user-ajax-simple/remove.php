<?php

// user remove_user login form
function qsoft_remove_user_form() {
    // only show the remove_user form to non-logged-in members
    if (is_user_logged_in()) {
        $output = qsoft_remove_user_form_fields();
        return $output;
    }
}

add_shortcode('remove_user_form', 'qsoft_remove_user_form');

// remove_user form fields
function qsoft_remove_user_form_fields() {
    ob_start();
    ?>
    <form class="remove_account" method="post" action="<?php echo admin_url('admin-ajax.php?action=remove_user') ?>">
        <p class="first">Tôi muốn xóa tài khoản</p>
        <p class="last">Toàn bộ thông tin của bạn sẽ <u><strong>bị xóa vĩnh viễn</strong></u> khi nhấn vào xóa tài khoản</p>
    <button type="submit" id="wp-submit" name="qsoft_remove_user" class="buttons btn_remove_account">
        <?php _e('Submit'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
    </button>
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
function qsoft_send_mail_remove($user_info) {

    $message = "Gửi " . $user_info->data->display_name . ","
            . "\n\nAi đó đã xóa tài khoản trên trang web:"
            . "\n\n" . network_home_url('/')
            . "\n\nTài khoản: " . $user_info->data->user_login
            . "\n\nNếu đây không phải là bạn, vui lòng liên hệ với ban quản trị!";
    if (wp_mail($user_info->data->user_email, '[%s] Xóa mật khẩu', $message)) {
        return true;
    } else
        return FALSE;
//    echo '<script>window.location = "' . home_url() . '";</script>';
}

// remove_user a new user
function qsoft_remove_user() {
    if (isset($_POST["qsoft_remove_user"])) {
        require_once(ABSPATH . 'wp-admin/includes/user.php' );
        $current_id = get_current_user_id();
        $user_info = get_user_by('ID', $current_id);
        if (wp_delete_user($current_id, 1)) {
            qsoft_send_mail_remove($user_info);
            echo json_encode(array('status' => true, 'message' => '<li class="danger">Xóa tài khoản thành công</li>'));
            exit;
        }
        die;
    }
}

//add_action('init', 'qsoft_remove_user');
add_action('wp_ajax_nopriv_remove_user', 'qsoft_remove_user');
add_action('wp_ajax_remove_user', 'qsoft_remove_user');
/*
 * 	@desc	Process lost password
 */

