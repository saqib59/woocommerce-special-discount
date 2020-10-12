<?php 
 function login_register_main_menu(){require CHI_PATH.'/templates/special-discount-template.php';}
add_action('lms_scripts', 'lms_scripts_styles');
function lms_scripts_styles(){
	echo '<link rel="stylesheet" href="'.CHI_URL.'assets/css/bootstrap.css">';
}
add_action("admin_menu", "cspd_imdb_options_submenu");
function cspd_imdb_options_submenu() {
  add_submenu_page(
        'edit.php?post_type=product',
        'Login Register 96',
        'Add discount',
        'administrator',
        'login-register-96',
        'login_register_main_menu' );
}

