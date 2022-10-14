<?php 

if(!function_exists('cnft_plugin_scripts')){

	function cnft_plugin_scripts(){
	    
		if(is_checkout()){
		    
		   wp_enqueue_style('cnft-css', CNFT_PLUGIN_DIR.'/assets/css/style.css?v=1.0.3');
		   wp_enqueue_script('cnft-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', 'jQuery', '1.0.0', true);
		   //wp_enqueue_script('cnft-js2', 'https://cdnjs.cloudflare.com/ajax/libs/web3/1.7.0-rc.0/web3.min.js', 'jQuery', '1.0.0', true);
		   wp_enqueue_script('cnft-js2', 'https://cdn.ethers.io/lib/ethers-5.2.umd.min.js', 'jQuery', '1.1.1', true);
		   
		}
		wp_enqueue_script('cnft-ajax', CNFT_PLUGIN_DIR.'/assets/js/ajax.js', 'jQuery', '1.0.0', true);
		wp_localize_script('cnft-ajax', 'cnft_ajax_url', array(
			'ajax_url'=>admin_url('admin-ajax.php')
		));
	}

	add_action('wp_enqueue_scripts', 'cnft_plugin_scripts');
	
}

?>