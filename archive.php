<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
?>

  <div id="content" class="site-content <?= bootscore_container_class(); ?> py-5 mt-5">
    <div id="primary" class="content-area">
      <header class="page-header mb-4">
        <?php category_name_archive();?>
      </header>
      <!-- ===================== -->
      <div class="row">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <div class="col-lg-4">
          <div class="card  pb-3">
            <!-- Image -->
            <?php if (has_post_thumbnail()) : ?>
              <div class="cont-image">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium', array('class' => 'card-img')); ?>
                </a>
              </div>
            <?php endif; ?>
            <!-- Body -->
            <div class="card-body">
              <!-- Heading -->
              <a class="text-body text-decoration-none" href="<?php the_permalink(); ?>">
                  <?php the_title('<h4 class="card-body-title mb-3 mt-2">', '</h4>'); ?>
              </a>
              <!-- Meta -->
              <?php if ('post' === get_post_type()) : ?>
                <p class="meta small mb-2 text-body-tertiary d-flex justify-content-around">
                  <?php
                  the_date();
                  bootscore_author(array('class' => 'auther'));
                  // bootscore_comments();
                  bootscore_edit();
                  ?>
                </p>
              <?php endif; ?>
              <!-- Text -->
              <p class="card-body-text">
                <?= strip_tags(get_the_excerpt()); ?>
              </p>
              <p class="card-text ">
                <a class="read-more" href="<?php the_permalink(); ?>">
                  <?php _e('اقرأ الان <i class="fas fa-long-arrow-alt-left"></i> '); ?>
                </a>
              </p>
            </div>
            
          </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>


<?php
get_footer();
