<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
?>
<section class="section-one">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="content">
          <span class="content-recent-stories">القصص الاحدث</span>
          <?php $recent_post = get_recent_post_info(); ?>
          <div class='content-heading'>
            <h2>
              <?php if ($recent_post) {
                echo $recent_post['title']; ?>
            </h2>
            <span class="evaluation"><i class="fas fa-star"></i> 7.2</span>
            <span class='categories'> الفئة/</span>
            <?php echo $recent_post['category'] ?>
            </div>
            <?php the_excerpt();?>
            <div class='content-bottom'>
              <!-- Favorite Btn -->
              <?php if(in_array($post->ID, favorite_id_array())){ ?>
              <div class="fv_<?php echo $post->ID; ?>" title="تم الاضافة المفضلة" ><i class="fas fa-heart add-to-favo"></i></div>
              <?php } else { ?>
              <div class="fv_<?php echo $post->ID; ?>" >
                  <div class="add-favorite" title="اضافة الى المفضلة" data-post_id="<?php echo $post->ID; ?>">
                    <i class="fas fa-heart"></i>
                  </div>
              </div>
              <?php } ?>
              <a href="<?php echo $recent_post['link'];
              } ?>" class='read-more'>أقرأ الان</a>
            <span> <i class="fal fa-plus"></i> أضف الى القائمة</span>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="cont-img">
          <?php the_post_thumbnail('') ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Section One Recent Stories -->
<!-- Start All Categories -->
<section class="all-categories">
  <?php
  //for each category, show all posts
  $cat_args=array(
    'orderby' => 'name',
    'order' => 'DESC'
    );
  $categories=get_categories($cat_args);
  ?>
  <div class="container">
    <?php $categories = get_categories();
    if ($categories) {
      ?>
        <div class="owl-categories owl-carousel owl-theme">
        <?php
        foreach ($categories as $category) {
          echo '<div class="item item-link"><a class="" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></div>';
        }
    }
    ?>
    </div>
  </div>
</section>
<!-- End All Categories -->
<!-- Start Section Featured stories -->
<section class="featured-stories">
  <div class="container">
    <h1>القصص المميزة</h1>
    <?php
        $top_rated_posts = rmp_get_top_rated_posts(10, 1); // Retrieve top-rated posts with a rating of at least 3 and 3 or more votes.
        if ($top_rated_posts && is_array($top_rated_posts)) {
      ?>
    <div class="owl-featured-stories owl-carousel owl-theme">
      <?php foreach ($top_rated_posts as $post_data) { 
        $post_id = $post_data['postID'];?>
      <div class="item cards">
          <div class="cont-image">
            <?php the_post_thumbnail($post_id) ?>
            <div class="info">
              
              <span>
                <!-- Favorite Btn -->
                <?php if(in_array($post->ID, favorite_id_array())){ ?>
                <div class="fv_<?php echo $post->ID; ?>" title="تم الاضافة المفضلة" ><i class="fas fa-heart add-to-favo"></i></div>
                <?php } else { ?>
                <div class="fv_<?php echo $post->ID; ?>" >
                    <div class="add-favorite" title="اضافة الى المفضلة" data-post_id="<?php echo $post->ID; ?>">
                      <i class="fas fa-heart"></i>
                    </div>
                </div>
                <?php } ?>
              </span>
              <span><i class="fas fa-share "></i></span>
            </div>
            <span class="rate-story"><i class="fas fa-star"></i><?php echo rmp_get_avg_rating($post_id);?></span>
          </div>
          <div class="cards-content">
            <h4 class="title"><a href="<?php echo get_permalink($post_id)?>"> <?php the_title(); ?></a></h4>
            <div class="details">
                <span>الكاتب : <strong><?php the_author($post_id)?></strong> </span>
                <span class="profession">الفئة : </span>
            </div>
            <p class="card-btn">
              <a class="read-more" href="<?php the_permalink(); ?>">
                <?php _e('اقرأ الان <i class="fas fa-long-arrow-alt-left"></i> '); ?>
              </a>
            </p>
          </div>
      </div>
      <?php }?>
    </div>     
    <?php }?>                                                    
  </div>
</section>
<!-- End Section Featured stories -->
<!-- Start Section Best Option stories -->
<section class="best-stories">
  <div class="container">
    <h1> افضل الخيارات</h1>
    <?php
      $category_slug = 'الخيارات';
      $args = array(
        'category_name' => $category_slug,
        'posts_per_page' => 10,
      );
      $query = new WP_Query($args);
      if ($query->have_posts()) { ?>
    <div class="owl-best-stories owl-carousel owl-theme">
        <?php while ($query->have_posts()) {
          $query->the_post();?>
      <div class="item cards">
          <div class="cont-image">
            <?php the_post_thumbnail() ?>
            <div class="info">
              <span>
                <!-- Favorite Btn -->
                <?php if(in_array($post->ID, favorite_id_array())){ ?>
                <div class="fv_<?php echo $post->ID; ?>" title="تم الاضافة المفضلة" ><i class="fas fa-heart add-to-favo"></i></div>
                <?php } else { ?>
                <div class="fv_<?php echo $post->ID; ?>" >
                    <div class="add-favorite" title="اضافة الى المفضلة" data-post_id="<?php echo $post->ID; ?>">
                      <i class="fas fa-heart"></i>
                    </div>
                </div>
                <?php } ?>
              </span>
              <span><i class="fas fa-share "></i></span>
            </div>
            <span class="rate-story"><i class="fas fa-star"></i><?php echo rmp_get_avg_rating();?></span>
          </div>
          <div class="cards-content">
            <h4 class="title"><a href="<?php echo get_permalink()?>"> <?php the_title(); ?></a></h4>
            <div class="details">
                <span>الكاتب : <strong><?php the_author()?></strong> </span>
                <span class="profession">الفئة : <strong><?php the_category()?></strong> </span>
            </div>
            <p class="card-btn">
              <a class="read-more" href="<?php the_permalink(); ?>">
                <?php _e('اقرأ الان <i class="fas fa-long-arrow-alt-left"></i> '); ?>
              </a>
            </p>
          </div>
      </div>
      <?php }?>
    </div>       
    <?php }?>                                                  
  </div>
</section>
<!-- End Section Best Option stories -->
<?php get_footer(); ?>
