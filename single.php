<?php
     get_header();
     $dp_options = get_desing_plus_option();
?>

<?php get_template_part('breadcrumb'); ?>

<div id="main_col" class="clearfix">

 <div id="left_col">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div id="article">

   <div id="article_header">

<?php
        if ($dp_options['show_categories']) {
          $metas = array();
          foreach(explode('-', $dp_options['show_categories']) as $cat) {
            if ($cat == 1) {
              $terms = get_the_terms($post->ID, 'category');
              if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                  $metas['category'][] = '<a href="'.get_term_link($term).'" title="'.esc_attr($term->name).'" class="cat-category">'.esc_html($term->name).'</a>';
                }
                $metas['category'] = '<li class="cat">'.implode('', $metas['category']).'</li>';
              }
            } elseif (!empty($dp_options['use_category'.$cat])) {
              $terms = get_the_terms($post->ID, $dp_options['category'.$cat.'_slug']);
              if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                  $metas['category'.$cat][] = '<a href="'.get_term_link($term).'" title="'.esc_attr($term->name).'" class="cat-'.esc_attr($dp_options['category'.$cat.'_slug']).'">'.esc_html($term->name).'</a>';
                }
                $metas['category'.$cat] = '<li class="cat">'.implode('', $metas['category'.$cat]).'</li>';
              }
            }
          }
          if ($metas) {

?>
    <ul id="post_meta_top" class="meta clearfix"><?php echo implode('', $metas); ?></ul>
<?php
          }
        }
?>

    <h2 id="post_title" class="rich_font"><?php the_title(); ?></h2>

<?php if ($dp_options['show_date']){ ?>
    <div id="post_date"><time class="entry-date updated" datetime="<?php the_modified_time('c'); ?>"><?php if($dp_options['show_modified_date']){the_time('Y.m.d'); echo ' / '; _e('Last modified at ', 'tcd-w'); the_modified_time('Y.m.d');}else{the_time('Y.m.d');}; ?></time></div>
<?php } ?>

   </div>

<?php if ($dp_options['show_thumbnail'] && has_post_thumbnail() && $page == '1') { ?>
   <div id="post_image">
    <?php the_post_thumbnail('post-thumbnail'); ?>
   </div>
<?php } ?>

<?php if ($dp_options['show_sns_top']) { ?>
   <div class="single_share" id="single_share_top">
    <?php get_template_part('sns-btn-top'); ?>
   </div>
<?php } ?>

<?php
       // banner 2
       if (!is_mobile()) {
         if ( $dp_options['single_ad_code5'] || $dp_options['single_ad_image5'] || $dp_options['single_ad_code6'] || $dp_options['single_ad_image6'] ) {
  ?>
  <div id="single_banner_area_bottom" class="clearfix<?php if ( !$dp_options['single_ad_code6'] && !$dp_options['single_ad_image6'] ) { echo ' one_banner'; } ?>">
   <?php if ($dp_options['single_ad_code5']) { ?>
   <div class="single_banner single_banner_left">
    <?php echo $dp_options['single_ad_code5']; ?>
   </div>
   <?php } else { ?>
   <?php $single_image5 = wp_get_attachment_image_src( $dp_options['single_ad_image5'], 'full' ); ?>
   <div class="single_banner single_banner_left">
    <a href="<?php esc_attr_e( $dp_options['single_ad_url5'] ); ?>" target="_blank"><img src="<?php echo $single_image5[0]; ?>" alt="" title="" /></a>
   </div>
   <?php } ?>
   <?php if ($dp_options['single_ad_code6']) { ?>
   <div class="single_banner single_banner_right">
    <?php echo $dp_options['single_ad_code6']; ?>
   </div>
   <?php } else { ?>
   <?php $single_image6 = wp_get_attachment_image_src( $dp_options['single_ad_image6'], 'full' ); ?>
   <div class="single_banner single_banner_right">
    <a href="<?php esc_attr_e( $dp_options['single_ad_url6'] ); ?>" target="_blank"><img src="<?php echo $single_image6[0]; ?>" alt="" title="" /></a>
   </div>
   <?php } ?>
  </div><!-- END #single_banner_area_bottom -->
  <?php } ?>
  <?php } else { // if is mobile device ?>
  <?php if ( $dp_options['single_mobile_ad_code1'] || $dp_options['single_mobile_ad_image1'] ) { ?>
  <div id="single_banner_area_bottom" class="clearfix one_banner">
   <?php if ($dp_options['single_mobile_ad_code1']) { ?>
   <div class="single_banner single_banner_left">
    <?php echo $dp_options['single_mobile_ad_code1']; ?>
   </div>
   <?php } else { ?>
   <?php $single_image1 = wp_get_attachment_image_src( $dp_options['single_mobile_ad_image1'], 'full' ); ?>
   <div class="single_banner single_banner_left">
    <a href="<?php esc_attr_e( $dp_options['single_mobile_ad_url1'] ); ?>" target="_blank"><img src="<?php echo $single_image1[0]; ?>" alt="" title="" /></a>
   </div>
   <?php } ?>
  </div><!-- END #single_banner_area -->
<?php
         } // end mobile banner
       }
?>

   <div class="post_content clearfix">
    <h3 class="custom_ttl">★POINT★</h3>
    <?php the_content(__('Read more', 'tcd-w')); ?>
    <?php custom_wp_link_pages(); ?>
   </div>

<?php if ($dp_options['show_sns_btm']) { ?>
   <div class="single_share" id="single_share_bottom">
    <?php get_template_part('sns-btn-btm'); ?>
   </div>
<?php } ?>

<?php if ($dp_options['show_author'] || $dp_options['show_tag'] || $dp_options['show_comment']) { ?>
   <ul id="post_meta_bottom" class="clearfix">
    <?php if ($dp_options['show_author']) : ?><li class="post_author"><?php _e("Author","tcd-w"); ?>: <?php if (function_exists('coauthors_posts_links')) { coauthors_posts_links(', ',', ','','',true); } else { the_author_posts_link(); } ?></li><?php endif; ?>
    <?php if ($dp_options['show_tag']): ?><?php the_tags('<li class="post_tag">',', ','</li>'); ?><?php endif; ?>
    <?php if ($dp_options['show_comment']) : if (comments_open()){ ?><li class="post_comment"><?php _e("Comment","tcd-w"); ?>: <a href="#comment_headline"><?php comments_number( '0','1','%' ); ?></a></li><?php } endif; ?>
   </ul>
<?php } ?>

<?php if ($dp_options['show_next_post']) : ?>
   <div id="previous_next_post_image" class="clearfix">
    <?php next_prev_post_link_image(); ?>
   </div>
<?php endif; ?>

  </div><!-- END #article -->

<?php
      // banner1 ------------------------------------------------------------------------------------------------------------------------
      if (!is_mobile()) {
        if ( $dp_options['single_ad_code1'] || $dp_options['single_ad_image1'] || $dp_options['single_ad_code2'] || $dp_options['single_ad_image2'] ) {
 ?>
 <div id="single_banner_area" class="clearfix<?php if ( !$dp_options['single_ad_code2'] && !$dp_options['single_ad_image2'] ) { echo ' one_banner'; } ?>">
  <?php if ($dp_options['single_ad_code1']) { ?>
  <div class="single_banner single_banner_left">
    <?php echo $dp_options['single_ad_code1']; ?>
   </div>
  <?php } else { ?>
  <?php $single_image1 = wp_get_attachment_image_src( $dp_options['single_ad_image1'], 'full' ); ?>
   <div class="single_banner single_banner_left">
    <a href="<?php esc_attr_e( $dp_options['single_ad_url1'] ); ?>" target="_blank"><img src="<?php echo $single_image1[0]; ?>" alt="" title="" /></a>
   </div>
  <?php } ?>
  <?php if ($dp_options['single_ad_code2']) { ?>
   <div class="single_banner single_banner_right">
    <?php echo $dp_options['single_ad_code2']; ?>
   </div>
  <?php } else { ?>
  <?php $single_image2 = wp_get_attachment_image_src( $dp_options['single_ad_image2'], 'full' ); ?>
   <div class="single_banner single_banner_right">
    <a href="<?php esc_attr_e( $dp_options['single_ad_url2'] ); ?>" target="_blank"><img src="<?php echo $single_image2[0]; ?>" alt="" title="" /></a>
   </div>
  <?php } ?>
 </div><!-- END #single_banner_area -->
 <?php } ?>
 <?php } else { // if is mobile device ?>
 <?php if ( $dp_options['single_mobile_ad_code2'] || $dp_options['single_mobile_ad_image2'] ) { ?>
 <div id="single_banner_area" class="clearfix one_banner">
  <?php if ($dp_options['single_mobile_ad_code2']) { ?>
   <div class="single_banner single_banner_left">
    <?php echo $dp_options['single_mobile_ad_code2']; ?>
   </div>
  <?php } else { ?>
  <?php $single_image2 = wp_get_attachment_image_src( $dp_options['single_mobile_ad_image2'], 'full' ); ?>
   <div class="single_banner single_banner_left">
    <a href="<?php esc_attr_e( $dp_options['single_mobile_ad_url2'] ); ?>" target="_blank"><img src="<?php echo $single_image2[0]; ?>" alt="" title="" /></a>
   </div>
  <?php } ?>
 </div><!-- END #single_banner_area -->
<?php
        } // end mobile banner
      }
?>

<?php endwhile; endif; ?>

<?php
      // related post
      if ($dp_options['show_related_post']) :
        $args = array('post__not_in' => array($post->ID), 'post_type' => 'post', 'posts_per_page'=> $dp_options['related_post_num'], 'orderby' => 'rand');

        $terms = get_the_category($post->ID);
        if ($terms && !is_wp_error($terms)) {
          $tax_query_terms = array();
          foreach($terms as $term) {
            $tax_query_terms[] = $term->term_id;
          }
          $args['tax_query'][] = array('taxonomy' => 'category', 'field' => 'term_id', 'terms' => $tax_query_terms, 'operator' => 'IN');
        }

        for($i = 2; $i <= 3; $i++) {
          if (!empty($dp_options['use_category'.$i])) {
            $terms = get_the_terms($post->ID, $dp_options['category'.$i.'_slug']);
            if ($terms && !is_wp_error($terms)) {
              $tax_query_terms = array();
              foreach($terms as $term) {
                $tax_query_terms[] = $term->term_id;
              }
              $args['tax_query'][] = array('taxonomy' => $dp_options['category'.$i.'_slug'], 'field' => 'term_id', 'terms' => $tax_query_terms, 'operator' => 'IN');
            }
          }
        }

        if (!empty($args['tax_query'])) {
          if (count($args['tax_query']) > 1) {
            $args['tax_query']['relation'] = 'OR';
          }
          $my_query = new WP_Query($args);
          if ($my_query->have_posts()) {
 ?>
 <div id="related_post">
  <h3 class="headline rich_font"><?php echo esc_html( $dp_options['related_post_headline'] ); ?></h3>
  <ol class="clearfix">
<?php       while ($my_query->have_posts()) { $my_query->the_post(); ?>
   <li>
    <a href="<?php the_permalink() ?>">
     <div class="image">
      <?php if (has_post_thumbnail()) { the_post_thumbnail('size2'); } else { echo '<img src="'.get_template_directory_uri().'/img/common/no_image2.gif" alt="" title="" />'; } ?>
     </div>
     <h4 class="title js-ellipsis"><?php the_title(); ?></h4>
    </a>
   </li>
<?php       } wp_reset_postdata(); ?>
  </ol>
 </div>
<?php
          }
        }
      endif;
?>

<?php if ($dp_options['show_comment']) : if (function_exists('wp_list_comments')) { comments_template('', true); } else { comments_template(); } endif; ?>

</div><!-- END #left_col -->

<?php get_sidebar(); ?>

</div><!-- END #main_col -->

<?php get_footer(); ?>
