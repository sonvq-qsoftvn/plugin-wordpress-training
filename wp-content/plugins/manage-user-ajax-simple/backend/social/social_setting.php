<form method="post" action="options.php">
    <?php
    settings_fields('qsoft_social_group');
    $arr_select_enable = array(
        1 => 'Yes',
        0 => 'No'
    );
    ?>
    <div class="metabox-holder " id="post-body">
        <div class="stuffbox" id="namediv">
            <h3>
                <label class="wp-neworks-label">
                    <img alt="Facebook" title="Facebook" src="<?php echo QMUS_PLUGIN_URL ?>/img/facebook.png" style="vertical-align: top;width:16px;height:16px;"> Facebook				</label>
            </h3>
            <div class="inside">
                <table class="form-table editcomment">
                    <tbody>
                        <tr>
                            <td style="width:125px">Enabled:</td>
                            <td>
                                <select name="qsoft_facebook_enabled" id="qsoft_facebook_enabled" onchange="toggleproviderkeys('facebook')">
                                    <?php
                                    foreach ($arr_select_enable as $val => $label):
                                        $selected = get_option('qsoft_facebook_enabled') == $val ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $val ?>" <?php echo $selected ?>><?php echo $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="width:160px">&nbsp;</td>
                        </tr>

                        <tr valign="top" class="qsoft_facebook">
                            <td>Application ID:</td>
                            <td><input dir="ltr" type="text" name="qsoft_facebook_app_id" value="<?php echo get_option('qsoft_facebook_app_id') ?>"></td>
                            <td><a href="javascript:void(0)" onclick="toggleproviderhelp('facebook')">Where do I get this info?</a></td>
                        </tr>

                        <tr valign="top" class="qsoft_facebook">
                            <td>Application Secret:</td>
                            <td><input dir="ltr" type="text" name="qsoft_facebook_app_secret" value="<?php echo get_option('qsoft_facebook_app_secret') ?>"></td>
                            <td><a href="javascript:void(0)" onclick="toggleproviderhelp('facebook')">Where do I get this info?</a></td>
                        </tr>

                    </tbody>
                </table>


                <br>
                <div class="qsoft_help_facebook" style="display:none;">
                    <hr class="wsl">
                    <span style="color:#CB4B16;">Application</span> id and secret (also sometimes referred as <span style="color:#CB4B16;">Consumer</span> key and secret or <span style="color:#CB4B16;">Client</span> id and secret) are what we call an application credentials.

                    This application will link your website <code><?php echo $_SERVER['HTTP_HOST'] ?></code> to <code>Facebook API</code> and these credentials are needed in order for <b>Facebook</b> users to access your website.
                    <br>

                    These credentials may also differ in format, name and content depending on the social network.						<br>
                    <br>

                    To enable authentication with this provider and to register a new <b>Facebook API Application</b>, follow the steps						:<br>
                    <div style="margin-left:40px;">
                        <p><b>1</b>. First go to: <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a></p>

                        <p><b>2</b>. Select <b>Add a New App</b> from the <b>Apps</b> menu at the top.</p>
                        <p><b>3</b>. Fill out Display Name, Namespace, choose a category and click <b>Create App</b>.</p>
                        <p><b>4</b>. Go to Settings page and click on <b>Add Platform</b>. Choose website and enter in the new screen your website url in <b>App Domains</b> and <b>Site URL</b> fields.
                            They should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST'] ?></em>.</p>
                        <p><b>5</b>. Go to the <b>Status &amp; Review</b> page and choose <b>yes</b> where it says <b>Do you want to make this app and all its live features available to the general public?</b>.</p>

                        <p><b>6</b>. Go back to the <b>Dashboard</b> page and past the created application credentials (APP ID and Secret) into the boxes above.</p>

                        <div class="wrap_img_social">
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/1.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/1.png"></a></td>
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/2.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/2.png"></a></td>
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/3.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/3.png"></a>
                        </div>
                    </div>

                    <hr>
                    <p>
                        <b>And that's it!</b>
                        <br>
                        If for some reason you still can't manage to create an application for Facebook, first try to <a href="https://www.google.com/search?q=Facebook API create application" target="_blank">Google it</a>, 
                        then check it on <a href="http://www.youtube.com/results?search_query=Facebook API create application " target="_blank">Youtube</a>
                    </p>

                </div>
            </div>
        </div>
        <div class="stuffbox" id="namediv" >
            <h3>
                <label class="wp-neworks-label">
                    <img alt="google" title="google" src="<?php echo QMUS_PLUGIN_URL ?>/img/google.png" style="vertical-align: top;width:16px;height:16px;"> google				</label>
            </h3>
            <div class="inside">
                <table class="form-table editcomment">
                    <tbody>
                        <tr>
                            <td style="width:125px">Enabled:</td>
                            <td>
                                <select name="qsoft_google_enabled" id="qsoft_google_enabled" onchange="toggleproviderkeys('google')">
                                    <?php
//                                                                        var_dump(get_option('qsoft_google_enabled'));
                                    foreach ($arr_select_enable as $val => $label):
                                        $selected = get_option('qsoft_google_enabled') == $val ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $val ?>" <?php echo $selected ?>><?php echo $label ?></option>
                                    <?php endforeach; ?>
                                    <!--                                    <option value="1" selected="">Yes</option>
                                                                        <option value="0">No</option>-->
                                </select>
                            </td>
                            <td style="width:160px">&nbsp;</td>
                        </tr>

                        <tr valign="top" class="qsoft_google">
                            <td>Application ID:</td>
                            <td><input dir="ltr" type="text" name="qsoft_google_app_id" value="1040137721024-8msvqqhsdg73lh8i72vs6nrpeghfc0uf.apps.googleusercontent.com"></td>
                            <td><a href="javascript:void(0)" onclick="toggleproviderhelp('google')">Where do I get this info?</a></td>
                        </tr>

                        <tr valign="top" class="qsoft_google">
                            <td>Application Secret:</td>
                            <td><input dir="ltr" type="text" name="qsoft_google_app_secret" value="2xCfpoF5YNyNdREMve6UVUHo"></td>
                            <td><a href="javascript:void(0)" onclick="toggleproviderhelp('google')">Where do I get this info?</a></td>
                        </tr>

                    </tbody>
                </table>


                <br>
                <div class="qsoft_help_google" style="display:none;">
                    <hr class="wsl">
                    <span style="color:#CB4B16;">Application</span> id and secret (also sometimes referred as <span style="color:#CB4B16;">Consumer</span> key and secret or <span style="color:#CB4B16;">Client</span> id and secret) are what we call an application credentials.

                    This application will link your website <code><?php echo $_SERVER['HTTP_HOST'] ?></code> to <code>Google API</code> and these credentials are needed in order for <b>Google</b> users to access your website.
                    <br>

                    These credentials may also differ in format, name and content depending on the social network.						<br>
                    <br>

                    To enable authentication with this provider and to register a new <b>Google API Application</b>, follow the steps						:<br>
                    <div style="margin-left:40px;">
                        <p><b>1</b>. First go to: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a></p>

                        <p><b>2</b>. On the <b>Dashboard sidebar</b> click on <b>Project</b> then click <em style="color:#0147bb;">“Create Project”</em>.</p>
                        <p><b>3</b>. Once the project is created. Select that project, then <b>APIs &amp; auth</b> &gt; <b>Consent screen</b> and fill the required information.</p>
                        <p><b>4</b>. Then <b>APIs &amp; auth</b> &gt; <b>APIs</b> and enable <em style="color:#0147bb;">“Google+ API”</em>. If you want to import the user contatcs enable <em style="color:#0147bb;">“Contacts API”</em> as well.</p>
                        <p><b>5</b>. After that you will need to create an new application: <b>APIs &amp; auth</b> &gt; <b>Credentials</b> and then click <em style="color:#0147bb;">“Create new Client ID”</em>.</p>
                        <p></p>
                        <p><b>6</b>. On the <b>“Create Client ID”</b> popup :</p>
                        <ul style="margin-left:35px">
                            <li>Select <em style="color:#0147bb;">“Web application”</em> as your application type.</li>
                            <li>Put your website domain in the <b>Authorized JavaScript origins</b> field. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST'] ?></em>.</li>
                            <li>Provide this URL as the <b>Authorized redirect URI</b> for your application: <br><span style="color:green">http://192.168.2.87/ebs570/wp-content/plugins/wordpress-social-login/hybridauth/?hauth.done=Google</span></li>
                        </ul>




                        <p><b>7</b>. Once you have registered past the created application credentials (Client ID and Secret) into the boxes above.</p>
                        <div class="wrap_img_social">
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/4.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/4.png"></a>
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/5.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/5.png"></a>
                            <a class="span4 thumbnail" href="<?php echo QMUS_PLUGIN_URL ?>/img/6.png" target="_blank">
                                <img src="<?php echo QMUS_PLUGIN_URL ?>/img/6.png"></a>
                        </div>

                    </div>

                    <hr>
                    <p>
                        <b>And that's it!</b>
                        <br>
                        If for some reason you still can't manage to create an application for Google, first try to <a href="https://www.google.com/search?q=Google API create application" target="_blank">Google it</a>, then check it on <a href="http://www.youtube.com/results?search_query=Google API create application " target="_blank">Youtube</a>, and if nothing works <a href="options-general.php?page=wordpress-social-login&amp;wslp=help">ask for support</a>.
                    </p>
                </div>
            </div>
        </div>
        <script>
<?php if (get_option('qsoft_facebook_enabled') != 1): ?>
                jQuery('.qsoft_facebook').hide();
<?php endif; ?>
<?php if (get_option('qsoft_google_enabled') != 1): ?>
                jQuery('.qsoft_google').hide();
<?php endif; ?>
            function toggleproviderkeys(idp) {
                if (typeof jQuery == "undefined") {
                    alert("Error:  require jQuery to be installed on your wordpress in order to work!");
                    return;
                }
                if (jQuery('#qsoft_' + idp + '_enabled').val() == 1) {
                    jQuery('.qsoft_' + idp).show();
                }
                else {
                    jQuery('.qsoft_' + idp).hide();
                    jQuery('.wsl_div_settings_help_' + idp).hide();
                }
                return false;
            }

            function toggleproviderhelp(idp) {
                if (typeof jQuery == "undefined") {
                    alert("Error:  require jQuery to be installed on your wordpress in order to work!");
                    return false;
                }
                console.log(jQuery('.qsoft_help_' + idp));
                jQuery('.qsoft_help_' + idp).toggle();
                return false;
            }
        </script>

    </div>

    <?php submit_button(); ?>
</form>