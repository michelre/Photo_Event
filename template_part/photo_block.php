<!-- Affichage d'une photo avec des informations supplémentaires -->
<li class="photo" data-reference="<?php echo esc_attr( get_field( 'reference' ) ); ?>" data-categorie="<?php echo get_the_terms($post->ID, 'categorie')[0]->name; ?>">
  <a href="<?php the_permalink(); ?>">
    <?php the_post_thumbnail( 'photos' ); ?>
<!-- Superposition sur l'image pour afficher des boutons de contrôle -->
    <div class="photo-overlay">
      <a href="<?php echo wp_get_attachment_image_url( get_the_ID(), 'full' ); ?>" class="photo-fullscreen" title="<?php the_title(); ?>"><i class="fas fa-expand"></i></a>
      <a href="<?php the_permalink(); ?>" class="photo-details" title="<?php the_title(); ?>"><i class="fas fa-eye"></i></a>
    </div>
  </a>
</li>