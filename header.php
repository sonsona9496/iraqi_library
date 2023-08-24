<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootscore
 *
 * @version 5.3.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <!-- Favicons -->
  <link rel="icon" sizes="180x180" href="<?= get_stylesheet_directory_uri(); ?>/img/logo/logo.png">
  <!-- <link rel="icon" type="image/png" sizes="32x32" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/favicon-16x16.png"> -->
  <link rel="manifest" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="<?= get_stylesheet_directory_uri(); ?>/img/favicon/safari-pinned-tab.svg" color="#0d6efd">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <title><?php wp_title($sep = ''); ?> <?php if (is_front_page()) { echo ' الصفحة الرئيسية'; } ?></title>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<!-- <div id="page" class="site"> -->

  
<header id="masthead" class="site-header">
    <nav class='top-menu'>
      <div class="right-section">
        <i class="fas fa-bars"></i>
        <!-- Navbar Logo -->
        <!-- <a class="navbar-brand xs d-md-none" href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo-sm.svg" alt="logo" class="logo xs"></a> -->
        <a class="navbar-brand " href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo.png" alt="logo" class="logo"></a>
      </div>
      <div class="left-section"> 
        <?php get_search_form();?>
        <!-- <a href="#"><i class="fas fa-dollar-sign"></i> جرب البريميوم</a> -->
      </div>
    </nav>
    <div class='sidebar-menu'>
      <?php
        wp_nav_menu(array(
          'theme_location' => 'main-menu',
          'container'      => false,
          'menu_class'     => '',
          'fallback_cb'    => '__return_false',
          'items_wrap'     => '<ul  class="menu-lists">%3$s</ul>',
          'depth'          => 2,
          'walker'         => new bootstrap_5_wp_nav_menu_walker()
        ));
      ?>
      <ul class="social-media">
        <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
        <li><a href="#"><i class="fas fa-comment-alt"></i></a></li>
        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
      </ul>
    </div>
    <div class="menu-mobile">
      <!-- Navbar Logo -->
      <!-- <a class="navbar-brand xs d-md-none" href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo-sm.svg" alt="logo" class="logo xs"></a> -->
      <a class="navbar-brand " href="<?= esc_url(home_url()); ?>"><img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/img/logo/logo.png" alt="logo" class="logo"></a>
      <!-- Bars & Search -->
      <div class="left-nav">
        <i class="fa-solid fa-magnifying-glass mx-3 open-search-form"></i>
        <i class="fas fa-bars open-menu-mobile"></i>
      </div>
      <!-- Search -->
      <div class="search-form-mobile"> 
          <?php get_search_form();?>
      </div>
      <!-- Menu -->
      <div class='menu-mobile-items'>
        <?php
          wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'container'      => false,
            'menu_class'     => '',
            'fallback_cb'    => '__return_false',
            'items_wrap'     => '<ul  class="menu-mobile-lists">%3$s</ul>',
            'depth'          => 2,
            'walker'         => new bootstrap_5_wp_nav_menu_walker()
          ));
        ?>
        <ul class="social-media-mobile">
          <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
          <li><a href="#"><i class="fas fa-comment-alt"></i></a></li>
          <li><a href="#"><i class="fab fa-instagram"></i></a></li>
        </ul>
        <!-- Close Btn -->
        <i class="fas fa-times btn-close-menu"></i>
      </div>
    </div>
</header>