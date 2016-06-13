<?php
global $d_message;
require_once 'MCAPI.class.php';
global $themename;
add_action('admin_menu', 'd_mailchimp_menu');
function d_mailchimp_menu($hook) {
	$d_uri = get_template_directory_uri() . '/d_options/';
	add_menu_page('D MailChimp', 'D MailChimp', 'manage_options', 'd-mailchimp', 'd_mailchimp_page', $d_uri.'img/mailchimp-icon.png');
	//add_theme_page('D options', 'D options', 'manage_options', 'd-options', 'd_options_page');
}
if(!function_exists('d_mailchimp_page')) {
	function d_mailchimp_page() {
		global $d_message, $themename;

		$options = get_option('dmc-options');
		$apikey  = $options['apikey'];
?>
<div class="wrap">	
	<div class="icon32 d-mailchimp-icon"><br></div>
	<h2><?php echo esc_html__('Simple MailChimp newsletter settings', $themename); ?></h2>
	<?php if($d_message): ?>
		<?php if($d_message['type'] == 'error'): ?>
			<div class="error"><p><?php echo $d_message['msg']; ?></p></div>
		<?php elseif($d_message['type'] == 'success'): ?>
			<div class="updated"><p><?php echo $d_message['msg']; ?></p></div>
		<?php endif; ?>
	<?php endif; ?>
	<form action="" enctype="multipart/form-data" id="dmc-form" method="post">
		<?php
			if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'dmc_nonce' ); }
			$d_nonce_field = '';
			if ( function_exists( 'wp_create_nonce' ) ) { $d_nonce_field = wp_create_nonce( 'dmc_nonce' ); }
			if ( $d_nonce_field == '' ) {

			} else {
		?>
		    	
	    <?php } ?>

		<?php if($apikey == ''): ?>
		<input type="hidden" name="action" value="dmc_get_info" />
		<h3><?php echo esc_html__('Enter API Key'); ?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('API Key'); ?></th>
					<td>
						<input name="dmc-apikey" type="text" id="dmc-apikey" value="" class="regular-text">
						<p class="description">
							<?php 
							echo sprintf(__('To get your MailChimp API Key, you need to %s and access to "Account settings" > "Extras" > "API keys"', $themename), '<a href="http://mailchimp.com/login" target="_blank">login</a>'); 
							?>
						</p>					    
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="dmc_submit" class="button button-primary" value="<?php echo esc_html('Save'); ?>"></p>
		<?php else: ?>
		<input type="hidden" name="action" value="dmc_save_options" />
		<h3><?php echo esc_html__('Your MailChimp infomations', $themename); ?></h3>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Username', $themename); ?></th>
					<td><?php echo $options['username'];?> <a title="<?php echo esc_html__('Logout', $themename); ?>" class="d-btn dmc-signout" href="<?php echo admin_url(); ?>admin.php?page=d-mailchimp&act=logout&wpnonce=<?php echo wp_create_nonce('dmc-logout-nonce'); ?>"><i class="icon-signout"></i></a></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Email account', $themename); ?></th>
					<td><?php echo $options['email'];?></td>
				</tr>
			</tbody>
		</table>
		<h3><?php echo esc_html__('Subscribe settings', $themename); ?></h3>
		<?php
			$lists = dmc_get_lists($apikey);

			if($lists['success'] == 0) {
				echo $lists['msg'];
			} else {
		?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Select your list', $themename); ?></th>
					<td>
						<select name="dmc-list-id" id="dmc-list-id">
							<option value=""><?php echo esc_html__('- Select -'); ?></option>
							<?php foreach ($lists['results'] as $key => $value): ?>
							<option value="<?php echo $value['id']; ?>"<?php if(get_option('dmc-list-id') == $value['id']) echo ' selected="selected"'; ?> data-name="<?php echo $value['name']; ?>"><?php echo $value['name'] . ' ('.$value['stats']['member_count'].')'; ?></option>
							<?php endforeach; ?>
						</select>
						<!--<span title="Refresh the lists" class="d-btn dmc-refresh-list"><i class="icon-refresh"></i></span>-->
						<input type="hidden" name="dmc-list-name" id="dmc-list-name" value="<?php echo get_option('dmc-list-name'); ?>">
						<p class="description">
							<?php echo esc_html__('Please choose the list you want to use for subscribe form.', $themename); ?>
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Show first name field', $themename); ?></th>
					<td>
						<label for="dmc-show-fname">
							<input type="checkbox" name="dmc-show-fname" id="dmc-show-fname" value="1"<?php if(get_option('dmc-show-fname') == 1) echo ' checked="checked"';?>>
							<?php echo esc_html__('Show first name input field on subscribe form.', $themename); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Show last name field', $themename); ?></th>
					<td>
						<label for="dmc-show-lname">
							<input type="checkbox" name="dmc-show-lname" id="dmc-show-lname" value="1"<?php if(get_option('dmc-show-lname') == 1) echo ' checked="checked"';?>>
							<?php echo esc_html__('Show last name input field on subscribe form.', $themename); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<?php
						$ajax_check = 'checked="checked"';
						if(get_option('dmc-use-ajax') == 1 || get_option('dmc-use-ajax') == false)
							$ajax_check = 'checked="checked"';
						else
							$ajax_check = '';
					?>
					<th scope="row"><?php echo esc_html__('Ajax submit', $themename); ?></th>
					<td>
						<label for="dmc-use-ajax">
							<input type="checkbox" name="dmc-use-ajax" id="dmc-use-ajax" value="1" <?php echo $ajax_check; ?>>
							<?php echo esc_html__('Allow subscribe form with ajax request.', $themename); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Form title', $themename); ?></th>
					<td>
						<input type="text" name="dmc-form-title" id="dmc-form-title" value="<?php echo get_option('dmc-form-title') ? get_option('dmc-form-title') : esc_html__('Subscribe for ', $themename). get_option('dmc-list-name'); ?>" size="40">
						<p class="description">
						<?php echo esc_html__('The title of the subscribe form.', $themename); ?>
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Button text', $themename); ?></th>
					<td>
						<input type="text" name="dmc-button-value" id="dmc-button-value" value="<?php echo get_option('dmc-button-value') ? get_option('dmc-button-value') : esc_html__('Join us', $themename); ?>" size="40">
						<p class="description">
						<?php echo esc_html__('The value of the subscribe button submit.', $themename); ?>
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html__('Connect icons', $themename); ?></th>
					<td>
						<label for="dmc-show-connect">
							<input type="checkbox" name="dmc-show-connect" id="dmc-show-connect" value="1"<?php if(get_option('dmc-show-connect') == 1) echo ' checked="checked"';?>>
							<?php echo esc_html__('Show social connect icons', $themename); ?>
						</label>
						<p class="description">
							<?php echo esc_html__('Show list of social connect links under the subscribe form (You can setup connect links at option page of this theme).', $themename); ?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="dmc_submit" class="button button-primary" value="<?php echo esc_html('Save settings'); ?>"></p>
		<?php } ?>
		<?php endif; ?>
	</form>
</div>
<?php																											
	}
}
if(!function_exists('dmc_request')) {
	function dmc_request() {
		global $d_message, $themename;
		if(isset($_POST['action'])) {
			$nonce = $_REQUEST['_wpnonce'];

			switch ($_POST['action']) {
				case 'dmc_get_info':
					if (!wp_verify_nonce( $nonce, 'dmc_nonce' ) || !current_user_can('manage_options'))
						wp_die("Oops! You can't do that!");

					$apikey = $_POST['dmc-apikey'];
					if($apikey == '') {
						$d_message = array('msg'=>esc_html__('API key cannot be blank', $themename), 'type' => 'error');
						return;
					}
					$info = dmc_get_info($apikey);

					if($info['success'] == 0) {
						$d_message = array('msg' => __('Your API key is not <strong>correct</strong> or <strong>invalid</strong><br><strong>MailChimp message</strong>:'. $info['error'], $themename), 'type' => 'error');
						return;
					}
					if($info['success'] == 1) {
						$d_message = array('msg' => esc_html__('Connect success!'), 'type' => 'success');
						return;
					}

					break;
				
				case 'dmc_save_options':
					if (!wp_verify_nonce( $nonce, 'dmc_nonce' ) || !current_user_can('manage_options'))
						wp_die("Oops! You can't do that!");
					if($_POST['dmc-list-id'] == '') {
						$d_message = array('msg'=>esc_html__('Please select the list', $themename), 'type' => 'error');
						return;
					}
					d_save_option('dmc-list-id', $_POST['dmc-list-id']);
					d_save_option('dmc-list-name', $_POST['dmc-list-name']);
					d_save_option('dmc-show-fname', $_POST['dmc-show-fname']);
					d_save_option('dmc-show-lname', $_POST['dmc-show-lname']);
					d_save_option('dmc-button-value', $_POST['dmc-button-value']);
					d_save_option('dmc-show-lname', $_POST['dmc-show-lname']);
					d_save_option('dmc-use-ajax', $_POST['dmc-use-ajax'] ? $_POST['dmc-use-ajax'] : 2);
					d_save_option('dmc-show-connect', $_POST['dmc-show-connect'] ? $_POST['dmc-show-connect'] : 2);
					$d_message = array('msg'=>esc_html__('All settings are saved', $themename), 'type' => 'success');
					return;
					break;
			}
		}
		if(isset($_GET['act']) && isset($_GET['wpnonce'])) {
			switch ($_GET['act']) {
				case 'logout':
					if(!wp_verify_nonce($_GET['wpnonce'], 'dmc-logout-nonce'))
						wp_die("Oops! You can't do that!");
					//reset just api key
					$options           = get_option('dmc_options');
					$options['apikey'] = '';
					d_save_option('dmc-options', $options);
					break;
			}
		}
	}
}
add_action('init', 'dmc_request');

//Mailchimp function

function dmc_get_info($apikey = '') {
	if(!$apikey)
		return false;

	if($apikey) {
		$api       = new MCAPI($apikey);
		$api->ping();

		if(empty($api->errorCode)) {			
			$dmc_account_info = $api->getAccountDetails();

			$dmc_options = array(
				'apikey'      => $apikey,
				'username'    => $dmc_account_info['username'],
				'user_id'     => $dmc_account_info['user_id'],
				'email'       => $dmc_account_info['contact']['email']
			);

			d_save_option('dmc-options', $dmc_options);

			return array(
				'success' => 1,
				'results' => array(
					'username' => $dmc_account_info['username'],
					'user_id'  => $dmc_account_info['user_id']
				)
			);
		} else {
			return array(
				'success' => 0,
				'error'   => $api->errorMessage
			);
		}			
	}
}
function dmc_get_lists($apikey) {
	if(!$apikey)
		return false;

	$api   = new MCAPI($apikey);
	$lists = $api->lists(array(), 0, 50); //Almost we just need only first 50 list
	if ($api->errorCode){
		return array(
			'success' => 0,
			'msg' => $api->errorMessage
		);
	} else {
		if($lists['total'] == 0) {
			$msg = sprintf(__('There are no lists in your account, go to %s to create one.', $themename), '<a href="http://mailchimp.com/login" target="_blank">account settings</a>');
			return array(
				'success' => 0,
				'msg' => $msg
			);
		} else {
			return array(
				'success' => 1,
				'results' => $lists['data']
			);
		}
	}	
}
?>