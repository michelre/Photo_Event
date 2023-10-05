<?php get_template_part( 'template_part/modale' ); ?>
<?php wp_footer(); ?>
<div class="footer-menu">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'footer-menu',
        'menu_id' => 'footer-menu-id', // ID du menu (peut être personnalisé)
        'menu_class' => 'footer-menu-class', // Classe CSS du menu (peut être personnalisée)
    ));
    ?>
</div>
</body>
</html>