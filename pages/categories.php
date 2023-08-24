<?php /* Template Name: categoriesPage */ ?>
<?php get_header(); ?>
<section class="categoriesPage pt-2">
    <div class="container">
        <h1 class="heading">التصنيفات</h1>
        <?php
        //for each category, show all posts
        $cat_args=array(
        'orderby' => 'name',
        'order' => 'ASC'
        );
        $categories=get_categories($cat_args);
        ?>
        <div class="all-categories">
            <div class="owl-categories owl-carousel owl-theme  ">
            <span class=" item cate-link activeFilter" data-filter="all">الكل</span>
            <?php
            foreach($categories as $category) {
                $args=array(
                'showposts' => -1,
                'category__in' => array($category->term_id),
                'caller_get_posts'=>1
                );
                $posts=get_posts();
                if ($posts) {?>
                    
                    <span class=" item cate-link" data-filter=<?php echo esc_html($category->name) ?>><?php echo esc_html($category->name) ?></span>
                    <?php
                }//ifPosts
                } // foreach($categories
            ?>
            </div>
        </div>
        <!-- ================================ -->
        <div class="row">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 100,
                );
            $loop = new WP_Query($args);
            while ($loop->have_posts()) {
                $loop->the_post();
                $categories = get_the_category();
                //  $categories = get_the_terms($post->ID, 'category'); // Replace 'portfolio_cat' with the actual taxonomy slug for your custom post type.

                if (!empty($categories) && !is_wp_error($categories)) {
                ?>
                
                    <div class="col-lg-4 item-gallery mb-4 <?php echo esc_html($categories[0]->name); ?>">
                        <div class="card ">
                            <div class="gallery-item-inner">
                                <?php the_post_thumbnail('') ?>
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
                            </div>
                            <div class="content">
                                <h3>
                                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a>
                                    <span class="buton"><i class="fas fa-star "></i>7.2</span>
                                </h3>
                                <div class="details">
                                    <p>الكاتب : <strong><?php the_author()?></strong> </p>
                                    <p> <?php echo getPostViews(get_the_ID()); ?></p>
                                </div>
                                <p><?php the_excerpt() ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                } // foreach($posts
                    wp_reset_postdata();
                    } // if ($posts
                ?>
                
        </div>

        <!-- =====================Test========================= -->
        

        <!-- =====================/Test========================= -->
        
    </div>
</section>
<?php get_footer(); ?>


