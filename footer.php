<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 *
 * @version 5.3.0
 */

?>

<footer>
    <div class="footer-section">
        <div class="footer-content">
            <div class="footer-logo">
                <a class="navbar-brand " href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo.png" alt="logo" class="logo"></a>
            </div>
            <div class="footer-items">
                <?php
                    wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => '',
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '<ul  class="menu-footer">%3$s</ul>',
                    'depth'          => 2,
                    'walker'         => new bootstrap_5_wp_nav_menu_walker()
                    ));
                ?>
            </div>
        </div>
        <div class="copy-right">
            <p>metalux <i class="far fa-copyright"></i> 2023</p>
        </div>
    </div>
</footer>
<!-- To top button -->
<a href="#" class="btn btn-primary shadow top-button position-fixed zi-1020"><i class="fa-solid fa-chevron-up"></i><span class="visually-hidden-focusable">To top</span></a>

<!-- </div> -->

<?php wp_footer(); ?>

</body>

</html>
