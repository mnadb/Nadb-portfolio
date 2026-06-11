<?php

// Enregistre les deux menus du theme.
function register_my_menu() {
    register_nav_menu( 'header' , 'En tête du menu' );
    register_nav_menu( 'footer' , 'Pied de page' );
}
add_action( 'after_setup_theme', 'register_my_menu' );



// Charge les styles et les scripts du theme.
function nadb_assets() {
    $theme_dir = get_template_directory();

    // Charge la feuille de style declaree par WordPress.
    wp_enqueue_style(
        'nadb-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // Charge les styles principaux du site.
    wp_enqueue_style(
        'nadb-main-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array(),
        filemtime($theme_dir . '/assets/sass/style.css')
    );

    // Charge le menu mobile.
    wp_enqueue_script(
        'nadb-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        filemtime($theme_dir . '/assets/js/script.js'),
        true
    );

   

    // Charge la fenetre de contact.
    wp_enqueue_script(
        'contact-popup-js',
        get_template_directory_uri() . '/assets/js/contact-popup.js',
        array(),
        filemtime($theme_dir . '/assets/js/contact-popup.js'),
        true
    );

   
}
add_action('wp_enqueue_scripts', 'nadb_assets');

