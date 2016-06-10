<form method="post" action="options.php" class="mail_config">
    <?php settings_fields('qsoft_mail_template_group'); ?>
    <?php
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $data_option = get_pages($args);
    ?>
    <h3>Email template active account</h3>
    <table boder="0" id="">
        <tr>
            <th><label for="qsoft_active_account_send_from">From: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_active_account_send_from', 'text', 'ump@gmail.com') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_active_account_name">Name: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_active_account_name', 'text', 'ump') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_active_account_mail_subject">Subject: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_active_account_mail_subject', 'text', 'Register new user') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_active_account_mail_content">Content: </label></th>
            <td>
                <?php echo qsoft_generate_field_email('qsoft_active_account_mail_content', 'textarea', 'Dear [user_login] !
Someone register account on the site [website]
User name: [user_login]
If this is an error, please ignore this email
To active your account, please click on the following link:
[link_active]


*** This is an automatically generated email, please do not reply ***
') ?>
            </td>
        </tr>
    </table>
    <hr/>
    <h3>Email template forgot password</h3>
    <table boder="0" id="">
        <tr>
            <th><label for="qsoft_forgot_password_send_from">From: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_forgot_password_send_from', 'text', 'ump@gmail.com') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_forgot_password_name">Name: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_forgot_password_name', 'text', 'ump') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_forgot_password_mail_subject">Subject: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_forgot_password_mail_subject', 'text', 'Forgot password') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_forgot_password_mail_content">Content: </label></th>
            <td>
                <?php echo qsoft_generate_field_email('qsoft_forgot_password_mail_content', 'textarea', 'Dear [user_login] !
Someone has requested a password reset for your account on the site:
User name: [user_login]
If this is an error, please ignore this email; Your account information will remain unchanged
To reset your password, please click on the following link:
[link_forgot_password]



*** This is an automatically generated email, please do not reply ***
') ?>
            </td>
        </tr>
    </table>
    <hr/>
    <h3>Email change password</h3>
    <table boder="0" id="">
        <tr>
            <th><label for="qsoft_change_password_send_from">From: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_change_password_send_from', 'text', 'ump@gmail.com') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_change_password_name">Name: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_change_password_name', 'text', 'ump') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_change_password_mail_subject">Subject: </label></th>
            <td><?php echo qsoft_generate_field_email('qsoft_change_password_mail_subject', 'text', 'Forgot password') ?></td>
        </tr>
        <tr>
            <th><label for="qsoft_change_password_mail_content">Content: </label></th>
            <td>
                <?php
                echo qsoft_generate_field_email('qsoft_change_password_mail_content', 'textarea', 'Dear [user_login] !
This message confirms that your password has been changed.
User name: [user_login]
If you do not change your password, please contact the system administrator via email: ' . get_option('admin_email') . '
Respect
Website: ' . network_site_url() . '
    
    
*** This is an automatically generated email, please do not reply ***
    '
                );
                ?>
            </td>
        </tr>
    </table>
<?php submit_button(); ?>
</form>

<div class="qsoft_guide">
    <h3>Use dynamic data to fill the content</h3>
    <p> [user_login]  [website] [link_forgot_password] [link_active]
</p>
</div>