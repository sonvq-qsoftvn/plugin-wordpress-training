<?php
add_action('wp_ajax_nopriv_lost_pass', 'qsoft_lost_pass_callback');
add_action('wp_ajax_lost_pass', 'qsoft_lost_pass_callback');
/*
 * 	@desc	Process lost password
 */

function qsoft_lost_pass_callback() {

    global $wpdb, $wp_hasher;
    $nonce = filter_var($_POST['nonce'], FILTER_SANITIZE_STRING);

//    if (!wp_verify_nonce($nonce, 'rs_user_lost_password_action'))
//        die('Security checked!');
    //We shall SQL escape all inputs to avoid sql injection.
    $user_login = filter_var($_POST['user_login'], FILTER_SANITIZE_STRING);

    $errors = new WP_Error();

    if (empty($user_login)) {
        $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
    } else if (strpos($user_login, '@')) {
        $user_data = get_user_by('email', trim($user_login));
        if (empty($user_data))
//            $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
            echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Email not exist!</li>'));
    } else {
        $login = trim($user_login);
        $user_data = get_user_by('login', $login);
    }


    /**
     * Fires before errors are returned from a password reset request.
     *
     * @since 2.1.0
     */
    do_action('lostpassword_post');

    if (!$user_data)
        die();
//        $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
//        echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Sai email</li>'));
    // redefining user_login ensures we return the right case in the email
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
//    var_dump($user_email);die;

    /**
     * Filter whether to allow a password to be reset.
     *
     * @since 2.7.0
     *
     * @param bool true           Whether to allow the password to be reset. Default true.
     * @param int  $user_data->ID The ID of the user attempting to reset a password.
     */
    $allow = apply_filters('allow_password_reset', true, $user_data->ID);

    if (!$allow)
//        $errors->add('no_password_reset', __('Password reset is not allowed for this user'));
        echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Password reset is not allowed for this user</li>'));

    // Generate something random for a password reset key.
    $key = wp_generate_password(20, false);

    /**
     * Fires when a password reset key is generated.
     *
     * @since 2.5.0
     *
     * @param string $user_login The username for the user.
     * @param string $key        The generated password reset key.
     */
    do_action('retrieve_password_key', $user_login, $key);

    // Now insert the key, hashed, into the DB.
    if (empty($wp_hasher)) {
        require_once ABSPATH . 'wp-includes/class-phpass.php';
        $wp_hasher = new PasswordHash(8, true);
    }
    $hashed = time() . ':' . $wp_hasher->HashPassword($key);
//    $hashed=  wp_hash_password($key);
    $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));
    $user_info = get_user_by('email', $user_email);
    $message_default = "Dear! " . $user_info->data->display_name . ","
            . "\n\nSomeone has requested a password reset for your account on the site:"
            . "\n\n" . network_home_url('/')
            . "\n\nAccount: " . $user_info->data->user_login
            . "\n\nIf this is an error, please ignore this email; Your account information will remain unchanged."
            . "\n\nTo reset your password, please click on the following link:"
            . "\n\n" . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_info->data->user_login), 'login') . "\r\n";
//send mail
    $data_specialized = array(
        'email' => $user_email,
        'link_forgot_password' => network_site_url("wp-login.php?action=register&key=$key&login=" . rawurlencode($user_info->data->user_login), 'login'),
        'user_login' => $user_info->data->user_login
    );
    $send_to = $user_email;
    $send_from = get_option('qsoft_forgot_password_send_from') != '' ? get_option('qsoft_forgot_password_send_from') : 'UserManagmentSystem';
    $subject = get_option('qsoft_forgot_password_mail_subject') != '' ? get_option('qsoft_forgot_password_mail_subject') : 'Reset password';
    $send_name = get_option('qsoft_forgot_password_name') != '' ? get_option('qsoft_forgot_password_name') : 'UMS';
    $headers = "From: $send_name <$send_from>" . "\r\n";
    $mail_content = get_option('qsoft_forgot_password_mail_content') != '' ? get_field_mail($user_info->ID, 'qsoft_forgot_password_mail_content', $data_specialized) : $message_default;
    if (wp_mail($send_to, $subject, $mail_content, $headers)) {
        echo json_encode(array('status' => TRUE, 'message' => '<li class="success text-center">A link confirmation has been sent to your mailbox!</li>'));
    } else
        echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Err! not send email! please contact admin</li>'));

    if ($errors->get_error_code())
        echo '<p class="error">' . $errors->get_error_message($errors->get_error_code()) . '</p>';
    die();
}

function qsoft_reset_password_form() {
    // only show the registration form to non-logged-in members
    $output = qsoft_reset_password_form_field();
    return $output;
}

add_shortcode('qsoft_reset_password_form', 'qsoft_reset_password_form');

function qsoft_reset_password_form_field() {
    ob_start();
    ?>
    <section class="wrap_content loginForm text-center">
        <h1 class="title_portal"><?php _e('Reset password', 'qsoft') ?></h1>
        <div class="portal_content">
            <?php
            global $user_login;
            if (!is_user_logged_in()) {
                ?>
                <ul class="portal_validate hidden">
                </ul>
                <div class="wrap_loading"></div>
                <form name="lostpasswordform" id="lostpasswordform" action="<?php echo admin_url('admin-ajax.php?action=lost_pass') ?>" method="post">
                    <p>
                        <label ><?php _e('Your Email', 'qsoft') ?></label>
                        <input label="Nhập email" id='user_login' class="demo-form" type="email" name="user_login" id="user_login" value="">
                    </p>

                    <input type="hidden" name="redirect_to" value="<?php echo wp_logout_url(get_permalink(get_option('qsoft_page_thankyou'))) ?>">
                    <p class="clearfix wrap_btn_login">
                        <button type="submit" id="wp-submit" name="wp-submit">
                            <?php _e('Submit'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
                        </button>
                    </p>
                </form>

                <?php
            } else {
                ?>
                <p><?php _e('You were login! ', 'qsoft') ?><a id="wp-submit" href="<?php echo wp_logout_url(get_permalink(get_option('qsoft_page_login'))) ?>" title="Logout"><?php _e('Logout here', 'qsoft') ?></a></p>

                <?php
            }
            ?> 
        </div>
        <div class="home_direct"><a href="<?php echo get_site_url() ?>"><?php _e('Return home', 'qsoft') ?></a></div>
    </section>
    <?php
    return ob_get_clean();
}
