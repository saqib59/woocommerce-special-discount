<?php
// ini_set('max_execution_time', 0);
class SpecialDiscountMain{

    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this , 'login_register96_scripts') );
        add_action('admin_enqueue_scripts',array($this, 'login_register96_scripts'));
        add_action("admin_menu",  array($this, 'special_discount_plugin_menu'));
        add_action('admin_post_apply_discount', array( $this, 'apply_special_discount'));  
        add_action('special_discount_styling', array( $this, 'lms_scripts_styles'));  
        add_action('woocommerce_get_price_html', array( $this, 'change_displayed_sale_price_html'),10,2);  

  }
  
  public function get_all_wc_categories(){
    $discountedCategories = get_option('discounted_category');
        $args = array(
                     'taxonomy'     => 'product_cat',
                     'orderby'      => 'name',
                     'show_count'   => 0,
                     'pad_counts'   => 0,
                     'hierarchical' => 1,
                     'title_li'     => '',
                     'hide_empty'   => 0
              );
             $all_categories = get_categories( $args );

             $categories_array = array();
             $index = 0;

             foreach ($all_categories as $cat) {
               $checked ='';
                    $category_id = $cat->term_id;
                    if (is_array($discountedCategories) && count($discountedCategories)>0 && !empty($discountedCategories)) {
                      foreach ($discountedCategories as $key => $catId) {
                         if ($category_id == $catId) {
                            $checked = 'selected';
                          }
                      }
                  }
                 
                  $categories_array[$index] ='<option value="'.$cat->cat_ID.'" '.$checked.' > '.$cat->name. '</option>';
                  $index++;
              } 

                return array_unique($categories_array);
  }
    public function apply_special_discount(){

          $catIdsArray = $_POST['discounted_category'];
          $discountInPer = $_POST['prod_discount'];
          foreach ($catIdsArray as $arrayIndex => $catId) {
              $args = array(
              'post_status'       => 'publish',
              'post_type'             => 'product',
              'posts_per_page'    => '-1',
              'relation'  => 'AND',
              'tax_query' => array(
                   'taxonomy' => 'product_cat',
                   'field'    => 'term_id',
                   'terms'     =>  $catId, // When you have more term_id's seperate them by komma.
                   'operator'  => 'IN'
                   )
              );

              $products = new WP_Query($args);

              if ($products->have_posts()) {
                  while ($products->have_posts()) {
                      $products->the_post();
                      $prodId    = get_the_ID();

                        $args = array(
                            'post_parent' => $prodId, // Current post's ID
                            'post_type' => 'product_variation', // Current post's ID
                        );
                        $variations = get_children( $args );
                        // Check if the post has any child
                        if ( ! empty($variations) ) {

                           foreach ( $variations as $variation ) {
                            // The product has at least one variation
                                $variationID    = $variation->ID;
                                $regularPrice = (float) get_post_meta($variationID,'_regular_price',true); // Regular price
                                $salePrice = (float) get_post_meta($variationID,'_sale_price',true);  // Active price (the "Sale price" when on-sale)
                                $amount = floatval($discountInPer);
                                $newRegularprice = $regularPrice * ((100-$amount) / 100);
                                update_post_meta( $variationID, '_sale_price',(float) $newRegularprice);
                                update_post_meta( $variationID, '_price',(float) $newRegularprice);
                            }
                          
                        } else {
                            // There is no variaiton for this prod
                            $regularPrice = (float) get_post_meta($prodId,'_regular_price',true); // Regular price
                            $salePrice = (float) get_post_meta($prodId,'_sale_price',true);  // Active price (the "Sale price" when on-sale)
                            $amount = floatval($discountInPer);
                            $newRegularprice = $regularPrice * ((100-$amount) / 100);

                            update_post_meta( $prodId, '_sale_price',(float) $newRegularprice);
                            update_post_meta( $prodId, '_price',(float) $newRegularprice);
                        }

                      

                  }
                  update_option('prod_discount', $discountInPer);

              }
          }
                  update_option('discounted_category', $catIdsArray);
                   wp_redirect( admin_url('edit.php?post_type=product&page=woocommerce-special-dicount&success=true') );

    }
   public function special_discount_plugin_menu() {
        add_submenu_page(
              'edit.php?post_type=product',
              'Woocommerce Category Discount',
              'Category Discount',
              'administrator',
              'woocommerce-special-dicount',
              array($this,'wc_special_discount_main_menu' ));
  }
  public function wc_special_discount_main_menu(){
    require(WC_SPECIAL_DISCOUNT_PATH.'/templates/special-discount-template.php');
  }

  public function lms_scripts_styles(){
  echo '<link rel="stylesheet" href="'.WC_SPECIAL_DISCOUNT_URL.'assets/css/bootstrap.css">';
  }
  public function change_displayed_sale_price_html( $price, $product ) {
    // Only on sale products on frontend and excluding min/max price on variable products
    if( $product->is_on_sale() && ! is_admin() && ! $product->is_type('variable')){
        // Get product prices
        $regular_price = (float) $product->get_regular_price(); // Regular price
        $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)

        // "Saving price" calculation and formatting
        $saving_price = wc_price( $regular_price - $sale_price );

        // "Saving Percentage" calculation and formatting
        $precision = 1; // Max number of decimals
        $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';

        // Append to the formated html price
        $price .= sprintf( __('<p class="saved-sale">Save: %s <em>(%s)</em></p>', 'woocommerce' ), $saving_price, $saving_percentage );
    }
    return $price;
}
}
$SpecialDiscountMain = new SpecialDiscountMain();