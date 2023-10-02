<?php 

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Fonction menu
function register_my_menus() {
    register_nav_menus(array(
        'main-menu' => 'Menu de l\'en-tête',
        'footer-menu' => 'Menu du pied de page',
    ));
}
add_action('after_setup_theme', 'register_my_menus');

function theme_enqueue_style()
{
  wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_style');

function enqueue_custom_script() {
    // Enregistrez le script
    wp_register_script('script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0', true);

    // Chargez le script
    wp_enqueue_script('script');
}

// Action pour charger le script
add_action('wp_enqueue_scripts', 'enqueue_custom_script');