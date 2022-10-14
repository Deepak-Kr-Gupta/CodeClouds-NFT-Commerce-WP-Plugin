<?php 

/*
    Plugin Name: CodeClouds-NFT-Commerce
    Plugin URI: https://www.codeclouds.com/
    Author: Codeclouds Deepak Gupta's Team
    Author URI: https://www.codeclouds.com/
    Description: This allow users to claim X% of discount to Codeclouds NFT holder.
    Version: 1.0.0
    License: GPLv2 or later
    Text Domain: codeclouds-nft-commerce

*/

if(!defined('ABSPATH')){
    die;
}

if(!defined('CNFT_PLUGIN_VERSION')){
	define('CNFT_PLUGIN_VERSION', '1.0.0');
}

if(!defined('CNFT_PLUGIN_DIR')){

	define('CNFT_PLUGIN_DIR', plugin_dir_url(__FILE__));
}

// Include scripts and styles
require plugin_dir_path(__FILE__).'/inc/front-scripts.php';

//add menu in the backend
require plugin_dir_path(__FILE__).'/inc/settings.php';

//Ajax process

require plugin_dir_path(__FILE__).'/inc/ajax.php';
?>