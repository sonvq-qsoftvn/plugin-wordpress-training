<?php
/*
  Plugin Name: Custom Registration
  Plugin URI: http://quangsonpro.com
  Description: A custom registration form plugin
  Version: 1.0
  Author: Vu Quang Son
  Author URI: http://quangsonpro.com
 */

function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ) {
    echo '
        <style>
            div {
                margin-bottom: 2px;
            }

            input{
                margin-bottom: 4px;
            }
            .error-message {
                color: red;
            }
        </style>
    ';
 
    echo '
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <div>
                <label for="username">Username <strong>*</strong></label>
                <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
            </div>

            <div>
                <label for="password">Password <strong>*</strong></label>
                <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
            </div>

            <div>
                <label for="email">Email <strong>*</strong></label>
                <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
            </div>

            <div>
                <label for="website">Website</label>
                <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
            </div>

            <div>
                <label for="firstname">First Name</label>
                <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
            </div>

            <div>
                <label for="website">Last Name</label>
                <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
            </div>

            <div>
                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
            </div>

            <div>
                <label for="bio">About / Bio</label>
                <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
            </div>
            <input type="submit" name="submit" value="Register"/>
        </form>
    ';
}

function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio )  {
    global $reg_errors;
    $reg_errors = new WP_Error;
    
    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    
    if ( 4 > strlen( $username ) ) {
        $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
    }
    
    if ( username_exists( $username ) ) {
        $reg_errors->add('user_name', 'Sorry, that username already exists!');
    }
    
    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
    }
    
    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
    
    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }
    
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }
    
    if ( ! empty( $website ) ) {
        if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
            $reg_errors->add( 'website', 'Website is not a valid URL' );
        }
    }
    
    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div class="error-message">';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_login'    =>   $username,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'user_url'      =>   $website,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'nickname'      =>   $nickname,
            'description'   =>   $bio,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
}

function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['website'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['nickname'],
            $_POST['bio']
        );
         
        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $nickname   =   sanitize_text_field( $_POST['nickname'] );
        $bio        =   esc_textarea( $_POST['bio'] );
 
        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
            $username,
            $password,
            $email,
            $website,
            $first_name,
            $last_name,
            $nickname,
            $bio
        );
    }
 
    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio
    );
}

function custom_registration_load_custom_wp_admin_style() {
    wp_enqueue_script('js_backend', plugin_dir_url(__FILE__) . '/js/backend.js', ['jquery'], null, true);
}

add_action('admin_enqueue_scripts', 'custom_registration_load_custom_wp_admin_style', 100);


function create_custom_registration_page_action() {
    global $wpdb;

    $the_page_title = 'Custom Registration Page';
    $the_page_name = 'custom-registration-page';

    // the menu entry...
    delete_option("custom_registration_page_title");
    add_option("custom_registration_page_title", $the_page_title, '', 'yes');
    // the slug...
    delete_option("custom_registration_page_name");
    add_option("custom_registration_page_name", $the_page_name, '', 'yes');
    // the id...
    delete_option("custom_registration_page_id");
    add_option("custom_registration_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {
        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "[cr_custom_registration]";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );
    }

    delete_option( 'custom_registration_page_id' );
    add_option( 'custom_registration_page_id', $the_page_id );        
}

add_action('wp_ajax_create_custom_registration_page_action', 'create_custom_registration_page_action');


/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'custom_registration_page_remove' );

function custom_registration_page_remove() {
    global $wpdb;
    $the_page_title = get_option( "custom_registration_page_title" );
    $the_page_name = get_option( "custom_registration_page_name" );

    //  the id of our page...
    $the_page_id = get_option( 'custom_registration_page_id' );
    if( $the_page_id ) {
        wp_delete_post( $the_page_id ); // this will trash, not delete
    }

    delete_option("custom_registration_page_title");
    delete_option("custom_registration_page_name");
    delete_option("custom_registration_page_id");

}

// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
 
// The callback function that will replace [cr_custom_registration]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

add_action('admin_menu', 'my_plugin_custom_registration_menu');

function my_plugin_custom_registration_menu() {
	add_menu_page('Custom registration Settings', 'Custom Register', 'administrator', 'my-plugin-custom-registration', 'my_plugin_custom_registration', 'dashicons-admin-generic');
}

function my_plugin_custom_registration() { ?>
    <div class="wrap">
        <h2><?php _e( 'Custom Registration Plugin', 'my-plugin-custom-registration' ) ?></h2>
        <a class="" href="#" onclick="create_custom_registration_page()">Create Custom Registration Page</a>
    </div>
<?php }