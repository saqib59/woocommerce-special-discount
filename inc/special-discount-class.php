<?php
// ini_set('max_execution_time', 0);

class SpecialDiscountMain{

    public $loginregister96_login = array();
    public $loginregister96_register = array();

    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this , 'login_register96_scripts') );
        add_action('admin_enqueue_scripts',array($this, 'login_register96_scripts'));
        
  }
  public function login_register96_scripts(){
   wp_enqueue_script( 'sweet-alert', 'https://cdn.jsdelivr.net/npm/sweetalert2@9','','',true);
    wp_enqueue_script( 'jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js','','',true);
    wp_enqueue_script( 'main-script', CHI_URL.'/assets/js/main-script.js', '', '', true );
      wp_localize_script('main-script', 'object',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        )
    );
  
    ?>
    <?php

  }
  public function get_all_wc_categories(){
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
             $checked ='';

             foreach ($all_categories as $cat) {
                if($cat->category_parent == 0) {
                    $category_id = $cat->term_id;
                    if ($categories_array[$index] == get_option('prod_discount')) {
                      $checked = 'checked';
                    }
                  
                    $categories_array[$index] ='<option value="'.$cat->cat_ID.'" "'.$checked.'" > '.$cat->name. '</option>';
                  }
                  $index++;
                } 

                return $categories_array;
  }

}
$SpecialDiscountMain = new SpecialDiscountMain();