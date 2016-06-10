<?php

function qsoft_logout() {
    wp_logout();
    $link= get_option('qsoft_redirect_logout') != '' ? get_permalink('qsoft_redirect_logout') : home_url();
    qsoft_redirect($link);
}

add_shortcode('qsoft_logout', 'qsoft_logout');

