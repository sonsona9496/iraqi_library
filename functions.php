<?php

/**
 * Bootscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootscore
 */
 //favorite posts array
 function favorite_id_array() { 
  if (!empty( $_COOKIE['favorite_post_ids'])) {
      return explode(',', $_COOKIE['favorite_post_ids']);
  }
  else {
      return array();
  }
}



//add to favorite function
function add_favorite() {
  $post_id = (int)$_POST['post_id'];
  if (!empty($post_id)) {
      $new_post_id = array(
          $post_id
      );
      $post_ids = array_merge($new_post_id, favorite_id_array());
      $post_ids = array_diff($post_ids, array(
          ''
      ));
      $post_ids = array_unique($post_ids);
      setcookie('favorite_post_ids', implode(',', $post_ids) , time() + 3600 * 24 * 365, '/');
      echo count($post_ids);
  }
  die();
}
add_action('wp_ajax_favorite', 'add_favorite');
add_action('wp_ajax_nopriv_favorite', 'add_favorite');



//delete from favorite function
function delete_favorite() {
  $post_id = (int)$_POST['post_id'];
  if (!empty($post_id)) {
      $favorite_id_array = favorite_id_array();
      if (($delete_post_id = array_search($post_id, $favorite_id_array)) !== false) {
          unset($favorite_id_array[$delete_post_id]);
      }
      setcookie('favorite_post_ids', implode(',', $favorite_id_array) , time() + 3600 * 24 * 30, '/');
      echo count($favorite_id_array);
  }
  die();
}
add_action('wp_ajax_delfavorite', 'delete_favorite');
add_action('wp_ajax_nopriv_delfavorite', 'delete_favorite');
// Get Related Posts
function get_related_posts(){

  $current_post_id = get_the_ID(); // ID of the current post
  $tags = get_the_tags(); // Get tags of the current post

  if ($tags) {
    $tag_ids = array(); // To store tag IDs
    foreach ($tags as $tag) {
      $tag_ids[] = $tag->term_id; // Add tag IDs to the array
    }

    $args = array(
      'tag__in' => $tag_ids, // Get posts with any of the current post's tags
      'post__not_in' => array($current_post_id), // Exclude the current post
      'posts_per_page' => 5, // Number of related posts to display
    );

    $related_posts = new WP_Query($args);
    echo "<h1>مقالات ذات صلة</h1>";
    if ($related_posts->have_posts()) {
      while ($related_posts->have_posts()) {
        $related_posts->the_post();
        ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php
      }
      wp_reset_postdata(); // Reset the query
    } else {
      echo '<p>لا توجد مقالات ذات صلة</p>';
    }
  } else {
    echo '<p>لا يوجد وسم مرتبط بهذه القصة</p>';
  }
}
add_filter('get_related_posts', 'post_link_attributes');

// Function To Get Post Views
function getPostViews($postID){
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count==''){
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
      return "0 <i class='fas fa-eye '></i>";
  }
  return $count.' <i class="fas fa-eye "></i>';
}
// function setPostViews($postID) {
//   $count_key = 'post_views_count';
//   $count = get_post_meta($postID, $count_key, true);
//   if($count==''){
//       $count = 0;
//       delete_post_meta($postID, $count_key);
//       add_post_meta($postID, $count_key, '0');
//   }else{
//       $count++;
//       update_post_meta($postID, $count_key, $count);
//   }
// }
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Add categories
function add_categories_once() {
    $categories = array(
        'ادب نسائي',
        ' الخيال العلمي',
        'الحركة والأكشن ',
        'الخوارق ',
        'الشعر ',
        'تاريخي ',
        'المستذئب ',
        'الفكاهة ',
        'العاطفية ',
        'عشوائي ',
    );
    $taxonomy = 'category';

    foreach ( $categories as $category_name ) {
        $category_slug = sanitize_title( $category_name );

       
        $args = array(
            'description' => 'This is a category description for ' . $category_name,
            'parent'      => 0, 
            'slug'        => $category_slug,
        );
        $result = wp_insert_term( $category_name, $taxonomy, $args );
    }
}
add_categories_once();
// get recent post
function get_recent_post_info() {
  $args = array(
      'numberposts' => 1,
      'orderby'     => 'post_date',
      'order'       => 'DESC',
  );

  $recent_posts = wp_get_recent_posts($args);

  if ($recent_posts) {
      $post = $recent_posts[0];
      $post_info = array(
          'title' => $post['post_title'],
          'content' => $post['post_content'],
          'category' => get_the_category($post['ID'])[0]->name,
          'link' => get_permalink($post['ID']),
          'date' => $post['post_date'],
          'author' => get_the_author_meta('display_name', $post['post_author']),
         
      );
      return $post_info;
  }

  return false; 
}

// Enable WooCommerce scripts if plugin is installed
if (class_exists('WooCommerce')) {
  require get_template_directory() . '/woocommerce/wc-functions.php';
}


// Register Bootstrap 5 Nav Walker
if (!function_exists('register_navwalker')) :
  function register_navwalker() {
    require_once('inc/class-bootstrap-5-navwalker.php');
    // Register Menus
    register_nav_menu('main-menu', 'Main menu');
    register_nav_menu('footer-menu', 'Footer menu');
  }
endif;
add_action('after_setup_theme', 'register_navwalker');
// Register Bootstrap 5 Nav Walker END


// Register Comment List
if (!function_exists('register_comment_list')) :
  function register_comment_list() {
    // Register Comment List
    require_once('inc/comment-list.php');
  }
endif;
add_action('after_setup_theme', 'register_comment_list');
// Register Comment List END


if (!function_exists('bootscore_setup')) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function bootscore_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Bootscore, use a find and replace
     * to change 'bootscore' to the name of your theme in all the template files.
    */
    load_theme_textdomain('bootscore', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
    */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
    add_theme_support('post-thumbnails');

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
    */
    add_theme_support('html5', array(
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
  }
endif;
add_action('after_setup_theme', 'bootscore_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bootscore_content_width() {
  // This variable is intended to be overruled from themes.
  // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
  // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
  $GLOBALS['content_width'] = apply_filters('bootscore_content_width', 640);
}

add_action('after_setup_theme', 'bootscore_content_width', 0);


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// Widgets
if (!function_exists('bootscore_widgets_init')) :

  function bootscore_widgets_init() {

    // Top Nav
    register_sidebar(array(
      'name'          => esc_html__('Top Nav', 'bootscore'),
      'id'            => 'top-nav',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="top-nav-widget ms-2">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>'
    ));

    // Top Nav 2
    // Adds a widget next to the Top Nav position but moves to offcanvas on <lg breakpoint
    register_sidebar(array(
      'name'          => esc_html__('Top Nav 2', 'bootscore'),
      'id'            => 'top-nav-2',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="top-nav-widget-2 d-lg-flex align-items-lg-center mt-2 mt-lg-0 ms-lg-2">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>'
    ));

    // Top Nav Search
    register_sidebar(array(
      'name'          => esc_html__('Top Nav Search', 'bootscore'),
      'id'            => 'top-nav-search',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="top-nav-search">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>'
    ));

    // Sidebar
    register_sidebar(array(
      'name'          => esc_html__('Sidebar', 'bootscore'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<section id="%1$s" class="widget %2$s card card-body mb-4">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title card-header h5">',
      'after_title'   => '</h2>',
    ));

    // Top Footer
    register_sidebar(array(
      'name'          => esc_html__('Top Footer', 'bootscore'),
      'id'            => 'top-footer',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget mb-5">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>'
    ));

    // Footer 1
    register_sidebar(array(
      'name'          => esc_html__('Footer 1', 'bootscore'),
      'id'            => 'footer-1',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title h5">',
      'after_title'   => '</h2>'
    ));

    // Footer 2
    register_sidebar(array(
      'name'          => esc_html__('Footer 2', 'bootscore'),
      'id'            => 'footer-2',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title h5">',
      'after_title'   => '</h2>'
    ));

    // Footer 3
    register_sidebar(array(
      'name'          => esc_html__('Footer 3', 'bootscore'),
      'id'            => 'footer-3',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title h5">',
      'after_title'   => '</h2>'
    ));

    // Footer 4
    register_sidebar(array(
      'name'          => esc_html__('Footer 4', 'bootscore'),
      'id'            => 'footer-4',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title h5">',
      'after_title'   => '</h2>'
    ));

    // Footer Info
    register_sidebar(array(
      'name'          => esc_html__('Footer Info', 'bootscore'),
      'id'            => 'footer-info',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="footer_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="widget-title d-none">',
      'after_title'   => '</div>'
    ));

    // 404 Page
    register_sidebar(array(
      'name'          => esc_html__('404 Page', 'bootscore'),
      'id'            => '404-page',
      'description'   => esc_html__('Add widgets here.', 'bootscore'),
      'before_widget' => '<div class="mb-4">',
      'after_widget'  => '</div>',
      'before_title'  => '<h1 class="widget-title">',
      'after_title'   => '</h1>'
    ));

  }

  add_action('widgets_init', 'bootscore_widgets_init');

endif;
// Widgets END


// Shortcode in HTML-Widget
add_filter('widget_text', 'do_shortcode');
// Shortcode in HTML-Widget End
function loadup_scripts() { 
  wp_enqueue_script( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js' , null, null , true); 
  wp_enqueue_style( 'owl-style-min', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' ); 
  wp_enqueue_style( 'owl-style-def', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css' ); } 
add_action( 'wp_enqueue_scripts', 'loadup_scripts' );
//Enqueue scripts and styles
function bootscore_scripts() {

  // Get modification time. Enqueue files with modification date to prevent browser from loading cached scripts and styles when file content changes.
  $modificated_bootscoreCss   = (file_exists(get_template_directory() . '/css/main')) ? date('YmdHi', filemtime(get_template_directory() . '/css/main.css')) : 1;
  $modificated_styleCss       = date('YmdHi', filemtime(get_stylesheet_directory() . '/style.css'));
  $modificated_fontawesomeCss = date('YmdHi', filemtime(get_template_directory() . '/fontawesome/css/all.min.css'));
  $modificated_fontawesomeCss = date('YmdHi', filemtime(get_template_directory() . '/css/style-theme.css'));
  $modificated_bootstrapJs    = date('YmdHi', filemtime(get_template_directory() . '/js/lib/bootstrap.bundle.min.js'));
  $modificated_themeJs        = date('YmdHi', filemtime(get_template_directory() . '/js/theme.js'));
  $modificated_scriptJs        = date('YmdHi', filemtime(get_template_directory() . '/js/script.js'));
  // $modificated_carouselJs        = date('YmdHi', filemtime(get_template_directory() . '/js/owl.carousel.min.js'));

  // bootScore
  require_once 'inc/scss-compiler.php';
  bootscore_compile_scss();
  // Bootstrap css
  wp_enqueue_style('Bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array());
  wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', array(), $modificated_bootscoreCss);
  // Owl Carousel
  // wp_register_style( 'OwlCarousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
  // wp_enqueue_style('OwlCarousel');
  // wp_register_style( 'OwlCarouselTheme',  'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
  // wp_enqueue_style('OwlCarouselTheme');
  wp_enqueue_style('style-theme', get_template_directory_uri() . '/css/style-theme.css', array());
  // wp_enqueue_style('single-page', get_template_directory_uri() . '/css/single-page.css', array());

  // Style CSS
  wp_enqueue_style('bootscore-style', get_stylesheet_uri(), array(), $modificated_styleCss);
  // wp_enqueue_style('style-theme', get_stylesheet_uri(), array());
  
  // Fontawesome
  wp_enqueue_style('fontawesome', get_template_directory_uri() . '/fontawesome/css/all.min.css', array(), $modificated_fontawesomeCss);

  // Bootstrap JS
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.bundle.min.js', array(), $modificated_bootstrapJs, true);
  // wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, null, true );
  // wp_enqueue_script('jQuery');
  // Theme JS
  wp_enqueue_script('bootscore-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), $modificated_themeJs, true);
  
  // owl.carousel
  // wp_register_script( 'owl_carousel',  'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js' , array( 'jquery'), '' , true);
  // wp_enqueue_script('owl_carousel');
  wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js',array(),false,true);
  
  // IE Warning
  wp_localize_script('bootscore-script', 'bootscore', array(
    'ie_title'                 => __('Internet Explorer detected', 'bootscore'),
    'ie_limited_functionality' => __('This website will offer limited functionality in this browser.', 'bootscore'),
    'ie_modern_browsers_1'     => __('Please use a modern and secure web browser like', 'bootscore'),
    'ie_modern_browsers_2'     => __(' <a href="https://www.mozilla.org/firefox/" target="_blank">Mozilla Firefox</a>, <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a>, <a href="https://www.opera.com/" target="_blank">Opera</a> ', 'bootscore'),
    'ie_modern_browsers_3'     => __('or', 'bootscore'),
    'ie_modern_browsers_4'     => __(' <a href="https://www.microsoft.com/edge" target="_blank">Microsoft Edge</a> ', 'bootscore'),
    'ie_modern_browsers_5'     => __('to display this site correctly.', 'bootscore'),
  ));
  // IE Warning End

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}

add_action('wp_enqueue_scripts', 'bootscore_scripts');
//Enqueue scripts and styles END


// Preload Font Awesome
add_filter('style_loader_tag', 'bootscore_fa_preload');

function bootscore_fa_preload($tag) {

  $tag = preg_replace("/id='fontawesome-css'/", "id='fontawesome-css' online=\"if(media!='all')media='all'\"", $tag);

  return $tag;
}

// Preload Font Awesome END


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/inc/jetpack.php';
}


// Amount of posts/products in category
if (!function_exists('wpsites_query')) :

  function wpsites_query($query) {
    if ($query->is_archive() && $query->is_main_query() && !is_admin()) {
      $query->set('posts_per_page', 24);
    }
  }

  add_action('pre_get_posts', 'wpsites_query');

endif;
// Amount of posts/products in category END


// Pagination Categories
if (!function_exists('bootscore_pagination')) :

  function bootscore_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    global $paged;
    // default page to one if not provided
    if (empty($paged)) $paged = 1;
    if ($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;

      if (!$pages) {
        $pages = 1;
      }
    }

    if (1 != $pages) {
      echo '<nav aria-label="Page navigation" role="navigation">';
      echo '<span class="sr-only">' . esc_html__('Page navigation', 'bootscore') . '</span>';
      echo '<ul class="pagination justify-content-center mb-4">';

      if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link(1) . '" aria-label="' . esc_html__('First Page', 'bootscore') . '">&laquo;</a></li>';
      }

      if ($paged > 1 && $showitems < $pages) {
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($paged - 1) . '" aria-label="' . esc_html__('Previous Page', 'bootscore') . '">&lsaquo;</a></li>';
      }

      for ($i = 1; $i <= $pages; $i ++) {
        if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
          echo ($paged == $i) ? '<li class="page-item active"><span class="page-link"><span class="sr-only">' . __('Current Page', 'bootscore') . ' </span>' . $i . '</span></li>' : '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '"><span class="sr-only">' . __('Page', 'bootscore') . ' </span>' . $i . '</a></li>';
        }
      }

      if ($paged < $pages && $showitems < $pages) {
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link(($paged === 0 ? 1 : $paged) + 1) . '" aria-label="' . esc_html__('Next Page', 'bootscore') . '">&rsaquo;</a></li>';
      }

      if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($pages) . '" aria-label="' . esc_html__('Last Page', 'bootscore') . '">&raquo;</a></li>';
      }

      echo '</ul>';
      echo '</nav>';
      // Uncomment this if you want to show [Page 2 of 30]
      // echo '<div class="pagination-info mb-5 text-center">[ <span class="text-muted">' . __('Page', 'bootscore') . '</span> '.$paged.' <span class="text-muted">' . __('of', 'bootscore') . '</span> '.$pages.' ]</div>';
    }
  }

endif;
//Pagination Categories END


// Pagination Buttons Single Posts
add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

function post_link_attributes($output) {
  $code = 'class="page-link"';

  return str_replace('<a href=', '<a ' . $code . ' href=', $output);
}

// Pagination Buttons Single Posts END


// Excerpt to pages
add_post_type_support('page', 'excerpt');
// Excerpt to pages END


// Breadcrumb
if (!function_exists('the_breadcrumb')) :
  function the_breadcrumb() {

    if (!is_home()) {
      echo '<nav aria-label="breadcrumb" class="breadcrumb-scroller mb-4 mt-2 py-2 px-3 bg-body-tertiary rounded">';
      echo '<ol class="breadcrumb mb-0">';
      echo '<li class="breadcrumb-item"><a href="' . home_url() . '">' . '<i class="fa-solid fa-house"></i>' . '</a></li>';
      // display parent category names with links
      if (is_category() || is_single()) {
        $cat_IDs = wp_get_post_categories(get_the_ID());
        foreach ($cat_IDs as $cat_ID) {
          $cat = get_category($cat_ID);
          echo '<li class="breadcrumb-item"><a href="' . get_term_link($cat->term_id) . '">' . $cat->name . '</a></li>';
        }
      }
      // display current page name
      if (is_page() || is_single()) {
        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
      }
      echo '</ol>';
      echo '</nav>';
    }
  }

  add_filter('breadcrumbs', 'breadcrumbs');
endif;
// Breadcrumb END


// Comment Button
if (!function_exists('bootscore_comment_button')) :
  function bootscore_comment_button($args) {
    $args['class_submit'] = 'btn btn-outline-primary'; // since WP 4.1

    return $args;
  }

  add_filter('comment_form_defaults', 'bootscore_comment_button');
endif;
// Comment Button END


// Password protected form
if (!function_exists('bootscore_pw_form')) :
  function bootscore_pw_form() {
    $output = '
        <form action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post" class="input-group pw_form">' . "\n"
              . '<input name="post_password" type="password" size="" class="form-control" placeholder="' . __('Password', 'bootscore') . '"/>' . "\n"
              . '<input type="submit" class="btn btn-outline-primary input-group-text" name="Submit" value="' . __('Submit', 'bootscore') . '" />' . "\n"
              . '</form>' . "\n";

    return $output;
  }

  add_filter("the_password_form", "bootscore_pw_form");
endif;
// Password protected form END


// Allow HTML in term (category, tag) descriptions
foreach (array('pre_term_description') as $filter) {
  remove_filter($filter, 'wp_filter_kses');
  if (!current_user_can('unfiltered_html')) {
    add_filter($filter, 'wp_filter_post_kses');
  }
}

foreach (array('term_description') as $filter) {
  remove_filter($filter, 'wp_kses_data');
}
// Allow HTML in term (category, tag) descriptions END


// Allow HTML in author bio
remove_filter('pre_user_description', 'wp_filter_kses');
add_filter('pre_user_description', 'wp_filter_post_kses');
// Allow HTML in author bio END


// Hook after #primary
function bs_after_primary() {
  do_action('bs_after_primary');
}

// Hook after #primary END


// Open links in comments in new tab
if (!function_exists('bs_comment_links_in_new_tab')) :
  function bs_comment_links_in_new_tab($text) {
    return str_replace('<a', '<a target="_blank" rel=”nofollow”', $text);
  }

  add_filter('comment_text', 'bs_comment_links_in_new_tab');
endif;
// Open links in comments in new tab END


// Disable Gutenberg blocks in widgets (WordPress 5.8)
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
// Disables the block editor from managing widgets.
add_filter('use_widgets_block_editor', '__return_false');
// Disable Gutenberg blocks in widgets (WordPress 5.8) END
//


/*
 * Simple short code for inserting font awesome icons on Gutenberg leveli
 * (instead of heaving to insert HTML code into a block on HTML editing mode)
 */
function bsfaCode($atts) {
  $atts = (array) $atts;
  $vstr = "";
  foreach ($atts as $value) {
    $vstr = $vstr . " $value";
  }

  return '<i class="' . $vstr . '"></i>';
}

;
add_shortcode('bsfa', 'bsfaCode');

function category_name_archive() {
  if ( is_category() )  {
      echo '<h1 class="archive-title">';
      echo single_cat_title();
      echo '</h1>';
    }
  }
  add_action( 'genesis_before_loop' , 'themeprefix_category_header' );