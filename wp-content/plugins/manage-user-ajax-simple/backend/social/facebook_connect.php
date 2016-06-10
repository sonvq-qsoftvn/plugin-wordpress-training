<?php

function qsoft_facebook_callback() {
    if (get_option('qsoft_facebook_enabled') == 1) {
        $app_id = get_option('qsoft_facebook_app_id');
        $app_secret = get_option('qsoft_facebook_app_secret');
//        $app_id = "141375332706028";
//    $app_secret = "58c881d067612ebe4fd7900db76739ff";
    } else {
        echo 'not enable login facebook';
        exit();
    }


    $redirect_uri = admin_url('admin-ajax.php?action=qsoft_facebook_callback');
// Get code value
    $code = $_GET['code'];
// Get access token info
    $facebook_access_token_uri = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $facebook_access_token_uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

// Get access token
    $access_token = str_replace('access_token=', '', explode("&", $response)[0]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?fields=id,name,first_name,last_name,email&access_token=$access_token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $result = curl_exec($ch);
    curl_close($ch);
    $user = json_decode($result);

    if ($user->email != '') {
        $user_email = $user->email;
        $email_exists = email_exists($user_email);
        if ($email_exists) {
            $user = get_user_by('email', $user_email);
            $user_id = $user->ID;
            $user_name = $user->user_login;
        }
        if (!$user_id && $email_exists == false) {
            $first_name = $user->first_name;

            $last_name = $user->last_name;
            $name = $user->name;
            $user_name = strtolower($first_name . '.' . $last_name);
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
}

add_action('wp_ajax_qsoft_facebook_callback', 'qsoft_facebook_callback');
add_action('wp_ajax_nopriv_qsoft_facebook_callback', 'qsoft_facebook_callback');

function get_data_service($url = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response);
    return $data;
}
