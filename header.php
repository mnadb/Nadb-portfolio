<?php
/**
 * Header Template
 *
 * @package WordPress
 * @subpackage Nadb Portfolio
 * @since 1.0
 */
?>



<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="description" content="Découvrez mon  portfolio , Nadb développeuse Wordpress">
    <meta name="keywords" content="site vitrine, portfolio, e-commerce, WordPress">
    <meta name="author" content="Nadb">
    <meta name="title" content="Nadb - Portfolio">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>


    <header class="site-header">
        <nav class="main-navigation">

            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Logo.png" alt="Logo Nadb">
            </a> 
             <!-- Menu Mobile -->
        <button
            class="burger"
            type="button"
            aria-label="Ouvrir le menu"
            aria-expanded="false"
            aria-controls="nav-menu"
            >
            <span></span>
            <span></span>
            <span></span>
        </button>
            <?php
                    wp_nav_menu(array( // Affiche le menu principal
                        'theme_location' => 'header',
                        'container' => false,
                        'menu_class' => 'nav-menu',
                        'menu_id'    => 'nav-menu',
                    ));
                ?>
          
        </nav>
    </header>
