<?php /* Template Name: favoritePage */ ?>
<?php get_header(); ?>
<section class="faviPage">
    <div class="container">
        <h1 class="heading">المفضلة</h1>

        <?php
            $favorite_id_array = favorite_id_array();
            global $wp_query;
            $save_wpq = $wp_query;
            $args = array(
            'paged' => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
            'post_type'   => 'post',
            'post__in'   => !empty($favorite_id_array) ? $favorite_id_array : array(0),
                );
            $wp_query = new WP_Query( $args ); 
            ?>
            <?php if ($wp_query->have_posts()) : ?>
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
            <!-- Design Card Favorite -->
            <div class="card-favorite">
                <div class="cont-img-favorite">
                    <?php the_post_thumbnail('') ?>
                </div>
                <div class="content-favorite">
                    <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                    <div class="info-favorite">
                        <span class="buton"><i class="fas fa-star "></i> التقييم <strong>/ 7.9</strong></span>
                        <span class="buton"><i class="fas fa-list "></i> الفصول <strong>/ 30</strong></span>
                        <span class="buton"><i class="fas fa-eye "></i> القراءات <strong>/ <?php echo getPostViews(get_the_ID()); ?></strong></span>
                    </div>
                    <p class="mb-2 the-author">الكاتب : <strong><?php the_author()?></strong> </p>
                    <?php the_excerpt();?>
                </div>
                <div class="fv_<?php echo $post->ID; ?> delete-favorite-cont">
                    <div class="delete-favorite" data-post_id="<?php echo $post->ID; ?>" title="حذف من المفضلة">
                        <i class="fas fa-trash"></i>
                    </div>
                </div>
            </div>
            <!-- <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> -->
            <!-- <div class="cont-img-favorite">
                <?php the_post_thumbnail('') ?>
            </div> -->
            <?php endwhile; ?>
            <?php else : ?>
            <p>No posts in your favorite</p>
            <?php endif; ?>
            <?php wp_reset_postdata();  ?> 
            
    </div>
</section>

<?php get_footer(); ?>


