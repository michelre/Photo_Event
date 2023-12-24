<?php get_header(); ?>

<section class="hero">
    <h1>Photographe event</h1>
    <?php 
        // Requête pour récupérer une image aléatoire du type de contenu 'photos' avec la taxonomie 'format' définie en 'paysage'
        $random_image = new WP_Query(array (
            'post_type' => 'photo',
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => 'paysage',
                ),
            ),
            'orderby' => 'rand',
            'posts_per_page' => '1'
        ));

        // Afficher l'image aléatoire si disponible
        if ($random_image->have_posts()) {
            while ($random_image->have_posts()) {
                $random_image->the_post();
                echo '<img class="hero_background" src="';
                echo the_post_thumbnail_url();
                echo '" />';
            }
        }
        wp_reset_postdata();
    ?> 
</section>

<section class="galerie bloc-page">
    <div class="filtres colonnes">
        <div class="filtres__taxonomie colonnes colonne">
            <!-- Formulaire pour filtrer par la taxonomie 'categories' -->
            <form id="categorie" class="js-filter-form filtres__taxonomie_categories filtre colonne">
                <select id="select-categorie" name="categorie">
                    <option value="all">Catégories</option>
                    <?php afficherTaxonomies('categorie'); // Appel de la fonction pour afficher les termes de taxonomie ?>
                </select>
            </form>
            <!-- Formulaire pour filtrer par la taxonomie 'format' -->
            <form id="format" class="js-filter-form filtres_taxonomie__formats filtre colonne">
                <select id="select-format" name="format">
                    <option value="all">Formats</option>
                    <?php afficherTaxonomies('format'); // Appel de la fonction pour afficher les termes de taxonomie ?>
                </select>
            </form>
        </div>
        <div class="filtres__tri colonnes colonne">
            <div class="colonne">
            
            </div>
            <!-- Formulaire pour trier par ordre -->
            <form id="ordre" class="js-filter-form filtres_taxonomie__formats filtre colonne">
                <select id="select-ordre" name="ordre">
                    <option value="all">Trier par</option>
                    <option class="js-ordre-item" value="DESC">Plus récentes aux plus anciennes</option>
                    <option class="js-ordre-item" value="ASC">Plus anciennes aux plus récentes</option>
                </select>
            </form>
        </div>
    </div>
    <div class="galerie__photos colonnes">
        <?php 
            // Requête pour récupérer des images du type de contenu 'photos', triées par date
            $galerie = new WP_Query(array (
                'post_type' => 'photo',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 8,
                'paged' => 1)
            );

            // Appel de la fonction pour afficher les images en utilisant la fonction 'afficherImages'
            afficherImages($galerie, false);
        ?>
    </div>
    <div class="galerie__btn">
        <input type="button" value="Charger plus" id="btn-charger-plus">
    </div>
</section>

<?php get_footer(); ?>