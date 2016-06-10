<form method="post" action="options.php">
    <?php settings_fields('qsoft_redirect_group'); ?>
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
    <table class="form-table">
        <tr valign="top">
            <th scope="row">After login success</th>
            <td>
                <?php  qsoft_generate_select($data_option,'qsoft_redirect_login_success')?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">After logout</th>
            <td>
                <?php qsoft_generate_select($data_option, 'qsoft_redirect_logout') ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">After active account</th>
            <td>
               <?php  qsoft_generate_select($data_option,'qsoft_redirect_active_account')?>
            </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>