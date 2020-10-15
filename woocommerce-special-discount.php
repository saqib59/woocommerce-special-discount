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

define('WC_SPECIAL_DISCOUNT_PATH', dirname(__FILE__));
$plugin = plugin_basename(__FILE__);
define('WC_SPECIAL_DISCOUNT_URL', plugin_dir_url($plugin));

require(WC_SPECIAL_DISCOUNT_PATH.'/inc/special-discount-class.php');

