<?php 

if(!function_exists('cnft_register_menu')){

	function cnft_register_menu(){

	 add_menu_page('CodeClouds Settings', 'CodeClouds NFT Settings', 'manage_options', 'cnft-settings', 'cnft_setting_page_html', 'dashicons-thumbs-up', 20, null);

	 add_submenu_page( 'cnft-settings', 'Track', 'Track Orders', 'manage_options', 'track-orders', 'cnft_track_orders', 30);

	}

	add_action('admin_menu', 'cnft_register_menu');

}