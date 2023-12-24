<?php
get_header();
?>
        <div class="custom-post">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php the_title(); ?></h1>
                    <p>Référence : <span id="reference-photo"><?php echo get_field('reference'); ?></span></p>
                    <p>Catégorie : <?php echo strip_tags(get_the_term_list($post->ID, 'categorie')); ?></p>
                    <p>Format : <?php echo strip_tags(get_the_term_list($post->ID, 'format')); ?></p>
                    <p>Type : <?php echo get_field('type'); ?></p>
                    <p>Année : <?php echo get_the_date('Y'); ?></p>
                </div>
                <div class="col-md-7">
                    <?php
                    // Récupérez l'image mise en avant
                    if (has_post_thumbnail()) :
                        the_post_thumbnail('large'); // Vous pouvez spécifier la taille de l'image
                    endif;
                    ?>
                </div>
            </div>
        </div>

  <div class="custom">  
        <div class="custom-contact">
                <p>Cette photo vous intéresse ?</p>
                <a class="contact-btn">
                    <input type="button" value="Contact">
                </a>
        </div>
        
			<?php 
				$precedent = get_previous_post();
				$suivant = get_next_post();
			?>

        <div class="custom-arrow">
			<?php if(get_previous_post()){?>
				<a href="<?php echo get_the_permalink($precedent) ?>">
				    <img class="image-slider" src="<?php echo get_the_post_thumbnail_url($precedent) ?>">
				</a>
			<?php }
			elseif ( get_next_post() ) {?>
				<a href="<?php echo get_the_permalink($suivant) ?>">
					<img class="image-slider" src="<?php echo get_the_post_thumbnail_url($suivant) ?>">			
				</a>
			<?php }?>

			<div class="arrows">
				<div>
                <a href="<?php echo get_the_permalink($precedent) ?>">
					<img class="arrow-left" src="<?php echo get_stylesheet_directory_uri($precedent) . '/assets/img/arrow_left.png' ?>">
                </a>
				</div>
				<div>
                <a href="<?php echo get_the_permalink($suivant) ?>">
					<img class="arrow-right" src="<?php echo get_stylesheet_directory_uri($suivant) . '/assets/img/arrow_right.png' ?>">
                </a>
				</div>
			</div>
            </div>
        </div>
        
    <div class="custom-photos">
        <h2>VOUS AIMEREZ AUSSI</h2>
        <div class="custom-block-photos">
            <?php
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'categorie' => get_the_terms(get_the_ID(), 'categorie')[0]->slug,
            );
            
            $query = new WP_Query($args);
            
            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();
                get_template_part( 'template_part/photo_block' );
                endwhile;
            endif;
            
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <div class="button-photos">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="all-photos-button">Toutes les photos</a>
    </div>

</div>



<?php

wp_reset_postdata();

get_footer();
