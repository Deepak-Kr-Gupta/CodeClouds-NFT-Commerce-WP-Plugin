<?php

if(!function_exists('cnft_track_orders')){

	function cnft_track_orders(){
	    
	    if(!is_admin()){
			return;
		}
	    
$orders = wc_get_orders( array(
    'limit'        => -1, // Query all orders
    'orderby'      => 'date',
    'order'        => 'ASC',
    //'meta_key'     => 'add_gift_box', // The postmeta key field
    //'meta_compare' => 'Codeclouds NFT Discount', // The comparison argument
));


?>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<h2>Track Orders</h2>

<table>
  <tr>
    <th>Sl. No</th>
    <th>Order ID</th>
    <th>Order Amount</th>
    <th>Total Discount</th>
    <th>Order Placed</th>
    <th>Wallet Address</th>
    <th>Order Status</th>
  </tr>
  
  <?php $i=1; foreach($orders as $ord){ 
      
    $ID = $ord->get_id();
    $order = wc_get_order( $ID );
    $orderDate = wc_format_datetime($order->get_date_created());
    
    
    foreach ( $order->get_fees() as $item_fee ) {
        //print_r($order->get_fees());
    $fee_name = $item_fee->get_name();
    
    if ( $fee_name == 'Codeclouds NFT Discount' ) {
        

  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $ID; ?>&action=edit">#<?php echo $ID; ?></a></td>
    <td><?php echo $ord->get_formatted_order_total();; ?></td>
    <td><?php echo $ord->get_currency(); ?> <?php echo $item_fee->get_total(); ?></td>
    <td><?php echo $orderDate; ?></td>
    <td><?php echo $ord->get_meta('wallet_address'); ?></td>
    <td><?php echo $ord->get_status();; ?></td>
  </tr>
  <?php 
     $i++;
      } // if checks NFT presence
    } // fee items loop ends
  
  } ?>
  
</table>

<?php
	    
	}
	
}