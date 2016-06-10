<form method="post" action="options.php">
    <?php
    settings_fields('qsoft_email_config_group');
    ?>
    <div class="metabox-holder " id="post-body">
        <div class="stuffbox" >
            <div class="inside">
                <table class="optiontable form-table">
                    <tbody><tr valign="top">
                            <th scope="row"><label for="qsoft_mail_from">From Email</label></th>
                            <td><input name="qsoft_mail_from" type="text" id="qsoft_mail_from" value="<?php echo get_option('qsoft_mail_from') ?>" size="40" class="regular-text">
                                <span class="description">You can specify the email address that emails should be sent from. If you leave this blank, the default email will be used.</span></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="qsoft_mail_from_name">From Name</label></th>
                            <td><input name="qsoft_mail_from_name" type="text" id="qsoft_mail_from_name" value="<?php echo get_option('qsoft_mail_from_name') ?>" size="40" class="regular-text">
                                <span class="description">You can specify the name that emails should be sent from. If you leave this blank, the emails will be sent from WordPress.</span></td>
                        </tr>
                    </tbody>
                </table>
                <table class="optiontable form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="qsoft_smtp_host">SMTP Host</label></th>
                            <td><input name="qsoft_smtp_host" type="text" id="qsoft_smtp_host" value="<?php echo get_option('qsoft_smtp_host') ?>" size="40" class="regular-text"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="qsoft_smtp_port">SMTP Port</label></th>
                            <td><input name="qsoft_smtp_port" type="text" id="smtp_port" value="<?php echo get_option('qsoft_smtp_port') ?>" size="6" class="regular-text"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">SMTPSecure </th>
                            <td>
                                <fieldset>
                                    <?php
                                    $arr_smtp_secure = array(
                                        'ssl' => 'Use SSL encryption.',
                                        'tls' => 'Use TLS encryption. This is not the same as STARTTLS. For most servers SSL is the recommended option.'
                                    );
                                    foreach ($arr_smtp_secure as $value => $label):
                                        $select = get_option('qsoft_smtp_ssl') == $value ? 'checked' : '';
                                        ?>
                                        <legend class="screen-reader-text"><span>Encryption</span></legend>

                                        <input id="qsoft_smtp_ssl_<?php echo $value ?>" type="radio" name="qsoft_smtp_ssl" value="<?php echo $value ?>" checked="checked">
                                        <label for="qsoft_smtp_ssl_<?php echo $value ?>"><span><?php echo $label ?></span></label><br>
                                    <?php endforeach; ?>
<!--                                    <input id="qsoft_smtp_ssl_ssl" type="radio" name="qsoft_smtp_ssl" value="ssl">
        <label for="qsoft_smtp_ssl_ssl"><span>Use SSL encryption.</span></label><br>
        <input id="smtp_ssl_tls" type="radio" name="qsoft_smtp_ssl" value="tls">
        <label for="qsoft_smtp_ssl_tls"><span>Use TLS encryption. This is not the same as STARTTLS. For most servers SSL is the recommended option.</span></label>-->
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Authentication </th>
                            <td>
                                <?php
                                $arr_auth = array(
                                    'false' => 'No: Do not use SMTP authentication.',
                                    'true' => 'Yes: Use SMTP authentication.'
                                );
                                foreach ($arr_auth as $value => $label):
                                    $select = get_option('qsoft_smtp_auth') == $value ? 'checked' : '';
                                    ?>
                                    <input id="qsoft_smtp_auth_<?php echo $label ?>" type="radio" name="qsoft_smtp_auth" value="<?php echo $value ?>" <?php echo $select ?>>
                                    <label for="qsoft_smtp_auth_<?php echo $label ?>"><span><?php echo $label ?></span></label><br>
                                <?php endforeach; ?>
                                <span class="description">If this is set to no, the values below are ignored.</span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="qsoft_smtp_user">Username</label></th>
                            <td><input name="qsoft_smtp_user" type="text" id="qsoft_smtp_user" value="<?php echo get_option('qsoft_smtp_user') ?>" size="40" class="code"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="qsoft_smtp_pass">Password</label></th>
                            <td><input name="qsoft_smtp_pass" type="text" id="qsoft_smtp_pass" value="<?php echo get_option('qsoft_smtp_pass') ?>" size="40" class="code"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php submit_button(); ?>
</form>
<form method="POST" action="">
    <div class="metabox-holder " id="post-body">
        <div class="stuffbox" >
            <div class="inside">
                <table class="optiontable form-table">
                    <tbody><tr valign="top">
                            <th scope="row"><label for="to">To:</label></th>
                            <td><input name="qsoft_test_email" type="text" id="to" value="" size="40" class="code">
                                <span class="description">Type an email address here and then click Send Test to generate a test email.</span></td>
                        </tr>
                    </tbody></table>
                <p class="submit"><input type="submit" name="qsoft_test_email_submit" id="qsoft_action" class="button-primary" value="Send Test"></p>
            </div>
        </div>
    </div>
</form>
<?php
if (isset($_POST['qsoft_test_email_submit'])) {
    qsoft_send_email(filter_var($_POST['qsoft_test_email'],FILTER_SANITIZE_EMAIL), 'Test email', 'Hello world!','testemail');
}
?>