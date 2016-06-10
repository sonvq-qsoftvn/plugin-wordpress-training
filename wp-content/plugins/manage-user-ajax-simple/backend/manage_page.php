<form method="post" action="">
    <?php
    $action = 'remove';
    $text_btn = 'Remove';
    if (get_option('qsoft_generate_page_status', '') != 1) {
        qsoft_insert_page_necessary();
        $action = 'insert';
        $text_btn = 'Create';
        ?>
        <input type="hidden" name="action" value="create">
        <p class="block_auto_create_data"><strong>Auto create all pages QMUS! </strong><button type="submit" value="" class="">Create</button>
            <a class="dismiss" href="#" onclick="qsoft_set_generate_page_status(this)">Dismiss</a>
        </p>
        
        <?php
    }
    ?>
</form>
<form method="post" action="options.php">
    <?php settings_fields('qsoft_set_page_group'); ?>
    <?php
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Pages thankyou</th>
            <td>
                <select name="qsoft_page_thankyou">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_thankyou') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Pages login</th>
            <td>
                <select name="qsoft_page_login">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_login') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Pages register</th>
            <td>
                <select name="qsoft_page_register">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_register') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
                <p>Please enabled user registration (Setting->General->Membership) </p>
            </td>
        </tr>
<!--                <tr valign="top">
            <th scope="row">Pages profile</th>
            <td>
                <select name="qsoft_page_profile">
                    <option>Please choose a page</option>
        <?php
        foreach ($pages as $page):
            $seleacted = get_option('qsoft_page_profile') == $page->ID ? 'selected' : '';
            ?>
                                            <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
        <?php endforeach; ?>
                </select>
            </td>
        </tr>-->

        <tr valign="top">
            <th scope="row">Pages reset password</th>
            <td>
                <select name="qsoft_page_reset_password">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_reset_password') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Pages input new password</th>
            <td>
                <select name="qsoft_page_input_new_password">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_input_new_password') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Pages change password</th>
            <td>
                <select name="qsoft_page_change_password">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_change_password') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Pages logout</th>
            <td>
                <select name="qsoft_page_logout">
                    <option value="">Please choose a page</option>
                    <?php
                    foreach ($pages as $page):
                        $seleacted = get_option('qsoft_page_logout') == $page->ID ? 'selected' : '';
                        ?>
                        <option <?php echo $seleacted ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>