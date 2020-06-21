<?php
  function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
    
  }
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
  
//管理者以外は管理バーを非表示//  
function admin_bar_hide($content) {
  if ( current_user_can('administrator') ) {
    return $content;
  } else {
    return false;
  }
}
add_filter( 'show_admin_bar', 'admin_bar_hide' );  
?>
