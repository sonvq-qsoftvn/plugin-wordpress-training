<?php

function qsoft_google_callback() {
    global $q_google_client, $google_oauthV2;

    if (isset($_REQUEST['code'])) {
        $q_google_client->authenticate();
        $access_token = $q_google_client->getAccessToken();
        $q_google_client->setAccessToken($access_token);
        if ($q_google_client->getAccessToken()) {
            $user = $google_oauthV2->userinfo->get();
            $user = (object) $user;
            if ($user->email != '') {
                $user_email = $user->email;
                $email_exists = email_exists($user_email);
                if ($email_exists) {
                    $user = get_user_by('email', $user_email);
                    $user_id = $user->ID;
                    $user_name = $user->user_login;
                }
                if (!$user_id && $email_exists == false) {
                    $first_name = $user->given_name;
                    $last_name = $user->family_name;
                    $name = $user->name;
                    $user_name = strtolower(str_replace(' ', '_', $name));
                    while (username_exists($user_name)) {
                        $i++;
                        $user_name = $user_name . '.' . $i;
                    }
                    $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                    $userdata = array(
                        'user_login' => $user_name,
                        'user_email' => $user_email,
                        'user_pass' => $random_password,
                        'display_name' => $name,
                        'first_name' => $first_name,
                        'last_name' => $last_name
                    );

                    $user_id = wp_insert_user($userdata);
                    $arr_avartar = array(
                        'full' => "http://graph.facebook.com/" . $user->id . "/picture?width=500&height=500",
                        '96' => "http://graph.facebook.com/" . $user->id . "/picture?width=96&height=96"
                    );
                    update_user_meta($user_id, 'user_flag', 1);
                    update_user_meta($user_id, 'simple_local_avatar', $arr_avartar);
                    if ($user_id)
                        $user_account = 'user registered.';
                } else {
                    if ($user_id)
                        $user_account = 'user logged in.';
                }
            }
            if ($user_id) {
                wp_set_auth_cookie($user_id);
                $link_ridirect = get_option('qsoft_redirect_login_success') != '' ? get_permalink(get_option('qsoft_redirect_login_success')) : home_url();
                qsoft_redirect($link_ridirect);
            }
        } else {
            echo 'not connect to google!';
        }
    }

//DB Insert
}

add_action('wp_ajax_qsoft_google_callback', 'qsoft_google_callback');
add_action('wp_ajax_nopriv_qsoft_google_callback', 'qsoft_google_callback');
