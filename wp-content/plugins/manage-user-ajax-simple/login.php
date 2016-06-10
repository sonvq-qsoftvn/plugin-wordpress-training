<?php
// hook failed login
add_action('wp_login_failed', 'qsoft_frontend_login_fail');

function qsoft_frontend_login_fail($username) {
    $referrer = home_url();
    $alert = 'Login fail!';
    if (get_option('qsoft_page_login') != '') {
        $referrer = get_permalink(get_option('qsoft_page_login')) . '?login=failed';
        $alert = '';
    }
//    $referrer = get_option('qsoft_page_login') != '' ? get_permalink(get_option('qsoft_page_login')) . '?login=failed' : home_url();
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        qsoft_redirect($referrer, $alert);
        exit;
    }
}

add_filter('wp_authenticate_user', function($user) {
    if (!is_super_admin($user->ID)) {
        if (get_user_meta($user->ID, 'user_flag', true) == 1) {
            return $user;
        }
        qsoft_redirect(home_url(), 'Account Not Active...');
    }
    return $user;
}, 10, 2);

function qsoft_login_form() {
// only show the registration form to non-logged-in members
    if (!is_user_logged_in()) {
        $output = qsoft_login_form_field();
    } else {
        qsoft_redirect(home_url(), 'You were login!');
    }
    return $output;
}

add_shortcode('qsoft_login_form', 'qsoft_login_form');

function qsoft_login_form_field() {
    ob_start();
    $client_id = '141375332706028';
    $redirect_uri = admin_url('admin-ajax.php?action=qsoft_facebook_callback');
//    $redirect_uri ='http://localhost/Dropbox/wp-admin/admin-ajax.php?action=qsoft_facebook_callback';
    ?>
    <section class="wrap_content loginForm text-center">
        <div class="wrap_logo">
            <h1>Login</h1>
        </div>

        <div class="wrap_form_login">
            <?php
            if (isset($_GET['login']) && filter_var($_REQUEST['login'], FILTER_SANITIZE_STRING) == 'failed') {
                ?>
                <div class="login_fail">
                    <p><?php _e('Login fail! Please try again') ?></p>
                </div>
                <?php
            }
            ?>
            <ul class="portal_validate hidden">
            </ul>

            <form name="loginform" id="loginform" action="<?php echo site_url('/wp-login.php'); ?>" method="post">
                <p class="form_item">
                    <label ><?php _e('Your account', 'qsoft') ?></label>
                    <input id="user_login" autocomplete="off" class="demo-form" type="text"  value="" name="log"></p>
                <p class="form_item">
                    <label ><?php _e('Your password', 'qsoft') ?></label>
                    <input id="user_pass"  autocomplete="off"  class="demo-form" type="password" size="20" value="" name="pwd"></p>
                <p class="clearfix wrap_btn_login">
                    <input id="wp-submit" class="btn-login " type="submit" value="<?php _e('Submit', 'qsoft') ?>" name="wp-submit">
                </p>
                <p class="clearfix">
                    <span class="pull-left">
                        <input id="checkbox1" class="css-checkbox"  type="checkbox" value="1" name="remember_me"> 
                        <label for="checkbox1" name="checkbox_remember" class="css-label lite-green-check"><?php _e('Remember password', 'qsoft') ?></label>
                    </span>
                    <a href="<?php echo get_permalink(get_option('qsoft_page_reset_password')) ?>" class="pull-right forgot_pass_link"><?php _e('fogot password', 'qsoft') ?></a>
                </p>
                <?php
                $redirect = (get_option('qsoft_redirect_login_success')) != '' ? get_permalink(get_option('qsoft_redirect_login_success')) : home_url();
                ?>
                <input type="hidden" value="<?php echo $redirect; ?>" name="redirect_to">
                <input type="hidden" value="1" name="testcookie">
            </form>
            <div class="qsoft_wrap_social">
                <?php
                if (get_option('qsoft_facebook_enabled') == 1):
                    ?>
                    <a href="https://www.facebook.com/dialog/oauth?client_id=<?php echo $client_id ?>&redirect_uri=<?php echo $redirect_uri ?>" 
                       class="q_btn q_btn_facebook">
                        Login facebook
                    </a>
                <?php endif ?>
                <?php
                if (get_option('qsoft_google_enabled') == 1):
                    global $q_google_client;
                    ?>
                    &nbsp;
                    <a href="<?php echo $authUrl = $q_google_client->createAuthUrl(); ?>" 
                       class="q_btn q_btn_google">
                        Login google
                    </a>
                <?php endif ?>
            </div>
        </div>
        <div class="home_direct"><a href="<?php echo get_site_url() ?>"><?php _e('Return home', 'qsoft') ?></a></div>
    </section>
    <?php
    return ob_get_clean();
}
