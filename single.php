<?php
/**
 * Template Post Type: post
 */

get_header();
?>
  <header class="header-bg">
    <?php the_post_thumbnail('') ?>
    <div class="header-heading">
      <h1><?php the_title(); ?></h1>
      <span>بارت 1</span>
    </div>
    <div class="overlay-bg"></div>
  </header>
  
  

  <!-- <main>
    <div class="container"> -->
      <!-- Info -->
      
    <!-- </div>
  </main> -->
  <div id="content" class="site-content ">
    <div class="container">

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

      <div id="primary" class="content-area">
      <div class="row">
        <div class="<?= bootscore_main_col_class(); ?>">

          <main id="main" class="site-main">
            <div class="top-info">
              <span class="buton"><i class="fas fa-star "></i> التقييم <strong>/ 7.9</strong></span>
              <span class="buton"><i class="fas fa-list "></i> الفصول <strong>/ 30</strong></span>
              <span class="buton"><i class="fas fa-eye "></i> القراءات <strong>/ <?php echo getPostViews(get_the_ID()); ?></strong></span>
            </div>
            <!-- Content -->
            <div class="body-content ">
              <span class="date-post"><?php bootscore_date(); ?></span>
            </div>
            <div class="entry-content">
              <?php the_content(); ?>
              <?php
              $tags = wp_get_post_tags($post->ID); //this is the adjustment, all the rest is bhlarsen
              $html = '<div class="post_tags">';
              foreach ( $tags as $tag ) {
              $tag_link = get_tag_link( $tag->term_id );
              
              $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
              $html .= "{$tag->name}</a> ";
              }
              $html .= '</div>';
              echo $html; 
              ?>
                
            </div>
            <footer class="entry-footer clear-both">
              <!-- <div class="mb-4">
                <?php bootscore_tags(); ?>
              </div> -->
              <nav aria-label="bS page navigation">
                <ul class="pagination justify-content-center">
                  <li class="page-item">
                    <?php previous_post_link('%link'); ?>
                  </li>
                  <li class="page-item">
                    <?php next_post_link('%link'); ?>
                  </li>
                </ul>
              </nav>
              <?php comments_template(); ?>
            </footer>

          </main>
        </div>
        <?php get_sidebar(); ?>
      </div> 

    </div>
  </div>
    
  </div>

<?php
get_footer();
