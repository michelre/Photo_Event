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

add_action( 'wp_enqueue_scripts', 'add_scripts');
function add_scripts() {
    wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', array( 'jquery' ), 1.1, true);
}

function register_post_types() {
	// La déclaration de nos Custom Post Types et Taxonomies ira ici
    // CPT Photo
    $labels = array(
        'name' => 'Photo',
        'all_items' => 'Toutes les photos',  // affiché dans le sous menu
        'singular_name' => 'Photo',
        'add_new_item' => 'Ajouter une photo',
        'edit_item' => 'Modifier la photo',
        'menu_name' => 'Photo'
    );

	$args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor','thumbnail' ),
        'menu_position' => 5, 
        'menu_icon' => 'dashicons-camera',
	);

	register_post_type( 'photo', $args );
}
add_action( 'init', 'register_post_types' );