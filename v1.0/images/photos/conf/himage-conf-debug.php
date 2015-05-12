<?php

/**
 * Raport d'erreur configuration de himage
 * 
 * V1.0 Hugo Rovelli
 */
$himage_conf_error = array();

function tableExists($pdo, $table_name) {
     $results = $pdo->query("SHOW TABLES LIKE '$table_name'");
     if ($results->rowCount() > 0) {
          return TRUE;
     } else {
          return FALSE;
     }
}

function getTableColumnName($pdo, $table_name) {
     $results = $pdo->query("select COLUMN_NAME from information_schema.columns where table_name='$table_name'");
     if ($results->rowCount() == 1) {
          return $results[0];
     } else {
          return FALSE;
     }
}

//Ajouter les nouveaux services au fure et à mesure
$services_list = array("recherche", "rate", "dformat", "tags");

//Test des services déclarés
if (count($himage_services) > 0) {
     foreach ($services_list as $service) {
          if (!array_key_exists($service, $himage_services)) {
               $himage_conf_error[] = "himage services: Veuillez initialiser le service " . $service . " (TRUE|FALSE) dans himage_services.";
          }
     }
}

$formats_list = array("carre", "horizontal", "vertical", "panoramique");
$tailles_list = array("grandes", "moyennes", "petites");

//Test des répertoirs photos exits et en écriture...
$right_str_error = "himage directories: Problème de droits sur le dossier ";

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $dir_photos)) {

     $current_directory = $right_str_error . $_SERVER['DOCUMENT_ROOT'] . $dir_photos . "/source/";

     if (!is_writable($current_directory)) {
          $himage_conf_error[] = $right_str_error . $current_directory;
     }

     $current_directory = $right_str_error . $_SERVER['DOCUMENT_ROOT'] . $dir_photos . "/source/thumbnail";
     if (!is_writable($current_directory)) {
          $himage_conf_error[] = $right_str_error . $current_directory;
     }

     foreach ($formats_list as $format) {
          foreach ($tailles_list as $taille) {
               $current_directory = $right_str_error . $_SERVER['DOCUMENT_ROOT'] . $dir_photos . $format . "/" . $taille . "/";
               if (!is_writable($current_directory)) {
                    $himage_conf_error[] = $right_str_error . $current_directory;
               }
          }
     }
} else {
     $himage_conf_error [] = "himage directories: Veuillez créer l'arboressence de fichier sous le repertoir '" . $dir_photos . "' ou le chemin indiqué n'est pas valide.";
}

//Test répertoir modules
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $dir_modules)) {
     if (file_exists($_SERVER ['DOCUMENT_ROOT'] . $dir_modules . 'bootstrap') && file_exists($_SERVER['DOCUMENT_ROOT'] . $dir_modules . 'JUpload')) {
          $himage_conf_error[] = "himage modules: Veuillez vérifier que les modules bootstrap et JUpload sont bien installés.";
     }
} else {
     $himage_conf_error [] = "himage modules: Veuillez créer l'arboressence de fichier sous le repertoir '" . $dir_modules . "' ou le chemin indiqué n'est pas valide.";
}

//Entete
if (!file_exists($entete)) {
     $himage_conf_error[] = "himage entete: le chemin indiqué n'est pas valide.";
}

//Admin photos
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $dir_adminphoto)) {
     $himage_conf_error[] = "himage entete: le chemin indiqué n'est pas valide.";
}

//Test base de donnée
if (!tableExists($pdo, $himage_table)) {
     $himage_conf_error [] = "himage table: Veuillez créer l'arboressence de fichier sous le repertoir '" . $dir_modules . "' ou le chemin indiqué n'est pas valide.";
} else {
     if (is_array($list_champs) && count($list_champs) > 0) {
          $table_columns = getTableColumnName($pdo, $himage_table);
          if ($table_columns != false) {
               foreach ($table_columns as $column) {
                    if (!in_array($column, $list_champs)) {
                         $himage_conf_error[] = "himage table: Le champ '$column' n'est pas parametré dans list_champs.";
                    }
               }
          } else {
               $himage_conf_error[] = "himage table: La table '$himage_table' ne  contient aucune colone. (list_champs)";
          }
     } else {
          $himage_conf_error[] = "himage table: Le nom des champs en table n'ont pas été initialiser. (list_champs)";
     }
}
//Autres options
if ($crop_or_canvas != 'crop' || $crop_or_canvas != 'canvas') {
     $himage_conf_error[] = "himage modules: Veuillez créer l'arboressence de fichier sous le repertoir '" . $dir_modules . "' ou le chemin indiqué n'est pas valide.";
}

//Affichage
if (count($himage_conf_error) > 0) {
     echo '<ul>';
     foreach ($himage_conf_error as $vhimage_conf_error) {
          echo '<li>' . $vhimage_conf_error . '</li>';
     }
     echo '</ul>';
}