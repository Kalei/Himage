<?php

/* * ******************************************************************
  Auteur : Jean-Loup Couegnas
  Projet : Top-fishing.fr
  Version : PHP5
  Date de Mise à jour : 13/01/2015
  Objet : Gestion > Expédition
 * ******************************************************************* */

/* * ******************************************************************
  Structure de la page
 * ****************************************************************** */
$title = 'Gestion des images'; // Titre de la page
//Je ne sais pas pourquoi le chemin absolu ne marche pas, à voir sous environnement en ligne
include ($_SERVER['DOCUMENT_ROOT'] . "/Himage/v1.0/images/photos/conf/himage-conf.php");
/* * ******************************************************************
  Préparation des données de la page
 * ****************************************************************** */
$meta = '';  // Meta description
$html_head['css'][] = '<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">'
        . '<!-- Generic page styles -->
<link rel="stylesheet" href="' . $dir_modules . 'JUpload/css/style.css">'
        . '<!-- blueimp Gallery styles -->'
        . '<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">'
        . '<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="' . $dir_modules . 'JUpload/css/jquery.fileupload.css">
<link rel="stylesheet" href="./dist/rating.css">
<link rel="stylesheet" href="' . $dir_modules . 'JUpload/css/jquery.fileupload-ui.css">';  // Feuille de style supplémentaire
/* * ******************************************************************
  Affichage de la page
 * ****************************************************************** */
include($entete); // Entête de page
include('./upload_ajax.php'); // Affichage de la page
?>
