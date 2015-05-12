<?php

// Créer 4 format d'images horizontal(4/3) / vertical(2/3) / carré / panoramique (16/8) (petit, moyen, grand, sources)

$parametrages = array(
    'bdd_info' => array(
        'bdd_nom' => 'image'
    ),
    'formats' => array(
        'horizontal' => array(
            'tailles_img' => array(
                'grandes' => array(
                    'largeur' => 1600,
                    'hauteur' => 1200,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'moyennes' => array(
                    'largeur' => 800,
                    'hauteur' => 600,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'petites' => array(
                    'largeur' => 200,
                    'hauteur' => 150,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                )
            )
        ),
        'panoramique' => array(
            'tailles_img' => array(
                'grandes' => array(
                    'largeur' => 1600,
                    'hauteur' => 800,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'moyennes' => array(
                    'largeur' => 1000,
                    'hauteur' => 500,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'petites' => array(
                    'largeur' => 400,
                    'hauteur' => 200,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                )
            )
        ),
        'carre' => array(
            'tailles_img' => array(
                'grandes' => array(
                    'largeur' => 1600,
                    'hauteur' => 1600,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'moyennes' => array(
                    'largeur' => 768,
                    'hauteur' => 768,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'petites' => array(
                    'largeur' => 200,
                    'hauteur' => 200,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                )
            )
        ),
        'vertical' => array(
            'tailles_img' => array(
                'grandes' => array(
                    'largeur' => 1080,
                    'hauteur' => 1600,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'moyennes' => array(
                    'largeur' => 512,
                    'hauteur' => 768,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                ),
                'petites' => array(
                    'largeur' => 200,
                    'hauteur' => 300,
                    'qualite' => 95,
                    'adapter_image' => FALSE
                )
            )
        )
    )
);
?>