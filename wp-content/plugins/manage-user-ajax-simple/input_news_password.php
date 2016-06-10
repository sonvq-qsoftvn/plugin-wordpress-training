<?php
add_action('wp_ajax_nopriv_reset_pass', 'qsoft_reset_pass_callback');
add_action('wp_ajax_reset_pass', 'qsoft_reset_pass_callback');
/*
 * 	@desc	Process reset password
 */

function qsoft_reset_pass_callback() {

    $errors = new WP_Error();
    $nonce = $_POST['nonce'];

    if (!wp_verify_nonce($nonce, 'rs_user_reset_password_action'))
    //   die('Security checked!');
        $pass1 = filter_var($_REQUEST['pass1'], FILTER_SANITIZE_STRING);
    $pass2 = filter_var($_REQUEST['pass2'], FILTER_SANITIZE_STRING);
    $key = filter_var($_REQUEST['user_key'], FILTER_SANITIZE_STRING);
    $login = filter_var($_REQUEST['user_login'], FILTER_SANITIZE_STRING);

    $user = check_password_reset_key($key, $login);

    // check to see if user added some string
    if (empty($pass1) || empty($pass2))
//        $errors->add('password_required', __('Password is required field'));
        echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Password not be empty</li>'));

    // is pass1 and pass2 match?
    if (isset($pass1) && $pass1 != $pass2)
//        $errors->add('password_reset_mismatch', __('The passwords do not match.'));
        echo json_encode(array('status' => FALSE, 'message' => '<li class="danger">Incorrect password authentication</li>'));

    /**
     * Fires before the password reset procedure is validated.
     *
     * @since 3.5.0
     *
     * @param object           $errors WP Error object.
     * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
     */
    do_action('validate_password_reset', $errors, $user);

    if ((!$errors->get_error_code() ) && isset($pass1) && !empty($pass1)) {
        reset_password($user, $pass1);
//        $errors->add('password_reset', __('Your password has been reset.'));
        echo json_encode(array('status' => TRUE, 'message' => '<li class="success text-center">Password has been reissued.!</li>'));
    }

    // display error message
    if ($errors->get_error_code())
        echo '<p class="error">' . $errors->get_error_message($errors->get_error_code()) . '</p>';

    // return proper result
    die();
}

function qsoft_input_new_password_form() {
    // only show the registration form to non-logged-in members
    if (!is_user_logged_in()) {

        $output = qsoft_input_new_password_form_field();
    } else {
        $output = __('Please <a href="' . wp_logout_url() . '">logout</a>');
    }
    return $output;
}

add_shortcode('qsoft_input_new_password_form', 'qsoft_input_new_password_form');

function qsoft_input_new_password_form_field() {
    ob_start();
    ?>
    <section class="wrap_content loginForm text-center">
        <h1 class="title_portal"><?php _e('Reset password', 'qsoft') ?></h1>
        <div class="portal_content">

            <div id="resetPassword">
                <?php
                $errors = new WP_Error();
                $key = filter_var($_REQUEST['key'], FILTER_SANITIZE_STRING);
                $login = filter_var($_REQUEST['login'], FILTER_SANITIZE_STRING);
                $user = check_password_reset_key($key, $login);
                if (is_wp_error($user)) {
                    if ($user->get_error_code() === 'expired_key')
                        $errors->add('expiredkey', __('The requirement expired!'));
                    else
                        $errors->add('invalidkey', __('Security key wrong. please check your email'));
                }
                ?>
                <?php if ($errors->get_error_code()): ?>
                    <div class="message red">
                        <?php
                        // display error message
                        echo $errors->get_error_message($errors->get_error_code());
                        ?>
                    </div>
                <?php else: ?>
                    <ul class="portal_validate hidden">

                    </ul>
                    <div class="wrap_loading"></div>
                    <!--<img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">-->
                    <form id="resetPasswordForm" method="post" autocomplete="off" action="<?php echo admin_url('admin-ajax.php?action=reset_pass') ?>">
                        <?php
                        // this prevent automated script for unwanted spam
                        if (function_exists('wp_nonce_field'))
                            wp_nonce_field('rs_user_reset_password_action', 'rs_user_reset_password_nonce');
                        ?>
                        <input type="hidden" name="user_key" id="user_key" value="<?php echo esc_attr($_GET['key']) ?>" autocomplete="off" />
                        <input type="hidden" name="user_login" id="user_login" value="<?php echo esc_attr($_GET['login']); ?>" autocomplete="off" />

                        <p>
                            <label ><?php _e('New password', 'qsoft') ?></label>
                            <input type="password" name="pass1" label='Mật khẩu mới' id="pass1" class="demo-form" size="20" value="" autocomplete="off" /></label>
                        </p>
                        <p>
                            <label ><?php _e('Retype new password', 'qsoft') ?></label>
                            <input type="password" name="pass2" label='Nhập lại mật khẩu' id="pass2" class="demo-form" size="20" value="" autocomplete="off" /></label>
                        </p>
                        <?php
                        /**
                         * Fires following the 'Strength indicator' meter in the user password reset form.
                         *
                         * @since 3.9.0
                         *
                         * @param WP_User $user User object of the user whose password is being reset.
                         */
                        do_action('resetpass_form', $user);
                        ?>
                        <p class="submit">
                            <button type="submit" id="wp-submit" name="wp-submit" class="btn-no-full text-uppercase">
                                <?php _e('Submit'); ?> <img class="qsoft_img_loading hidden" src="<?php echo QMUS_PLUGIN_URL ?>/img/loader.gif">
                            </button>
                        </p>
                    </form>
                <?php endif; ?>
                    <a class="link_login" href="<?php echo get_permalink(get_option('qsoft_page_login')) ?>">Click here to login!</a>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
