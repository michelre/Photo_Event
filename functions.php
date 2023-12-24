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

function afficherTaxonomies($nomTaxonomie) {
    if($terms = get_terms(array(
        'taxonomy' => $nomTaxonomie,
        'orderby' => 'name'
    ))) {
        foreach ( $terms as $term ) {
            echo '<option class="js-filter-item" value="' . $term->slug . '">' . $term->name . '</option>';
        }
    }
}

function afficherImages($galerie, $exit) {
    if($galerie->have_posts()) {
        while ($galerie->have_posts()) { ?>
        <?php $galerie->the_post(); ?>
            <div class="colonne"
                 data-ref="<?php echo strip_tags(get_field('reference', $galerie->ID)); ?>"
                 data-category="<?php echo strip_tags(get_the_term_list($galerie->ID, 'categorie')); ?>">
                <div class="rangee">
                    <img class="img-medium" src="<?php echo the_post_thumbnail_url(); ?>" />
                    <div>
                        <div class="img-hover" >
                            <img class="btn-plein-ecran" src="<?php echo get_template_directory_uri(); ?>/assets/img/Icon_fullscreen.png" alt="Icône fullscreen" />
                            <a href="<?php echo get_post_permalink(); ?>">
                                <img class="btn-oeil" src="<?php echo get_template_directory_uri(); ?>/assets/img/Icon_eye.png" alt="Icône oeil" />
                            </a>
                            <div class="img-infos">
                                <p><?php the_title(); ?></p>
                                <p><?php echo strip_tags(get_the_term_list($galerie->ID, 'categorie')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <?php
        }
    }
    else {
        echo "";
    }
    wp_reset_postdata();
    if ($exit) {
        exit();
    }
}

function filter() {
    $requeteAjax = new WP_Query(array(
        'post_type' => 'photo',
        'orderby' => 'date',
        'order' => $_POST['orderDirection'],
        'posts_per_page' => 4,
        'paged' => $_POST['page'],
        'tax_query' =>
            array(
                'relation' => 'AND',
                $_POST['categorieSelection'] != "all" ?
                    array(
                        'taxonomy' => $_POST['categorieTaxonomie'],
                        'field' => 'slug',
                        'terms' => $_POST['categorieSelection'],
                    )
                : '',
                $_POST['formatSelection'] != "all" ?
                    array(
                        'taxonomy' => $_POST['formatTaxonomie'],
                        'field' => 'slug',
                        'terms' => $_POST['formatSelection'],
                    )
                : '',
            )
        )
    );
    afficherImages($requeteAjax, true);
}
add_action('wp_ajax_nopriv_filter', 'filter');
add_action('wp_ajax_filter', 'filter');
