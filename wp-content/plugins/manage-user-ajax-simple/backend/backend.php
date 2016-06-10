<?php

function qsoft_register_mysettings() {
    //setting page
    $arr_all_seting_group = array(
        'qsoft_page_thankyou',
        'qsoft_page_register',
        'qsoft_page_reset_password',
        'qsoft_page_input_new_password',
        'qsoft_page_change_password',
        'qsoft_page_login',
        'qsoft_page_profile',
        'qsoft_page_logout',
        //field
        'qsoft_fields',
    );

    foreach ($arr_all_seting_group as $arr_single_seting_group) {
        register_setting('qsoft_set_page_group', $arr_single_seting_group);
    }
    //redirect
    $arr_all_redirect_group = array(
        'qsoft_redirect_login_success',
        'qsoft_redirect_active_account',
        'qsoft_redirect_logout',
    );
    foreach ($arr_all_redirect_group as $arr_single_redirect_group) {
        register_setting('qsoft_redirect_group', $arr_single_redirect_group);
    }
    //mail template
    $arr_all_mail_template = array(
        //mail template
        'qsoft_active_account_send_to',
        'qsoft_active_account_send_from',
        'qsoft_active_account_name',
        'qsoft_active_account_mail_subject',
        'qsoft_active_account_mail_content',
        //mail forgot
        'qsoft_forgot_password_send_to',
        'qsoft_forgot_password_send_from',
        'qsoft_forgot_password_name',
        'qsoft_forgot_password_mail_subject',
        'qsoft_forgot_password_mail_content',
        //mail change
        'qsoft_change_password_send_to',
        'qsoft_change_password_send_from',
        'qsoft_change_password_name',
        'qsoft_change_password_mail_subject',
        'qsoft_change_password_mail_content'
    );
    foreach ($arr_all_mail_template as $arr_single_mail_template) {
        register_setting('qsoft_mail_template_group', $arr_single_mail_template);
    }
    //social
    $arr_all_social = array(
        'qsoft_facebook_enabled',
        'qsoft_facebook_app_id',
        'qsoft_facebook_app_secret',
        'qsoft_google_enabled',
        'qsoft_google_app_id',
        'qsoft_google_app_secret',
    );
    foreach ($arr_all_social as $social) {
        register_setting('qsoft_social_group', $social);
    }
    //email config
    $arr_all_email_config = array(
        'qsoft_mail_from',
        'qsoft_mail_from_name',
        'qsoft_smtp_host',
        'qsoft_smtp_port',
        'qsoft_smtp_ssl',
        'qsoft_smtp_auth',
        'qsoft_smtp_user',
        'qsoft_smtp_pass'
    );
    foreach ($arr_all_email_config as $email_config) {
        register_setting('qsoft_email_config_group', $email_config);
    }
}

function qsoft_create_menu() {
    add_menu_page('QMUS', 'User Template ', 'administrator', 'qsoft_settings_page', 'qsoft_settings_page', '', 90);
//    add_submenu_page(
//            'qsoft_settings_page', 'QMUS Manage field', 'Manage field', 'manage_options', 'qsoft_manage_field', 'qsoft_manage_field'
//    );
    add_action('admin_init', 'qsoft_register_mysettings');
//    add_submenu_page('qsoft_settings_page', __('Email Config'), __('Email Config'), 'manage_options', 'wp_mail_smtp_options_page','wp_mail_smtp_options_page');
}

add_action('admin_menu', 'qsoft_create_menu');

/**
 * 
 * @param type $data_option
 * @param type $name
 */
function qsoft_generate_select($data_option, $name = 'qsoft_name') {
    ?>
    <select name="<?php echo $name ?>">
        <option>Please choose a page</option>
        <?php
        foreach ($data_option as $page):
            $seleacted = get_option($name) == $page->ID ? 'selected' : '';
            ?>
            <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * 
 * @param type $name
 * @param type $type
 */
function qsoft_generate_field_email($name = '', $type = 'text', $default = '') {
    $value = get_option($name) != '' ? get_option($name) : $default;
    if ($type == 'textarea'):
        ?>
        <textarea id="<?php echo $name ?>" name="<?php echo $name ?>" rows="10"><?php echo $value ?></textarea>
        <?php
        return;
    endif;
    ?>
    <input type="<?php echo $type ?>" id="<?php echo $name ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" />
    <?php
}

function qsoft_insert_page_necessary() {
    if (isset($_POST['action'])) {
        if (filter_var($_POST['action'], FILTER_SANITIZE_STRING) == 'create') {
            if (!qsoft_get_page_by_slug('q_user')) {
                $page_user = array(
                    'post_type' => 'page',
                    'post_name' => 'q_user',
                    'post_title' => 'User',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_registration_form]',
                    'post_parent' => '0'
                );
                $manage_user_id = wp_insert_post($page_user);
                update_option('qsoft_page_register', $manage_user_id);
            }
            if (!qsoft_get_page_by_slug('q_change_password')) {
                $q_change_password = array(
                    'post_type' => 'page',
                    'post_name' => 'q_change_password',
                    'post_title' => 'Change password',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_change_password_form]',
                    'post_parent' => '0'
                );
                $q_change_password_id = wp_insert_post($q_change_password);
                update_option('qsoft_page_change_password', $q_change_password_id);
            }
            if (!qsoft_get_page_by_slug('q_reset_password')) {
                $q_reset_password = array(
                    'post_type' => 'page',
                    'post_name' => 'q_reset_password',
                    'post_title' => 'Reset passwordd',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_reset_password_form]',
                    'post_parent' => '0'
                );
                $q_reset_password_id = wp_insert_post($q_reset_password);
                update_option('qsoft_page_reset_password', $q_reset_password_id);
            }
            if (!qsoft_get_page_by_slug('q_input_new_password')) {
                $q_input_new_password = array(
                    'post_type' => 'page',
                    'post_name' => 'q_input_new_password',
                    'post_title' => 'Input new password',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_input_new_password_form]',
                    'post_parent' => '0'
                );
                $q_input_new_password_id = wp_insert_post($q_input_new_password);
                update_option('qsoft_page_input_new_password', $q_input_new_password_id);
            }
            if (!qsoft_get_page_by_slug('q_login')) {
                $q_login = array(
                    'post_type' => 'page',
                    'post_name' => 'q_login',
                    'post_title' => 'Login',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_login_form]',
                    'post_parent' => '0'
                );
                $q_login_id = wp_insert_post($q_login);
                update_option('qsoft_page_login', $q_login_id);
                update_option('qsoft_redirect_active_account', $q_login_id);
            }
            if (!qsoft_get_page_by_slug('q_thankyou')) {
                $q_thankyou = array(
                    'post_type' => 'page',
                    'post_name' => 'q_thankyou',
                    'post_title' => 'Thank you',
                    'post_status' => 'publish',
                    'post_content' => 'Success!',
                    'post_parent' => '0'
                );
                $q_thankyou_id = wp_insert_post($q_thankyou);
                update_option('qsoft_page_thankyou', $q_thankyou_id);
                update_option('qsoft_redirect_login_success', $q_thankyou_id);
            }
            if (!qsoft_get_page_by_slug('q_logout')) {
                $q_logout = array(
                    'post_type' => 'page',
                    'post_name' => 'q_logout',
                    'post_title' => 'Logout',
                    'post_status' => 'publish',
                    'post_content' => '[qsoft_logout]',
                    'post_parent' => '0'
                );
                $q_logout_id = wp_insert_post($q_logout);
                update_option('qsoft_page_logout', $q_logout_id);
                update_option('qsoft_redirect_logout', $q_logout_id);
            }
            update_option('qsoft_generate_page_status', '1', '', 'yes');
        }
    }
}

function qsoft_settings_page() {
//    update_option('qsoft_generate_page_status', '0', '', 'yes');
    ?>
    <div class="wrap">
        <h2><?php _e('Setting general') ?></h2>
        <?php if (isset($_GET['settings-updated'])) { ?>
            <div id="message" class="updated">
                <p><strong><?php _e('Settings saved.') ?></strong></p>
            </div>
        <?php } ?>
        <?php if (isset($_POST['action']) && filter_var($_POST['action'], FILTER_SANITIZE_STRING) == 'create') { ?>
            <div id="message" class="updated">
                <p><strong><?php _e('Create pages success') ?></strong></p>
            </div>
        <?php } ?>

        <?php
        $active_tab = 'set_page';
        if (isset($_GET['tab'])) {
            $active_tab = filter_var($_GET['tab'], FILTER_SANITIZE_STRING);
        }
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_page') ?>" class="nav-tab <?php echo $active_tab == 'set_page' ? 'nav-tab-active' : ''; ?>">Set page</a>
             <a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_field') ?>" class="nav-tab <?php echo $active_tab == 'set_field' ? 'nav-tab-active' : ''; ?>">Set Field</a>
            <a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_redirect') ?>" class="nav-tab <?php echo $active_tab == 'set_redirect' ? 'nav-tab-active' : ''; ?>">Set redirect</a>
            <a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_email') ?>" class="nav-tab <?php echo $active_tab == 'set_email' ? 'nav-tab-active' : ''; ?>">Set email template</a>
            <a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_social') ?>" class="nav-tab <?php echo $active_tab == 'set_social' ? 'nav-tab-active' : ''; ?>">Set Social</a>
            <!--<a href="<?php echo admin_url('/?page=qsoft_settings_page&tab=set_email_config') ?>" class="nav-tab <?php echo $active_tab == 'set_email_config' ? 'nav-tab-active' : ''; ?>">Email config</a>-->
        </h2>
        <div class="qsoft_tab_content">
            <?php
            switch ($active_tab):
                case 'set_page':
                    require_once 'manage_page.php';
                    break;
                case 'set_field':
                    require_once 'manage_field.php';
                    break;
                case 'set_redirect':
                    require_once 'manage_redirect.php';
                    break;
                case 'set_email':
                    require_once 'manage_email_template.php';
                    break;
                case 'set_social':
                    include_once 'social/social_setting.php';
                    break;
                case 'set_email_config':
                    include_once 'wp_mail_smtp.php';
            endswitch;
            ?>
        </div>
        <!--sidebar-->
        <div class="qsoft_sidebar">
            <div class="postbox">
                <div class="inside">
                    <h3>Welcome to Manage user ajax simple</h3>

                    <div style="padding:0 20px;">
                        <p style="padding:0;margin:12px 0;">
                            The plugin allows users to create user forms via shortcode in the simpliest way.

                        </p>
                        <p>
                        <ul>
                            <li>login: [qsoft_login_form] </li>
                            <li>reset password: [qsoft_reset_password_form] </li>
                            <li>Input new password: [qsoft_input_new_password_form] </li>
                            <li>Change password: [qsoft_change_password_form] </li>
                            <li>Register and manage user: [qsoft_registration_form]</li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="postbox">
                <div class="inside">
                    <h3>Use dynamic data to fill the content email</h3>

                    <div style="padding:0 20px;">
                        <p style="padding:0;margin:12px 0;">
                            [user_login] [website] [link_forgot_password] [link_active]
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

//change status
function qsoft_change_status_user() {
    $user_id = isset($_REQUEST['user_id']) ? filter_var($_REQUEST['user_id'], FILTER_SANITIZE_NUMBER_INT) : '';
    $status = isset($_REQUEST['status']) ? filter_var($_REQUEST['status'], FILTER_SANITIZE_STRING) : '';
    update_user_meta($user_id, 'user_flag', $status);
    exit();
}

add_action('wp_ajax_change_status_user', 'qsoft_change_status_user');
add_action('wp_ajax_nopriv_change_status_user', 'qsoft_change_status_user');

//add column status

function qsoft_status_user_table($column) {
    $column['col_user_flag'] = 'Trạng thái';
    return $column;
}

add_filter('manage_users_columns', 'qsoft_status_user_table');

function qsoft_change_status_users_table_row($val, $column_name, $user_id) {
    $user = get_userdata($user_id);
    $status = get_user_meta($user_id, 'user_flag', true);
    $is_check = $status == 1 ? 'checked' : '';
    switch ($column_name) {
        case 'col_user_flag' :
//            $status = '<a href="users.php?page=my-events&user_id=' . $user->ID . '">Booking history</a>';
            $status_check = '<input onchange="change_status(this)" type="checkbox" ' . $is_check . ' id="' . $user->ID . '">';
            return $status_check;
            break;

        default:
    }

//    return $return;
}

add_filter('manage_users_custom_column', 'qsoft_change_status_users_table_row', 10, 3);

function qsoft_get_page_by_slug($slug) {
    if ($pages = get_pages())
        foreach ($pages as $page)
            if ($slug === $page->post_name)
                return $page;
    return false;
}

function qsoft_set_generate_page_status() {
    update_option('qsoft_generate_page_status', '1', '', 'yes');
}

add_action('wp_ajax_qsoft_set_generate_page_status', 'qsoft_set_generate_page_status');
add_action('wp_ajax_nopriv_qsoft_set_generate_page_status', 'qsoft_set_generate_page_status');

function check_exist_field($field_name) {
    $arr_all_field = get_option('qsoft_fields');
    foreach ($arr_all_field as $key => $arr_single_field) {
        if ($field_name == $arr_single_field['field_name']) {
            return true;
        }
    }
    return FALSE;
}

function qsoft_delete_field() {
    if (isset($_REQUEST['field_name'])):
        $field_name = filter_var($_REQUEST['field_name'], FILTER_SANITIZE_STRING);

        $arr_all_field = get_option('qsoft_fields');
        foreach ($arr_all_field as $key => $arr_single_field) {
            if ($field_name == $arr_single_field['field_name']) {
                unset($arr_all_field[$key]);
            }
        }
        update_option('qsoft_fields', $arr_all_field);
        $return = array(
            'status' => true,
            'message' => 'success'
        );
//                var_dump($arr_all_field);
    else:
        $return = array(
            'status' => false,
            'message' => 'you must include field_name in request'
        );
    endif;
    echo json_encode($return);
    exit();
}

add_action('wp_ajax_qsoft_delete_field', 'qsoft_delete_field');
add_action('wp_ajax_nopriv_qsoft_delete_field', 'qsoft_delete_field');

function qsoft_edit_field() {
    if (isset($_REQUEST['field_name'])):
        $field_name = filter_var($_REQUEST['field_name'], FILTER_SANITIZE_STRING);

        $arr_all_field = get_option('qsoft_fields');
        foreach ($arr_all_field as $key => $arr_single_field) {
            if ($field_name == $arr_single_field['field_name']) {
                $return = array(
                    'status' => true,
                    'message' => 'success',
                    'data' => $arr_single_field
                );
                break;
            }
        }
    else:
        $return = array(
            'status' => false,
            'message' => 'you must include field_name in request'
        );
    endif;
    echo json_encode($return);
    exit();
}

add_action('wp_ajax_qsoft_edit_field', 'qsoft_edit_field');
add_action('wp_ajax_nopriv_qsoft_edit_field', 'qsoft_edit_field');
