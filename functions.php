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

//ショートコードの追加
function register_custom_shortcode($atts) {
  extract(shortcode_atts(array(
    'ids' => '',
  ), $atts));

  $post_ids = explode(',', $ids);

  query_posts(array(
    'post_type' => 'post',
    'orderby' => 'post__in',
    'post__in' => $post_ids
  ));

  ob_start();

  $i = 0;
  if (have_posts()) : ?>
  <ul id="ranking_posts">
    <?php while (have_posts()) : the_post(); $i++; $src = wp_get_attachment_image_src( get_post_thumbnail_id($post_ids[$i-1]), 'full'); ?>
    <li id="ranking-<?php echo $i; ?>" class="each_rank fade-in">
      <?php if( $i== 1 | $i == 2 | $i == 3) : ?>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <img src="/wp-content/uploads/2020/06/mark-<?php echo $i; ?>.png" alt="" />
      <?php else : ?> 
        <h1 class="post-title"><?php echo $i; ?>. <?php the_title(); ?></h1>
      <?php endif; ?>
      <div class="custom_field_val">
        <ul>
          <li>
            <p>ランキング</p>
            <p><?php echo get_field('_overall-score') ?>点</p>
          </li>
          <li>
            <p>着物専門</p>
            <p><?php echo get_field('_kimono-specializing') ?></p>
          </li>
          <li>
            <p>買取スピード</p>
            <p><?php echo get_field('_purchase-speed'); ?></p>
          </li>
          <li>
            <p>宅配買取</p>
            <p><?php echo get_field('_home-delivery'); ?></p>
          </li>
          <li>
            <p>現金受取</p>
            <p><?php echo get_field('_cash-receipt'); ?></p>
          </li>
          <li>
            <p>出張買取</p>
            <p><?php echo get_field('_business-purchase'); ?></p>
          </li>
        </ul>
      </div>
      <div class="flex">
        <div class="image">
          <a href="<?php echo get_field('url'); ?>" target="_blank"><?php if($src!=''){ ?>
            <img src="<?php echo $src[0];?>" alt="" />
            <?php } ?></a>
        </div>
        <div class="point">
          <h2 class="point-ttl">★POINT★</h2>
          <div class="point-wrap">
            <?php the_content(); ?>
          </div>
          <div class="link-wrap">
            <a class="links" href="<?php echo get_field('url'); ?>" target="_blank">⇒<?php echo get_the_title(); ?>はこちら</a>
          </div>
        </div>
      </div>
    </li>
    <?php endwhile; wp_reset_query(); $i = 0; ?>
  </ul>
  <?php endif;
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
function register_shortcodes() {
  add_shortcode('ranking-posts', 'register_custom_shortcode');
}
add_action('init', 'register_shortcodes');
