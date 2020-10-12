<?php
class ajax_special_discount{

		public $redirect_page;
	function __construct(){
		add_action( "wp_ajax_update_prod_discount", array($this, 'update_prod_discount'), 10 );

	}
	function update_prod_discount(){
        $cat_id = $_POST['cat_id'];
        $discount = $_POST['discount_in_per'];

        $args = array(
            'post_status'       => 'publish',
            'post_type'             => 'product',
            'posts_per_page'    => '-1',
            'relation'  => 'AND',
            'tax_query' => array(
                 'taxonomy' => 'product_cat',
                 'field'    => 'term_id',
                 'terms'     =>  $cat_id, // When you have more term_id's seperate them by komma.
                 'operator'  => 'IN'
                 )
            );

            $products = new WP_Query($args);

            if ($products->have_posts()) {
                while ($products->have_posts()) {
                    $products->the_post();
                    $prod_id    = get_the_ID();
                    $regular_price = (float) get_post_meta($prod_id,'_regular_price',true); // Regular price
                    $sale_price = (float) get_post_meta($prod_id,'_sale_price',true);  // Active price (the "Sale price" when on-sale)
                    $amount = floatval($discount);
                    $new_regular_price = $regular_price * ((100-$amount) / 100);

                    update_post_meta( $prod_id, '_sale_price',(float) $new_regular_price);
                    update_post_meta( $prod_id, '_price',(float) $new_regular_price);

                }
                update_option('discounted_category', $cat_id);
                update_option('prod_discount', $discount);

                $response['status'] = true; 
                $response['message'] = 'Dicount Applied';
                $this->response_json($response);
            }
            else{
                $response['status'] = false; 
                $response['message'] = 'Something went wrong';
                var_dump("error");
                exit();
            }
    
	}
	function response_json($data){
		header('Content-Type: application/json');
	    echo json_encode($data);
	    wp_die();
	}
	function user_system_test_input($data){
		$data = trim($data);
	    $data = stripslashes($data);
	    $data = htmlspecialchars($data);
	    return $data;
	}
}
new ajax_special_discount();
