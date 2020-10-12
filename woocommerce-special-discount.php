<?php
/**
* @package w_a_p_l
* @version 1.0
*/
/*
Plugin Name: Woocommerce Special Discount
Plugin URI: #
Description: 
Version: 1.0
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ul_pro
Author URI: #
*/
/*
Copyright (C) Year  Author  Email : charlestsmith888@gmail.com
Woocommerce Advanced plugin layout is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
Woocommerce Advanced plugin layout is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Woocommerce Advanced plugin layout; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('CHI_PATH', dirname(__FILE__));
$plugin = plugin_basename(__FILE__);
define('CHI_URL', plugin_dir_url($plugin));

require CHI_PATH.'/inc/special-discount-class.php';
require CHI_PATH.'/inc/special-discount-menu.php';
require CHI_PATH.'/inc/special-discount-ajax.php';

add_filter( 'woocommerce_get_price_html', 'change_displayed_sale_price_html', 10, 2 );
function change_displayed_sale_price_html( $price, $product ) {
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