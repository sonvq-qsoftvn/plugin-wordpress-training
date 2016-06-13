<?php
/*
Custom theme options
*/

//Add menu page on admin site
add_action('admin_menu', 'd_options_menu');
function d_options_menu($hook) {
	if (isset($_POST['action']) && isset( $_GET['page'] ) && $_GET['page'] == 'd-options') {
		save_dopts( 'js_disabled' ); //saves data when javascript is disabled
	}
	$d_uri = get_template_directory_uri() . '/d_options/';
	add_menu_page('D options', 'D options', 'manage_options', 'd-options', 'd_options_page', $d_uri.'img/d-options-icon.png');
}

//Load script and style
add_action( 'admin_enqueue_scripts', 'd_options_scripts' ); 
function d_options_scripts($page) {
	global $themename;
	$d_uri = get_template_directory_uri() . '/d_options/';
	wp_enqueue_style('d-style', $d_uri.'css/main.css');
	if($page != 'toplevel_page_d-options' && $page != 'toplevel_page_d-mailchimp')
        return;	

	wp_enqueue_style('d-icons-style', $d_uri.'/css/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('d-colorpicker', $d_uri.'css/colorpicker.css'); 
    wp_enqueue_style('thickbox');

    wp_enqueue_script('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('d-colorpicker-script', $d_uri.'js/colorpicker.js');
    wp_enqueue_script('d-scripts', $d_uri.'js/scripts_init.js', array('jquery'), '1.0');
    wp_enqueue_script('d-scripts-upload', $d_uri.'js/scripts_uploads.js', array('jquery','media-upload','thickbox'), '1.0');

    wp_localize_script( 'd-scripts', 'd_variable', array(
		'd_saving_text' => esc_html__( 'Saving...', $themename ),
		'd_saved_text'  => esc_html__( 'Options Saved.', $themename ),
		'd_nonce'       => wp_create_nonce('d_nonce'),
		'reset_nonce' 	=> wp_create_nonce('reset_nonce')
	));
}


function d_options_page() {
	global $themename, $shortname, $options;

	//load options
	require_once( esc_attr( "d-options-{$shortname}.php" ) );
	
	//register array contains tab as default active
	$tab_focus_array = array('basic');
?>
<div class="wrap">
<h1>Options for <?php echo $themename; ?></h1>
	<?php if(isset($_GET['saved_opts']) && $_GET['saved_opts'] == true && isset($_POST['action']) && $_POST['action'] == 'save_d_opts'): ?>
		<div id="message" class="updated fade">
			<p><strong><?php echo esc_html__('Options saved')?>.</strong></p>
		</div>
	<?php endif; ?>
        <form action="" enctype="multipart/form-data" id="dform" method="post">
	    <?php
	    	//Nonce field
				if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'd_nonce' ); }
				$d_nonce_field = '';
				if ( function_exists( 'wp_create_nonce' ) ) { $d_nonce_field = wp_create_nonce( 'd_nonce' ); }
				if ( $d_nonce_field == '' ) {

				} else {
		?>
		    	
		    <?php } ?>
		    <input type="hidden" name="action" value="save_d_opts" />
		    <div class="d-wrap">
			    <!--<div class="d-header">
			    	<span class="d-theme-description"></span>
			    </div>-->
				<div class="d-options-wrap">
					<div class="d-sidebar">
						<ul class="d-nav">
							<li class="active">
								<a href="#general-tab"><i class="icon-wrench"></i> <?php echo esc_html__('General settings', $themename); ?></a>
							</li>
							<li>
								<a href="#layout-tab"><i class="icon-columns"></i> <?php echo esc_html__('Layout & Colors', $themename); ?></a>
							</li>
							<li>
								<a href="#typo-tab"><i class="icon-font"></i> <?php echo esc_html__('Typography', $themename); ?></a>
							</li>
							<li>
								<a href="#social-tab"><i class="icon-rss"></i> <?php echo esc_html__('Social Connect', $themename); ?></a>
							</li>
							<li>
								<a href="#custom-codes-tab"><i class="icon-code"></i> <?php echo esc_html__('Custom codes', $themename); ?></a>
							</li>
							<li>
								<a href="#contact-tab"><i class="icon-map-marker"></i> <?php echo esc_html__('Contact page', $themename); ?></a>
							</li>
							<li>
								<a href="#wooshop-tab"><i class="icon-shopping-cart"></i> <?php echo esc_html__('Woocommerce settings', $themename); ?></a>
							</li>
							<li>
								<a href="#ad-tab"><i class="icon-volume-up"></i> <?php echo esc_html__('Advertising settings', $themename); ?></a>
							</li>
						</ul>
					</div>
					<div class="d-content">
						<?php foreach ($options as $key => $value): ?>
						<?php switch($value['type']):
							case 'd-tab-start': ?>
								<div id="<?php echo $value['name']; ?>-tab" class="d-tab <?php if($key == 0) echo 'active'; ?>">
							<?php break; ?>

							<?php case 'tab-click-start': ?>
								<ul class="tab-click">
							<?php break; ?>

							<?php case 'tab-chosen': ?>
								<li class="<?php if(in_array($value['name'], $tab_focus_array)) echo ' active';?>">
									<a href="#<?php echo $value['name']; ?>-tab">
										<?php echo $value['desc']; ?>
									</a>
								</li>
							<?php break; ?>

							<?php case 'tab-click-end': ?>
								</ul>
							<?php break; ?>

							<?php case 'tab-focus-start': ?>
								<div class="tab-focus<?php if(in_array($value['name'], $tab_focus_array)) echo ' active';?>" id="<?php echo $value['name']; ?>-tab">
							<?php break; ?>

							<?php case 'text': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								if(isset($value['html']) && $value['html'] == true)
									$d_value = htmlspecialchars($d_value);
								else
									$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<input type="text" value="<?php echo $d_value; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-itext">
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
								</div>
							<?php break; ?>

							<?php case 'textarea': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								if(isset($value['html']) && $value['html'] == true)
									$d_value = htmlspecialchars($d_value);
								else
									$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-textarea"><?php echo $d_value; ?></textarea>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>

									<?php /*if($value['mask'] != ''): ?>
									<div class="box-mask <?php if(get_option($value['mask']) == 'on') echo 'hide';?>"></div>
									<?php endif; */?>
								</div>
							<?php break; ?>

							<?php case 'number': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<div class="input-button-wrap">
											<input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="typo-size input-number" value="<?php echo $d_value; ?>">
											<a class="btn-plus number-button" href="#">+</a>
											<a class="btn-minus number-button" href="#">-</a>
										</div>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
								</div>
							<?php break; ?>
							
							<?php case 'checkbox-single': ?>
							<?php 
								$d_value = '';
								$d_value = get_option( $value['id'] );
								$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<label class="check-label <?php if(isset($value['mask-control']) && $value['mask-control'] == true) echo 'mask-control'; ?>">
											<input type="checkbox" value="on" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-icheck" <?php if($d_value == 'on' || ($d_value != 'off' && isset($value['std']))) echo 'checked="checked"'; ?>>
											<?php echo $value['desc']; ?>
										</label>
									</div>
								</div>
							<?php break; ?>

							<?php case 'checkbox-multi': ?>
							<?php 
								$d_value = array();
								$d_value = get_option( $value['id'] ) ? get_option( $value['id'] ) : array();
							?>
								<div class="d-option-box multi-checkboxes">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<?php
										if(!empty($value['options'])) {
										foreach ($value['options'] as $k => $v):
										?>
										<label>
											<input type="checkbox" value="<?php echo $k; ?>" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>" class="d-icheck" <?php if(in_array($k, $d_value)) echo 'checked="checked"'; ?>>
											<?php echo $v; ?>
										</label>
										<?php endforeach; } ?>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
									<?php /*if($value['mask'] != ''): ?>
									<div class="box-mask <?php if(get_option($value['mask']) == 'on') echo 'hide';?>"></div>
									<?php endif; */ ?>
								</div>
							<?php break; ?>

							<?php case 'radio': ?>
							<?php 
								$d_value = '';
								$d_value = get_option( $value['id'] ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
							?>
								<div class="d-option-box multi-checkboxes">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<?php foreach ($value['options'] as $k => $v): ?>
										<label>
											<input type="radio" value="<?php echo $k; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-icheck" <?php if($k == $d_value) echo 'checked="checked"'; ?>>
											<?php echo $v; ?>
										</label>
										<?php endforeach; ?>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
									<?php /*if($value['mask'] != ''): ?>
									<div class="box-mask <?php if(get_option($value['mask']) == 'on') echo 'hide';?>"></div>
									<?php endif; */?>
								</div>
							<?php break; ?>

							<?php case 'select': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-select-option">
											<?php if($value['std'] != ''): ?>
											<option value =""><?php echo $value['std']; ?></option>
											<?php endif; ?>
											<?php foreach($value['options'] as $k => $val): ?>
											<option value="<?php echo $k; ?>" <?php if($k == $d_value) echo 'selected="selected"'; ?>><?php echo $val; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
								</div>
							<?php break; ?>

							<?php case 'upload': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<input type="text" value="<?php echo $d_value; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="d-itext" class="upload-field">
										<a href="#" class="d-button d_upload_button"><?php echo __('<i class="icon-upload-alt"></i> Upload', $themename); ?></a>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
									<div class="d-review-upload<?php if($value['review'] == true && $d_value != '') echo ' active'; ?>">
									<?php if($value['review'] == true): ?>									
										<img src="<?php echo $d_value; ?>" width="150px">							
									<?php endif; ?>
										<i class="icon-trash remove-logo" title="<?php echo esc_html__('Remove', $themename); ?>"></i>
									</div>
								</div>
							<?php break; ?>

							<?php case 'colorpicker': ?>
							<?php 
								$d_value = '';
								$d_value = ( '' != get_option( $value['id'] ) ) ? get_option( $value['id'] ) : (isset($value['std']) ? $value['std'] : '');
								$d_value = stripslashes( $d_value );
							?>
								<div class="d-option-box colorpicker-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<div id="<?php echo $value['id'].'-colorpicker'; ?>" class="d-colorpicker">
											<div style="background-color: <?php echo $d_value; ?>"></div>
										</div>
										<input type="text" value="<?php echo $d_value; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="typo-color">
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>
								</div>
							<?php break; ?>

							<?php case 'typography': ?>
							<?php
								$value_opts = get_option($value['id']) ? get_option($value['id']) : array();

								$face_value      = (isset($value_opts['face'])) ? $value_opts['face'] : $value['std']['face'];									
								$size_value      = (isset($value_opts['size'])) ? $value_opts['size'] : $value['std']['size'];
								$unit_value      = (isset($value_opts['unit'])) ? $value_opts['unit'] : $value['std']['unit'];
								$style_value     = (isset($value_opts['style'])) ? $value_opts['style'] : $value['std']['style'];
								$color_value     = (isset($value_opts['color']) )? $value_opts['color'] : $value['std']['color'];
								$transform_value = (isset($value_opts['transform'])) ? $value_opts['transform'] : $value['std']['transform'];

								$face_value      = stripslashes($face_value);
								$size_value      = stripslashes($size_value);
								$unit_value      = stripslashes($unit_value);
								$style_value     = stripslashes($style_value);
								$transform_value = stripslashes($transform_value);
							?>
								<div class="d-option-box typography-box">
									<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									<div class="d-section">
										<div class="input-button-wrap">
											<input type="text" name="<?php echo $value['id'].'-size'; ?>" id="<?php echo $value['id'].'-size'; ?>" class="typo-size" value="<?php echo $size_value; ?>">
											<a class="btn-plus number-button" href="#">+</a>
											<a class="btn-minus number-button" href="#">-</a>
										</div>
										
										<select name="<?php echo $value['id'].'-unit'; ?>" id="<?php echo $value['id'].'-unit'; ?>" class="typo-unit">
											<?php foreach ($font_unit_list as $k => $v): ?>
											<option value="<?php echo $k; ?>" <?php if($unit_value == $v) echo 'selected="selected"' ;?>>
												<?php echo $v; ?>
											</option>
											<?php endforeach; ?>
										</select>

										<select name="<?php echo $value['id'].'-face'; ?>" id="<?php echo $value['id'].'-face'; ?>" class="typo-face">
											<optgroup label="Web fonts">
												<?php foreach ($font_face['web_fonts'] as $k => $v): ?>
												<option value="<?php echo htmlspecialchars($v); ?>" <?php if($face_value == $v) echo 'selected="selected"' ;?>>
													<?php echo $k; ?>
												</option>
												<?php endforeach; ?>
											</optgroup>
											<optgroup label="Google fonts">
												<?php foreach ($font_face['google_fonts'] as $k => $v): ?>
												<option value="<?php echo htmlspecialchars($v); ?>" <?php if($face_value == $v) echo 'selected="selected"' ;?>>
													<?php echo $k; ?>
												</option>
												<?php endforeach; ?>
											</optgroup>
										</select>

										<select name="<?php echo $value['id'].'-style'; ?>" id="<?php echo $value['id'].'-style'; ?>" class="typo-style">
											<?php foreach ($font_style_list as $k => $v): ?>
											<option value="<?php echo $k; ?>" <?php if($style_value == $k) echo 'selected="selected"' ;?>>
												<?php echo $v; ?>
											</option>
											<?php endforeach; ?>
										</select>

										<div id="<?php echo $value['id'].'-colorpicker'; ?>" class="d-colorpicker">
											<div style="background-color: <?php echo $color_value; ?>"></div>
										</div>

										<input type="text" value="<?php echo $color_value; ?>" name="<?php echo $value['id'].'-color'; ?>" id="<?php echo $value['id'].'-color'; ?>" class="typo-color">

										<select name="<?php echo $value['id'].'-transform'; ?>" id="<?php echo $value['id'].'-transform'; ?>" class="typo-transform">
											<?php foreach ($font_transform_list as $k => $v): ?>
											<option value="<?php echo $k; ?>" <?php if($transform_value == $k) echo 'selected="selected"' ;?>>
												<?php echo $v; ?>
											</option>
											<?php endforeach; ?>
										</select>
										<a class="d-btn preview-typo" href="#" title="<?php echo esc_html__('Preview change', $themename); ?>"><i class="icon-search"></i></a>
										<div class="preview-typo-result">
											<?php echo esc_html__('Grumpy wizards make toxic brew for the evil Queen and Jack.'); ?>
											<i class="icon-minus-sign hide-preview-typo"></i>
										</div>
									</div>
									<div class="d-section-desc"><?php echo $value['desc']; ?></div>

									<input type="hidden" value="true" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
								</div>
							<?php break; ?>
							
							<?php //Begin mailchimp case: ?>
							<?php case 'mailchimp': ?>
								<?php echo echo_key(2); ?>
							<?php break; ?>
							<?php //End mailchimp case: ?>

							<?php case 'tab-focus-end': ?>
								</div>
							<?php break; ?>

							<?php case 'd-tab-end': ?>
								</div>
							<?php break; ?>

							<?php endswitch; ?>
						<?php  endforeach; ?>
						<div class="fix"></div>
					</div>
					<div class="fix"></div>
				</div>
				<div class="d-footer">
			    	<div class="d-action-button">
			    		<input type="submit" value="<?php echo esc_html__('Reset all changes', $themename); ?>" class="d-button d-reset-button">
			    		<input type="submit" value="<?php echo esc_html__('Save all changes', $themename); ?>" class="d-button d-save-button">

			    	</div>
			    </div>
			</div>
		</form>
</div>
<div class="loading-element"></div>
<?php
}

add_action('wp_ajax_save_d_opts', 'callback_save_dopts');
function callback_save_dopts() {
    check_ajax_referer('d_nonce');
	save_dopts('ajax');
	die();
}

if (!function_exists( 'save_dopts' )){
	function save_dopts($type) {
		global $options, $web_fonts_array;
		
		if (!current_user_can('switch_themes'))
			die('-1');

		load_d_options();

		if(isset($_POST['action']) && $_POST['action'] == 'save_d_opts' && $_POST['reset'] != 1) {
			if ($type != 'ajax')
				check_admin_referer( 'd_nonce' );
			//Loop and save options type and value
			foreach($options as $value) {
				if (isset( $value['id'])) {
					if (isset($_POST[ $value['id'] ])) {
						if (in_array($value['type'], array('text', 'textarea'))) {
							if (isset( $value['html'])) {
								if ($value['html'] == true) {
									if ( current_user_can( 'unfiltered_html' ) )
										d_save_option( $value['id'], stripslashes( $_POST[$value['id']] ) );
									else
										d_save_option( $value['id'], stripslashes( wp_filter_post_kses( addslashes( $_POST[$value['id']] ) ) ) );
								}									
							} else {
								d_save_option( $value['id'], wp_strip_all_tags( stripslashes( $_POST[$value['id']] ) ) );
							}

						} elseif ($value['type'] == 'number') {
								d_save_option( $value['id'], (int) stripslashes( $_POST[$value['id']] ) );

						} elseif ($value['type'] == 'upload') {
								d_save_option( $value['id'], esc_url_raw( stripslashes( $_POST[$value['id']] ) ) );

						} elseif (in_array($value['type'], array('select', 'radio', 'colorpicker'))) {
							d_save_option( $value['id'], stripslashes( $_POST[$value['id']] ) );

						} elseif (in_array($value['type'], array('checkbox', 'checkbox-single'))) {
							d_save_option( $value['id'], stripslashes( $_POST[$value['id']] ) );

						} elseif ($value['type'] == 'checkbox-multi') {
							d_save_option($value['id'], stripslashes_deep($_POST[$value['id']]));

						} elseif ($value['type'] == 'typography') {
							$data = array(
								'size'  => (int) stripslashes( $_POST[$value['id'].'-size'] ),
								'face'  => stripslashes( $_POST[$value['id'].'-face'] ),
								'style' => stripslashes( $_POST[$value['id'].'-style'] ),
								'unit'  => stripslashes( $_POST[$value['id'].'-unit'] ),
								'color' => stripslashes( $_POST[$value['id'].'-color'] ),
								'transform' => stripslashes( $_POST[$value['id'].'-transform'] )
							);

							$google_fonts_list[] = $data['face'];//save the google font

							d_save_option($value['id'], $data);
						}
					}
					else {
						if (in_array($value['type'], array('checkbox', 'checkbox-single'))) {
							d_save_option( $value['id'], 'off' );
						} elseif ($value['type'] == 'checkbox-multi') {
							d_save_option( $value['id'], array() );
						}
					}
				}
			}
			//save list google font to a option
			d_save_option('google_font_list', array_values(array_diff(array_unique($google_fonts_list), $web_fonts_array)));

			if ($type == 'js_disabled') header("Location: themes.php?page=d-options&saved_opts=true");
			die('1');

		} elseif(isset($_POST['action']) && $_POST['action'] == 'save_d_opts' && $_POST['reset'] == 1) {
			if ($type != 'ajax')
				check_admin_referer( 'd_nonce' );
			if (!wp_verify_nonce( $_POST['_reset_nonce'], 'reset_nonce' ) || !current_user_can('switch_themes'))
				die("Oops! You can't do that!");

			foreach ($options as $value) {
				if (isset($value['id'])) {
					delete_option($value['id']);
					if (isset($value['std'])) {
						d_save_option( $value['id'], $value['std'] );						
					}
				}
			}
			die('1');
		}
	}
}
