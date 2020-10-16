<?php
/**
* @package woocommerce_special_discount
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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/*if( ! function_exists( 'wc_special_discount_constructor' ) ) {
	function wc_special_discount_constructor() {

        // Let's start the game!
    }
}


add_action( 'wc_special_discount_init', 'wc_special_discount_constructor' );*/

if( ! function_exists( 'wc_special_discount_install' ) ) {
    function wc_special_discount_install() {

        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        if ( ! function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'woocommerce_special_discount_activate_error' );
        }
       
        else {
				require(WC_SPECIAL_DISCOUNT_PATH.'/inc/special-discount-class.php');
        }
    }
}
add_action( 'plugins_loaded', 'wc_special_discount_install', 11 );

if( ! function_exists( 'woocommerce_special_discount_activate_error' ) ) {
    function woocommerce_special_discount_activate_error() {
    	/**
		 * Check if WooCommerce is active
		 **/
        ?>
        <div class="error">
            <p><?php echo 'Woocommerce Special Discount ' . __( 'is enabled but not effective. It requires WooCommerce in order to work.', 'woocommerce-special-discount' ); ?></p>
        </div>
    <?php
    }
}


if (! define('WC_SPECIAL_DISCOUNT_PATH')) {
	define('WC_SPECIAL_DISCOUNT_PATH', dirname(__FILE__));
}
if (! define('WC_SPECIAL_DISCOUNT_URL')) {
	$plugin = plugin_basename(__FILE__);
	define('WC_SPECIAL_DISCOUNT_URL', plugin_dir_url($plugin));
}
