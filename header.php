<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <script type='text/javascript' src='http://localhost/nathalie_mota/wp-content/themes/Photo_Event/script.js?ver=1.1' id='script-js'></script>
 
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="header">
        <div class = "logo">
            <a href="<?php echo home_url( '/' ); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Logo">
            </a>
        </div>
        <nav id="site-navigation" class="main-navigation">
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu', // Emplacement de menu enregistré
                    'menu_id' => 'primary-menu', // ID du menu (peut être personnalisé)
                    'menu_class' => 'menu-class', // Classe CSS du menu (peut être personnalisée)
                    'container' => false, // Ne pas inclure de conteneur autour du menu
                ));
            ?> 
        </nav>
  </header>
<?php wp_body_open(); ?>