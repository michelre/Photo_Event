(function ($) {
    'use strict';
// Get the modal
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.querySelector("a[href='#myModal']");
    var btnContact = document.querySelector('.contact-btn');

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    if (btnContact) {
        btnContact.onclick = function () {
            modal.style.display = "block";
        }
    }


// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    $('.contact-btn').click(function () {
        $('.wpcf7-form-control.wpcf7-tel.wpcf7-text.wpcf7-validates-as-tel.ref').val($('#reference-photo').text());
    });

    var imageUrls = []; // Tableau pour stocker les URL des images
    var currentImageIndex = 0;


    $(document).ready(function () {

        $(document).on('click', '.btn-plein-ecran', function () {
            currentImageIndex = $('.btn-plein-ecran').index(this); // Positionne l'index courant sur la bonne image cliquée
            // Affiche une image agrandie dans une lightbox
            $('.lightbox').css('display', 'block');
            updateLightboxImage()
        });

        $(document).on('click', '.btn-close', function () {
            $('.lightbox').css('display', 'none');
        })


        // Lorsqu'on clique sur la flèche gauche
        $('.lightbox_arrow_left').click(function () {
            if(currentImageIndex === 0){
                currentImageIndex = imageUrls.length - 1
            } else {
                currentImageIndex -= 1
            }
            updateLightboxImage();
        });


        // Lorsqu'on clique sur la flèche droite
        $('.lightbox_arrow_right').click(function () {
            if(currentImageIndex === imageUrls.length -1){
                currentImageIndex = 0
            } else {
                currentImageIndex += 1
            }
            updateLightboxImage();
        });

        // Fonction pour mettre à jour l'image affichée
        function updateLightboxImage() {
            var imageUrl = imageUrls[currentImageIndex];
            var creerImage = `<img src="${imageUrl.imageUrl}" alt="Image lightbox">`;
            $('.lightbox__image').html(creerImage);
            $('.lightbox_ref').html(imageUrl.ref)
            $('.lightbox_cat').html(imageUrl.category)

        }

        initImageUrl();

    });

    function initImageUrl() {
        imageUrls = []
        $('.galerie__photos .colonne').each(function () {
            imageUrls.push({
                imageUrl: $(this).find('.img-medium').attr('src'),
                ref: $(this).data('ref'),
                category: $(this).data('category'),
            });
        });
    }


// Gestion de la pagination des images
    let pageActuelle = 2; // Start at 2 since we load the first 8 images
    $('#btn-charger-plus').on('click', function () {
        pageActuelle++;
        ajaxRequest(true); // Effectue une requête AJAX pour charger plus d'images
    });

    // Gestion du formulaire de filtrage
    $(document).on('change', '.js-filter-form', function (e) {
        e.preventDefault();
        pageActuelle = 1;
        ajaxRequest(false); // Effectue une requête AJAX pour filtrer les images
    });

    // Fonction pour effectuer une requête AJAX et mettre à jour la galerie de photos
    function ajaxRequest(chargerPlus) {
        var categorie = $('#categorie');
        var categorieTaxonomie = categorie.attr('id');
        var categorieSelection = categorie.find('option:selected').val();
        var format = $('#format');
        var formatTaxonomie = format.attr('id');
        var formatSelection = format.find('option:selected').val();
        var ordre = $('#ordre').find('option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'wp-admin/admin-ajax.php',
            dataType: 'html',
            data: {
                action: 'filter',
                categorieTaxonomie: categorieTaxonomie,
                categorieSelection: categorieSelection,
                formatTaxonomie: formatTaxonomie,
                formatSelection: formatSelection,
                orderDirection: ordre,
                page: pageActuelle
            },
            success: function (resultat) {
                if (chargerPlus) {
                    $('.galerie__photos').append(resultat);
                } else {
                    $('.galerie__photos').html(resultat);
                }
                initImageUrl();
            },
            error: function (result) {
                console.warn(result);
            }
        });
    }


})(jQuery);
