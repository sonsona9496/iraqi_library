<header id="masthead" class="site-header">

    <div class="fixed-top bg-body-tertiary">

      <nav id="nav-main" class="navbar navbar-expand-lg">
        <div class="<?= bootscore_container_class(); ?>">
          <!-- Navbar Logo -->
          <a class="navbar-brand xs d-md-none" href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo-sm.svg" alt="logo" class="logo xs"></a>
          <a class="navbar-brand md d-none d-md-block" href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo.svg" alt="logo" class="logo md"></a>
          <!-- Offcanvas Navbar -->
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-navbar">
            <div class="offcanvas-header">
              <span class="h5 offcanvas-title"><?php esc_html_e('Menu', 'bootscore'); ?></span>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <!-- Bootstrap 5 Nav Walker Main Menu -->
              <?php
              wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => '__return_false',
                'items_wrap'     => '<ul id="bootscore-navbar" class="navbar-nav me-auto %2$s">%3$s</ul>',
                'depth'          => 2,
                'walker'         => new bootstrap_5_wp_nav_menu_walker()
              ));
              ?>

              <!-- Top Nav 2 Widget -->
              <?php if (is_active_sidebar('top-nav-2')) : ?>
                <?php dynamic_sidebar('top-nav-2'); ?>
              <?php endif; ?>

            </div>
          </div>
          <div class="header-actions d-flex align-items-center">

            <!-- Top Nav Widget -->
            <?php if (is_active_sidebar('top-nav')) : ?>
              <?php dynamic_sidebar('top-nav'); ?>
            <?php endif; ?>

            <?php
            if (class_exists('WooCommerce')) :
              get_template_part('template-parts/header/actions', 'woocommerce');
            else :
              get_template_part('template-parts/header/actions');
            endif;
            ?>

            <!-- Navbar Toggler -->
            <button class="btn btn-outline-secondary d-lg-none ms-1 ms-md-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvas-navbar">
              <i class="fa-solid fa-bars"></i><span class="visually-hidden-focusable">Menu</span>
            </button>

          </div><!-- .header-actions -->

        </div><!-- bootscore_container_class(); -->
      </nav><!-- .navbar -->

      <?php
      if (class_exists('WooCommerce')) :
        get_template_part('template-parts/header/top-nav-search-collapse', 'woocommerce');
      else :
        get_template_part('template-parts/header/top-nav-search-collapse');
      endif;
      ?>

    </div><!-- .fixed-top .bg-light -->

    <!-- Offcanvas User and Cart -->
    <?php
    if (class_exists('WooCommerce')) :
      get_template_part('template-parts/header/offcanvas', 'woocommerce');
    endif;
    ?>

  </header> 