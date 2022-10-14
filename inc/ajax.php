<?php 
// Add Claim NFT button on WooCommerce checkout page
add_action('woocommerce_cart_coupon', 'amano_back_to_store');
add_action('woocommerce_checkout_before_order_review', 'amano_back_to_store');

function amano_back_to_store() {
 if (is_checkout()) {
    echo '<div id="CCNFT" class="CCNFT">';  
    echo '<div class="enableEthereumButton">Claim Codeclouds NFT Discount →</div>';
    echo '<div class="clear"></div>';  
    echo '<p class="resultNFT"></p>';
    echo '</div>';
 }
 
}

/* Fecthing contract address which needs to be matched */

function cnft_get_address_ajax(){

    $address = get_option('cnft_address_label');
    echo $address;
    exit();
    
}

add_action('wp_ajax_cnft_get_address_ajax','cnft_get_address_ajax');
add_action('wp_ajax_nopriv_cnft_get_address_ajax','cnft_get_address_ajax');

/**
 * Add html to checkout
 *
 * @version 1.0.0
 * @since   1.0.0
 */
add_action( 'woocommerce_after_checkout_billing_form', 'add_box_option_to_checkout' );
function add_box_option_to_checkout( $checkout ) {
    $site_url = site_url();
    if (is_checkout()) {
        echo '<script type="module" src="'.plugin_dir_url( __DIR__ ).'/assets/js/nft.js?v=1.2.7"></script>';
    }
	echo '<div id="message_fields">';
	woocommerce_form_field( 'wallet_address', array(
		'type'          => 'hidden',
		'class'         => array('wallet_address form-row-wide'),

		//'label'         => esc_html__( 'Codeclouds NFT Discount', 'codeclouds.com' ),
		'placeholder'   => '',
	), $checkout->get_value( 'wallet_address' ));
	echo '</div>';
}


// Update the order meta with field value
add_action( 'woocommerce_checkout_create_order', 'custom_checkout_field_create_order', 10, 2 );
function custom_checkout_field_create_order( $order, $data ) {
    if ( isset($_POST['wallet_address']) && ! empty($_POST['wallet_address']) ) {
         $order->update_meta_data( 'wallet_address', sanitize_text_field($_POST['wallet_address']) );
    }
}



/**
 * Add fee to cart
 *
 * @link    https://docs.woocommerce.com/document/add-a-surcharge-to-cart-and-checkout-uses-fees-api/
 * @version 1.0.0
 * @since   1.0.0
 */
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
	if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
		return;
	}

	if ( isset( $_POST['post_data'] ) ) {
		parse_str( $_POST['post_data'], $post_data );
	} else {
		$post_data = $_POST;
	}
	
	global $woocommerce; 
    
    $cart = $woocommerce->cart;
    
    // Will get you cart object
    $cart_total = $woocommerce->cart->cart_contents_total;
    
    //echo $cart_total;
    $discountAdmin = get_option('cnft_discount_label');

    $disPercent = $cart_total*($discountAdmin/100);

	if (isset($post_data['wallet_address']) && !empty($post_data['wallet_address'])) {
		$extracost = 1;
		WC()->cart->add_fee( esc_html__( 'Codeclouds NFT Discount', 'codeclouds.com' ), -$disPercent );
	}

}

$option_name = "cnft_json_label";

add_action('updated_option', function( $option_name, $old_value, $value ) {
    
     $file_url = __DIR__.'/../assets/js/contractABI.json';  
     
     $data = get_option('cnft_json_label');
     
     $jsonCode = json_decode($data);

     file_put_contents($file_url, $data);
     
}, 10, 3);

?>