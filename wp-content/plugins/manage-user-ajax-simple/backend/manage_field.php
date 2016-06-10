<?php

//function qsoft_manage_field() {
    ?>
    <div class="metabox-holder">

        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class="title">Manage Fields</h3>
                    <div class="inside">
                        <table class="widefat" id="qsoft-fields">
                            <thead><tr class="head" style="cursor: move;">
                                    <th scope="col">Field Label</th>
                                    <th scope="col">Option Name</th>
                                    <th scope="col">Field Type</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Action</th>
                                </tr></thead>
                            <tbody>
                                <?php
//                                    if(get_option('qsoft_fields') == ''){
//                                        
//                                    }
                                $arr_all_field = get_option('qsoft_fields');
                                if ($arr_all_field == ''):
                                    ?>
                                    <tr>
                                        <td>Not add field!</td>
                                    </tr>
                                    <?php
                                else:
                                    foreach ($arr_all_field as $arr_single_field):
//                                        var_dump($arr_single_field['field_require']);
                                        $is_require = '';
                                        $is_checked = '';
                                        if ($arr_single_field['field_required'] == 1) {
                                            $is_require = '<font color="red">*</font>';
                                            $is_checked = 'checked="checked"';
                                        }
                                        ?>
                                        <tr class="alternate" valign="top" id="3" style="cursor: move;">
                                            <td width="15%"><?php echo $arr_single_field['field_label'] ?> <?php echo $is_require ?> </td>
                                            <td width="15%"><?php echo $arr_single_field['field_name'] ?></td>
                                            <td width="10%"><?php echo $arr_single_field['field_type'] ?></td>
                                            <td width="10%"><?php echo $arr_single_field['field_order'] ?></td>
                                            <td width="10%">
                                                <a href="" class="button" onclick="qsoft_edit_field(event, '<?php echo $arr_single_field['field_name'] ?>', this)">Edit</a> &nbsp;
                                                <a href="" class="button" onclick="qsoft_delete_field(event, '<?php echo $arr_single_field['field_name'] ?>', this)">Delete</a>
                                            </td>

                                        </tr>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody></table><br>
    <!--                            <input type="hidden" name="qsoft_admin_a" value="update_fields">
                        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Update Fields"></p>			</form>-->
                    </div><!-- .inside -->
                </div>	
                <div class="postbox">
                    <h3 class="title">Add a Field</h3>
                    <div class="inside">
                        <form method="post" action="" class="form_manage_field">
                            <div class="show_message"></div>
                            <?php // settings_fields('qsoft-settings-group'); ?>	
                            <table  class="widefat">
                                <tr>
                                    <td>
                                        <label for="qsoft_field_name">Field Name</label><br>
                                        <input type="text" name="field_name" id="qsoft_field_name" value="">
                                        <br>The database meta value for the field. It must be unique and contain no spaces (underscores are ok).
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <label for="qsoft_field_label">Field Label</label><br>
                                        <input type="text" name="field_label" id="qsoft_field_label" value="">
                                        <br>The name of the field as it will be displayed to the user.			
                                    </td>
                                </tr>

                                <tr class="border_bottom">
                                    <td>
                                        <div class="wrap_field_type">
                                            <p>Choose field type</p>
                                            <select name="field_type" id="qsoft_field_type_select" onchange="qsoft_field_type_onchange(this)">
                                                <option value="text">text</option>
                                                <option value="email">email</option>
                                                <option value="textarea">textarea</option>
                                                <option value="checkbox">checkbox</option>
                                                <option value="select">select (dropdown)</option>
                                                <option value="radio">radio</option>
                                                <option value="password">password</option>
                                                <option value="url">url</option>
                                                <option value="hidden">hidden</option>
                                            </select>
                                        </div>
                                        <!--<div class="view_next">=></div>-->
                                        <div id="qsoft_dropdown_option" >
                                             <p>Create option(Value|Label|default)</p>
                                            <div class="list_field_option">
                                                <p>
                                                    <input type="text" name="field_option_data[]">
                                                    <a href="" class="button" onclick="qsoft_remove_option(event, this)">Remove</a>
                                                </p>
                                            </div>
                                            <button type="button" onclick="q_add_option()">Add option</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="qsoft_field_order">Order</label><br>
                                        <input type="number" name="field_order" id="qsoft_field_order" value="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td> <label for="qsoft_field_required">Required?</label>
                                        <input type="checkbox" name="field_required" id="qsoft_field_required" value="1"></td>
                                </tr>
                                <!--                                <div id="qsoft_file_info" style="display: none;">					<li>
                                                                        <strong>Additional information for field upload fields</strong>
                                                                    </li>
                                                                    <li>
                                                                        <label>Accepted file types:</label>
                                                                        <input type="text" name="add_file_value" value="">
                                                                    </li>
                                                                    <li>
                                                                        <label>&nbsp;</label>
                                                                        <span class="description">Accepted file types should be set like this: jpg|jpeg|png|gif					</span>
                                                                    </li>
                                                                </div>												
                                                                <div id="qsoft_checkbox_info" style="display: none;">					<li>
                                                                        <strong>Additional information for checkbox fields</strong>
                                                                    </li>
                                                                    <li>
                                                                        <label>Checked by default?</label>
                                                                        <input type="checkbox" name="add_checked_default" value="y">
                                                                    </li>
                                                                    <li>
                                                                        <label>Stored value if checked:</label>
                                                                        <input type="text" name="add_checked_value" value="" class="small-text">
                                                                    </li>
                                                                </div>	
                                -->


                            </table>
                            <!--<strong class="qsoft_dropdown_option_label" style="display: none">Additional option for fields</strong>-->

                            <br>
                            <input type="hidden" name="action" value="add_field" >
                            <p class="submit">
                                <input type="submit" name="submit" 
                                       onclick="qsoft_add_field(event,this)"
                                       id="submit" class="button button-primary" value="Submit"></p>	
                        </form>
                    </div>
                </div>

            </div><!-- #post-body-content -->
        </div><!-- #post-body -->

    </div>
    <?php
//}

//add field
if (isset($_POST['action'])) {
    if (filter_var($_POST['action'], FILTER_SANITIZE_STRING) == 'add_field') {
        $field_require = isset($_POST['field_required']) ? filter_var($_POST['field_required'], FILTER_SANITIZE_STRING) : 0;
        $field_name = filter_var($_POST['field_name'], FILTER_SANITIZE_STRING);
        $arr_field = array(
            'field_name' => $field_name,
            'field_label' => filter_var($_POST['field_label'], FILTER_SANITIZE_STRING),
            'field_type' => filter_var($_POST['field_type'], FILTER_SANITIZE_STRING),
            'field_required' => $field_require,
            'field_name' => filter_var($_POST['field_name'], FILTER_SANITIZE_STRING),
            'field_active' => 1,
            'field_order' => filter_var($_POST['field_order'], FILTER_SANITIZE_STRING)
        );
        if (isset($_POST['field_option_data'])) {
            $arr_field_option = ($_POST['field_option_data']);
            $arr_field['field_option'] = $arr_field_option;
        }

        if (get_option('qsoft_fields') != '') {
            $arr_all_field = get_option('qsoft_fields');
        } else {
            $arr_all_field = array();
        }

//        if (check_exist_field($arr_field['field_name'])) {
//            echo '<script>alert("field_name exist!")</script>';
//            return false;
//        }
        foreach ($arr_all_field as $key => $arr_single_field) {
            if ($field_name == $arr_single_field['field_name']) {
                unset($arr_all_field[$key]);
                echo 111;
            }
        }
        update_option('qsoft_fields', $arr_all_field);
        $arr_all_field[] = $arr_field;
        update_option('qsoft_fields', $arr_all_field);
       echo '<script> window.location = "";</script>';
    }
}


