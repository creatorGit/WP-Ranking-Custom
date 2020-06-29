<?php
global $dp_options, $wp_query, $header_slider, $custom_search_vars;
if ( ! $dp_options ) $dp_options = get_desing_plus_option();

$footer_navs = array();
$dp_options['use_category'] = 1; // カテゴリーは常時利用でテーマオプションには存在しないが判別のためここで設定
if ($dp_options['footer_nav_type1'] != 'none' && $dp_options['use_'.$dp_options['footer_nav_category1']]) {
	$footer_navs[] = 1;
}
if ($dp_options['footer_nav_type2'] != 'none' && $dp_options['use_'.$dp_options['footer_nav_category2']]) {
	$footer_navs[] = 2;
}
?>

 </div><!-- END #main_contents -->

 <div id="footer">

<?php if ($footer_navs) { ?>
  <div id="footer_nav">
   <div class="inner">
<?php   if (count($footer_navs) > 1) { ?>
    <div class="footer_nav_cols clearfix">
<?php   } ?>
<?php
        foreach($footer_navs as $footer_nav_id) {
          if ($dp_options['footer_nav_type'.$footer_nav_id] != 'none') {
            $tax_label = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_label'];
            $tax_color = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_color'];
            if ($dp_options['footer_nav_category'.$footer_nav_id] == 'category') {
              $tax_slug = 'category';
            } else {
              $tax_slug = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_slug'];
            }
?>
     <div class="footer_nav_col footer_nav_<?php echo esc_attr($footer_nav_id); ?> footer_nav_<?php echo esc_attr($tax_slug); ?> footer_nav_<?php echo esc_attr($dp_options['footer_nav_type'.$footer_nav_id]); ?>">
      <div class="headline" style="background:<?php echo esc_attr($tax_color); ?>;"><?php echo esc_html($tax_label); ?></div>
      <ul<?php if ($dp_options['footer_nav_type'.$footer_nav_id] == 'type1') echo ' class="clearfix"'; ?>>
<?php
            $terms = get_terms($tax_slug, array('hide_empty' => false, 'parent' => 0));
            if ($terms && !is_wp_error($terms)) {
              foreach($terms as $term) {
                echo '       <li>';
                echo '<a href="'.get_term_link($term).'">'.esc_html($term->name).'</a>';
                if ($dp_options['footer_nav_type'.$footer_nav_id] == 'type2') {
                  $terms2 = get_terms($tax_slug, array('hide_empty' => false, 'parent' => $term->term_id));
                  if ($terms2) {
                    echo '<ul>';
                    foreach($terms2 as $term2) {
                      echo '<li><a href="'.get_term_link($term2).'">'.esc_html($term2->name).'</a></li>';
                    }
                    echo '</ul>';
                  }
                }
                echo "</li>\n";
              }
            }
?>
      </ul>
     </div>
<?php
          }
        }
?>
<?php   if (count($footer_navs) > 1) { ?>
    </div>
<?php   } ?>
   </div>
  </div>
<?php } ?>

  <div id="footer_contents">
   <div class="inner">

<?php
      if ($dp_options['footer_widget_type'] == 'type1') {
        if (!is_mobile() || is_no_responsive()) {
          $footer_widget = 'footer_widget';
        } else {
          $footer_widget = 'footer_widget_mobile';
        }
        if (is_active_sidebar($footer_widget)) {
?>
    <div id="footer_widget" class="footer_widget_type1">
     <?php dynamic_sidebar($footer_widget); ?>
    </div>
<?php
        }
      } elseif ($dp_options['footer_widget_type'] == 'type2') {
        $footer_widget_vars = array();
        if (!is_mobile() || is_no_responsive()) {
          if ($dp_options['footer_ad_image']) {
            $footer_widget_vars['footer_ad_image_src'] = wp_get_attachment_image_src($dp_options['footer_ad_image'], 'full');
          }
          $footer_widget_vars['footer_ad_image'] = $dp_options['footer_ad_image'];
          $footer_widget_vars['footer_ad_code'] = $dp_options['footer_ad_code'];
          $footer_widget_vars['footer_ad_url'] = $dp_options['footer_ad_url'];
        } else {
          if ($dp_options['footer_ad_image_mobile']) {
            $footer_widget_vars['footer_ad_image_src'] = wp_get_attachment_image_src($dp_options['footer_ad_image_mobile'], 'full');
            $footer_widget_vars['footer_ad_image'] = $dp_options['footer_ad_image_mobile'];
          } elseif ($dp_options['footer_ad_image']) {
            $footer_widget_vars['footer_ad_image_src'] = wp_get_attachment_image_src($dp_options['footer_ad_image'], 'full');
            $footer_widget_vars['footer_ad_image'] = $dp_options['footer_ad_image'];
          }else{
            $footer_widget_vars['footer_ad_image_src'] = '';
            $footer_widget_vars['footer_ad_image'] = '';
          }
          if($dp_options['footer_ad_url_mobile']){
            $footer_widget_vars['footer_ad_url'] = $dp_options['footer_ad_url_mobile'];
          }elseif($dp_options['footer_ad_url']){
            $footer_widget_vars['footer_ad_url'] = $dp_options['footer_ad_url'];
          }else{
            $footer_widget_vars['footer_ad_url'] = '';
          }
          if($dp_options['footer_ad_code_mobile']){
            $footer_widget_vars['footer_ad_code'] = $dp_options['footer_ad_code_mobile'];
          }elseif($dp_options['footer_ad_code']){
            $footer_widget_vars['footer_ad_code'] = $dp_options['footer_ad_code'];
          }else{
            $footer_widget_vars['footer_ad_code'] = '';
          }
        }
        if ($dp_options['footer_banner_image1']) {
          $footer_widget_vars['footer_banner_image1_src'] = wp_get_attachment_image_src($dp_options['footer_banner_image1'], 'full');
        }
        if ($dp_options['footer_banner_image2']) {
          $footer_widget_vars['footer_banner_image2_src'] = wp_get_attachment_image_src($dp_options['footer_banner_image2'], 'full');
        }
        if ($footer_widget_vars['footer_ad_code'] || !empty($footer_widget_vars['footer_ad_image_src'][0]) || $dp_options['footer_menu1'] || $dp_options['footer_menu2'] || !empty($footer_widget_vars['footer_banner_image1_src'][0]) || !empty($footer_widget_vars['footer_banner_image2_src'][0])) {
?>
    <div id="footer_widget" class="footer_widget_type2">
<?php
          if ($footer_widget_vars['footer_ad_code'] || !empty($footer_widget_vars['footer_ad_image_src'][0])) {
            the_widget(
              'ml_ad_widget',
              array(
                'banner_code1' => $footer_widget_vars['footer_ad_code'], 'banner_image1' => $footer_widget_vars['footer_ad_image'], 'banner_url1' => $footer_widget_vars['footer_ad_url'],
                'banner_code2' => '', 'banner_image2' => '', 'banner_url2' => '',
                'banner_code3' => '', 'banner_image3' => '', 'banner_url3' => ''
              ),
              array(
                'before_widget' => '<div class="widget footer_widget %s">'."\n",
                'after_widget' => "</div>\n",
                'before_title' => '<h3 class="footer_headline rich_font">',
                'after_title' => "</h3>\n",
              )
            );
          }

          if ($dp_options['footer_menu1']) {
            the_widget(
              'WP_Nav_Menu_Widget',
              array(
                'title' => '',
                'nav_menu' => $dp_options['footer_menu1']
              ),
              array(
                'before_widget' => '<div class="widget footer_widget %s">'."\n",
                'after_widget' => "</div>\n",
                'before_title' => '<h3 class="footer_headline rich_font">',
                'after_title' => "</h3>\n",
              )
            );
          }

          if ($dp_options['footer_menu2']) {
            the_widget(
              'WP_Nav_Menu_Widget',
              array(
                'title' => '',
                'nav_menu' => $dp_options['footer_menu2']
              ),
              array(
                'before_widget' => '<div class="widget footer_widget %s">'."\n",
                'after_widget' => "</div>\n",
                'before_title' => '<h3 class="footer_headline rich_font">',
                'after_title' => "</h3>\n",
              )
            );
          }

          if (!empty($footer_widget_vars['footer_banner_image1_src'][0]) || !empty($footer_widget_vars['footer_banner_image2_src'][0])) {
            the_widget(
              'tcdw_banner_list_widget',
              array(
                'title' => '',
                'banner_title1' => $dp_options['footer_banner_title1'],
                'banner_url1' => $dp_options['footer_banner_url1'],
                'banner_target_blank1' => $dp_options['footer_banner_target_blank1'],
                'banner_image1' => $dp_options['footer_banner_image1'],
                'banner_shadow_a1' => $dp_options['footer_banner_shadow_a1'],
                'banner_shadow_b1' => $dp_options['footer_banner_shadow_b1'],
                'banner_shadow_c1' => $dp_options['footer_banner_shadow_c1'],
                'banner_shadow_color1' => $dp_options['footer_banner_shadow_color1'],
                'banner_title2' => $dp_options['footer_banner_title2'],
                'banner_url2' => $dp_options['footer_banner_url2'],
                'banner_target_blank2' => $dp_options['footer_banner_target_blank2'],
                'banner_image2' => $dp_options['footer_banner_image2'],
                'banner_shadow_a2' => $dp_options['footer_banner_shadow_a2'],
                'banner_shadow_b2' => $dp_options['footer_banner_shadow_b2'],
                'banner_shadow_c2' => $dp_options['footer_banner_shadow_c2'],
                'banner_shadow_color2' => $dp_options['footer_banner_shadow_color2'],
              ),
              array(
                'before_widget' => '<div class="widget footer_widget %s">'."\n",
                'after_widget' => "</div>\n",
                'before_title' => '<h3 class="footer_headline rich_font">',
                'after_title' => "</h3>\n",
              )
            );
          }
?>
    </div>
<?php
        }
      }
?>

    <div id="footer_info">
     <div id="footer_logo">
      <?php //footer_logo(); ?>
     </div>

<?php if ($dp_options['show_rss'] || $dp_options['twitter_url'] || $dp_options['facebook_url'] || $dp_options['insta_url']) { ?>
     <ul id="footer_social_link">
<?php   if ($dp_options['twitter_url']) : ?>
      <li class="twitter"><a href="<?php echo esc_url($dp_options['twitter_url']); ?>" target="_blank">Twitter</a></li>
<?php   endif; ?>
<?php   if ($dp_options['facebook_url']) : ?>
      <li class="facebook"><a href="<?php echo esc_url($dp_options['facebook_url']); ?>" target="_blank">Facebook</a></li>
<?php   endif; ?>
<?php   if ($dp_options['insta_url']) : ?>
      <li class="insta"><a href="<?php echo esc_url($dp_options['insta_url']); ?>" target="_blank">Instagram</a></li>
<?php   endif; ?>
<?php   if ($dp_options['show_rss']) : ?>
      <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>" target="_blank">RSS</a></li>
<?php   endif; ?>
     </ul>
<?php } ?>

<?php
       if (has_nav_menu('footer-bottom-menu')) {
         wp_nav_menu( /*array( 'sort_column' => 'menu_order', 'theme_location' => 'footer-bottom-menu' , 'container_id' => 'footer_bottom_menu', 'depth' => 1 )*/ );
       }
?>

     <p id="copyright"><span><?php _e('Copyright ', 'tcd-w'); ?></span>&copy; 2020 <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a> All Rights Reserved.</p>

    </div><!-- END #footer_info -->
   </div><!-- END .inner -->
  </div><!-- END #footer_contents -->

  <div id="return_top">
   <a href="#body"><span><?php _e('PAGE TOP', 'tcd-w'); ?></span></a>
  </div><!-- END #return_top -->

 </div><!-- END #footer -->

<?php
      // footer menu for mobile device
      if( is_mobile() ) get_template_part('footer-bar');
?>

<script>

<?php if(is_mobile()) { ?>
jQuery(window).bind("pageshow", function(event) {
  if (event.originalEvent.persisted) {
    window.location.reload()
  }
});
<?php } ?>

jQuery(document).ready(function($){
  $('.inview-fadein').css('opacity', 0);
<?php
    // blog archive
    if (!is_front_page() && (is_home() || is_search() || $custom_search_vars || (is_archive() && !is_post_type_archive(array($dp_options['news_slug'], $dp_options['introduce_slug']))))) {
?>
  $('#post_list .article, #post_list2 .article, .page_navi, .page_navi2').css('opacity', 0);
<?php
    }
?>

  var initialize = function(){
    $('.js-ellipsis').textOverflowEllipsis();

<?php
    // トップページ
    if (is_front_page()) {

      // 画像スライダー
      if (!empty($header_slider['slider'])) {
?>
    $('#header_slider').slick({
      infinite: true,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
      nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true,
      autoplay: true,
      lazyLoad: 'progressive',
      speed: 1000,
      autoplaySpeed: <?php if ($dp_options['slider_time'] && is_numeric($dp_options['slider_time'])) { echo intval($dp_options['slider_time']); } else { echo 7000; } ?>
    });

<?php
      // 動画
      } elseif (!empty($header_slider['slider_video']) && !wp_is_mobile()) {
?>
    $('#slider_video').vegas({
      timer: false,
      slides: [
        { <?php if (!empty($header_slider['slider_video_image'][0])) { ?>src: '<?php echo esc_attr($header_slider['slider_video_image'][0]); ?>',<?php } ?>
          video: {
            src: [ '<?php echo esc_attr($header_slider['slider_video']); ?>' ], loop: true, mute: true
          },
        }
      ]
    });

<?php
      // youtube
      } elseif (!empty($header_slider['slider_youtube_url']) && !wp_is_mobile()) {
?>
     $('#slider_youtube').YTPlayer();

<?php
      }

      // コンテンツビルダー カルーセル
      if ( ! empty( $dp_options['contents_builder'] ) ) {
        foreach ( $dp_options['contents_builder'] as $key => $content ) {
          if ( empty( $content['cb_content_select'] ) ) continue;
          if ( isset( $content['cb_display'] ) && ! $content['cb_display'] ) continue;
          if ( $content['cb_content_select'] == 'carousel' ) {
?>
    $('.carousel').slick({
      infinite: true,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
      nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
      slidesToShow: 3,
      slidesToScroll: 3,
      adaptiveHeight: false,
      autoplay: true,
      speed: 1000,
      autoplaySpeed: 10000,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 481,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });

<?php
            break;
          }
        }
      }

    // introduce archive
    } elseif (!empty($GLOBALS['introduce_archive']) && !$custom_search_vars) {
?>
    var $container = $('#introduce_list');
    $container.imagesLoaded(function(){
        init_introduce_list_col();

<?php   if (!$dp_options['use_infinitescroll_introduce'] && $wp_query->max_num_pages > 1) { ?>
      $('#load_post').show();
<?php   } ?>

      $container.infinitescroll(
        {
          navSelector  : '#load_post',
          nextSelector : '#load_post a',
          itemSelector : '.introduce_list_row',
          animate      : false,
          maxPage: <?php echo $wp_query->max_num_pages; ?>,
          loading: {
            msgText : '<?php _e('Loading post...', 'tcd-w'); ?>',
            finishedMsg : '<?php _e('No more post', 'tcd-w'); ?>',
            img: '<?php echo get_template_directory_uri(); ?>/img/common/loader.gif'
          }
        },
        //callback
        function(newElements, opts) {
          $(newElements).find('.inview-fadein').css('opacity', 0);
          $('#infscr-loading').remove();
          init_introduce_list_col();
          $(window).trigger('scroll');

<?php   if (!$dp_options['use_infinitescroll_introduce']) { ?>
          if (opts.maxPage && opts.maxPage > opts.state.currPage) {
            $('#load_post').show();
          }
<?php   } else { ?>
          if (opts.maxPage && opts.maxPage <= opts.state.currPage) {
            $(window).off('.infscr');
            $('#load_post').remove();
          }
<?php   } ?>

        }
      );

<?php   if (!$dp_options['use_infinitescroll_introduce']) { ?>
      $(window).off('.infscr');
      $('#load_post a').click(function(){
        $('#load_post').hide();
        $container.infinitescroll('retrieve');
        return false;
      });
<?php   } ?>

    });

<?php
    // blog archive
    } elseif (is_home() || is_search() || $custom_search_vars || (is_archive() && !is_post_type_archive($dp_options['news_slug']))) {
?>
    if ($('#post_list .article, #post_list2 .article, .page_navi, .page_navi2').length) {
      $('#post_list, #post_list2').imagesLoaded(function(){
        $('#post_list .article, #post_list2 .article, .page_navi, .page_navi2').each(function(i){
          var self = this;
          setTimeout(function(){
            $(self).animate({ opacity: 1 }, 200);
          }, i*200);
        });
      });
    }

<?php
    // introduce slider
    } elseif (is_singular($dp_options['introduce_slug']) && !empty($GLOBALS['introduce_slider'])) {
?>
    var set_slick_dots_bottom_timer;
    var set_slick_dots_bottom = function(i, init){
      clearTimeout(set_slick_dots_bottom_timer);
      var $dots = $('#introduce_slider .slick-dots');
      var cap_h = $('#introduce_slider .item').eq(i).find('.caption').outerHeight() || 0;
      if (init) {
        if (cap_h) {
          $dots.css('bottom', cap_h + 16);
        } else {
          $dots.css('bottom', 16);
        }
        $dots.animate({ opacity: 1 }, 1000);
      } else {
        if (cap_h) {
          $dots.animate({ bottom: cap_h + 16 }, 1000);
        } else {
          $dots.animate({ bottom: 16 }, 1000);
        }
      }
    };
    $('#introduce_slider').on('init', function(slick){
      set_slick_dots_bottom(0, true)
    });
    $('#introduce_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
      set_slick_dots_bottom(nextSlide)
    });
    $(window).on('resize orientationchange', function(){
      clearTimeout(set_slick_dots_bottom_timer);
      set_slick_dots_bottom_timer = setTimeout(function(){
        set_slick_dots_bottom($('#introduce_slider .item.slick-current').index());
      }, 100);
    });

    $('#introduce_slider').slick({
      infinite: true,
      dots: true,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      adaptiveHeight: true,
      autoplay: true,
      lazyLoad: 'progressive',
      speed: 1000,
      autoplaySpeed: <?php if (!empty($GLOBALS['introduce_slider']['slider_time']) && is_numeric($GLOBALS['introduce_slider']['slider_time'])) { echo intval($GLOBALS['introduce_slider']['slider_time']); } else { echo 7000; } ?>
    });

<?php
    }
?>

    if ($('.inview-fadein').length) {
      $(window).on('load scroll resize', function(){
        $('.inview-fadein:not(.active)').each(function(){
          var elmTop = $(this).offset().top || 0;
          if ($(window).scrollTop() > elmTop - $(window).height()){
            if ($(this).is('#post_list')) {
              var $articles = $(this).find('.article, .archive_link');
              $articles.css('opacity', 0);
              $(this).addClass('active').css('opacity', 1);
              $articles.each(function(i){
                var self = this;
                setTimeout(function(){
                  $(self).animate({ opacity: 1 }, 200);
                }, i*200);
              });
            } else {
              $(this).addClass('active').animate({ opacity: 1 }, 800);
            }
          }
        });
      });
    }

    $(window).trigger('resize');
  };


<?php if ($dp_options['use_load_icon']) { ?>
  function after_load() {
    $('#site_loader_animation').delay(300).fadeOut(600);
    $('#site_loader_overlay').delay(600).fadeOut(900, initialize);
  }

  $(window).load(function () {
    after_load();
  });

  setTimeout(function(){
    if ($('#site_loader_overlay').not(':animated').is(':visible')) {
      after_load();
    }
  }, <?php if($dp_options['load_time']) { echo esc_html($dp_options['load_time']); } else { echo '7000'; }; ?>);

<?php } else { ?>

  initialize();

<?php } ?>

});
</script>

<?php if (is_singular() && !is_page()) { ?>
<!-- facebook share button code -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php } ?>

<?php if( is_mobile() ) { ?>
<?php if($dp_options['footer_bar_display'] == 'type1') { ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/footer-bar.js?ver=<?php echo version_num(); ?>"></script>
<?php }elseif($dp_options['footer_bar_display'] == 'type2'){ ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/footer-bar2.js?ver=<?php echo version_num(); ?>"></script>
<?php }; ?>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>
