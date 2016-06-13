<?php
require_once 'MCAPI.class.php';

class d-mailchimp
{
	
	function __construct(argument)
	{
		# code...
	}
}

add_action('admin_menu', 'd_mailchimp_menu');
function d_mailchimp_menu($hook) {
	$d_uri = get_template_directory_uri() . '/d_options/';
	add_menu_page('D MailChimp', 'D MailChimp', 'manage_options', 'd-mailchimp', 'd_mailchimp_page', $d_uri.'img/mailchimp-icon.png');
	//add_theme_page('D options', 'D options', 'manage_options', 'd-options', 'd_options_page');
}