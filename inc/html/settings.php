<?php 

if(!function_exists('cnft_setting_page_html')){

	function cnft_setting_page_html(){

		if(!is_admin()){

			return;

		}

		?>

		<div class="wrap">

			<form action="options.php" method="post">

				<?php 

					settings_fields('cnft-settings');

					do_settings_sections('cnft-settings');

					submit_button('Save');

				?>

			</form>

		</div>

		<?php

	}

}

if(!function_exists('cnft_plugin_settings')){

	function cnft_plugin_settings(){

		register_setting('cnft-settings', 'cnft_address_label');

		register_setting('cnft-settings', 'cnft_discount_label');
		
		register_setting('cnft-settings', 'cnft_json_label');

		add_settings_section('cnft_label_settings_section', 'NFT Setting', 'cnft_plugin_settings_section_cb', 'cnft-settings');

		add_settings_field('cnft_address_label_field', 'Smart Contract Address', 'cnft_address_cb', 'cnft-settings', 'cnft_label_settings_section');

		add_settings_field('cnft_discount_label_field', 'Discount', 'cnft_discount_cb', 'cnft-settings', 'cnft_label_settings_section');	
		
		add_settings_field('cnft_json_label_field', 'Smart Contract ABI JSON', 'cnft_json_cb', 'cnft-settings', 'cnft_label_settings_section');	

	}

	add_action('admin_init', 'cnft_plugin_settings');

}

function cnft_plugin_settings_section_cb(){

	echo '<p> Please fill up the Smart Contract Address and the Discount you want to give.</p>';

}

function cnft_address_cb(){

	$setting = get_option('cnft_address_label');

	?>

	<input type="text" name="cnft_address_label" value="<?php echo isset($setting) ? esc_attr($setting): ''; ?>">

	<?php

}

function cnft_discount_cb(){

	$setting = get_option('cnft_discount_label');

	?>

	<input type="text" name="cnft_discount_label" value="<?php echo isset($setting) ? esc_attr($setting): ''; ?>">

	<?php

}

function cnft_json_cb(){

	$setting = get_option('cnft_json_label');

	?>

	<textarea name="cnft_json_label" cols="100" rows="20" > <?php echo isset($setting) ? esc_attr($setting): ''; ?> </textarea>

	<?php

}

