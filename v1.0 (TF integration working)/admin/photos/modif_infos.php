<?php

include ($_SERVER['DOCUMENT_ROOT'] . "/images/photos/conf/himage-conf.php");

$dir_photos = globalParamTable::getGlobalParamValueFromNom('dir_photos');

header('Content-Type: application/json');
// Afficher les erreurs à l'écran
// On augmente le temps d'éxécution d'un script
//ini_set('display_errors', TRUE);
//set_time_limit(20000);

if (isset($_GET['action'])) {
     if ($_REQUEST['action'] == "rate" && isset($_REQUEST['id_photo']) && isset($_REQUEST['rate_value'])) {

          $photo = photosTable::getPhotosById($_REQUEST['id_photo']);
          if ($photo != false) {
               $rate_value = $_REQUEST['rate_value'];

               $photo->{$list_champs['rate'] } = intval($rate_value);

               $photo->save();

               echo json_encode(array("photo" => array($list_champs['id_photo'] => $photo->{$list_champs['id_photo']}, $list_champs['titre'] => $photo->{$list_champs['titre']}, $list_champs['nom'] => $photo->{$list_champs['nom'] }, $list_champs['description'] => $photo->{$list_champs['description'] },
                       $list_champs['date'] => $photo->{$list_champs['date'] }, $list_champs['dformat'] => $photo->{$list_champs['dformat']}, $list_champs['rate'] => $photo->{$list_champs['rate'] })));
          } else {
               echo json_encode(array("error" => "Erreur, photo inexistante."));
          }
     } else if ($_REQUEST['action'] == "dformat" && isset($_REQUEST['id_photo']) && isset($_REQUEST['dformat_value'])) {
          $photo = photosTable::getPhotosById($_REQUEST['id_photo']);
          if ($photo != false) {
               $dformat_value = $_REQUEST['dformat_value'];

               $photo->{$list_champs['dformat'] } = $dformat_value;
               $photo->save();


               echo json_encode(array("photo" => array($list_champs['id_photo'] => $photo->{$list_champs['id_photo'] }, $list_champs['titre'] => $photo->{$list_champs['titre'] }, $list_champs['nom'] => $photo->{$list_champs['nom'] }, $list_champs['description'] => $photo->{$list_champs['description'] },
                       $list_champs['date'] => $photo->{$list_champs['date'] }, $list_champs['dformat'] => $photo->{$list_champs['dformat'] }, $list_champs['rate'] => $photo->{$list_champs['rate'] }), "statut" => "success"));
          } else {
               echo json_encode(array("statut" => "fail", "error" => "Erreur, photo inexistante."));
          }
     } else if ($_REQUEST['action'] == "titre" && isset($_REQUEST['id_photo']) && isset($_REQUEST['titre_value'])) {

          $photo = photosTable::getPhotosById($_REQUEST['id_photo']);
          if ($photo != false) {
               $titre_value = $_REQUEST['titre_value'];

               $photo->{$list_champs['titre'] } = $titre_value;
               $photo->save();

               echo json_encode(array("photo" => array($list_champs['id_photo'] => $photo->{$list_champs['id_photo'] }, $list_champs['titre'] => $photo->{$list_champs['titre'] }, $list_champs['nom'] => $photo->{$list_champs['nom'] }, $list_champs['description'] => $photo->{$list_champs['description'] },
                       $list_champs['date'] => $photo->{$list_champs['date'] }, $list_champs['dformat'] => $photo->{$list_champs['dformat'] }, $list_champs['rate'] => $photo->{$list_champs['rate'] }), "statut" => "success"));
          } else {
               echo json_encode(array("statut" => "fail", "error" => "Erreur, photo inexistante."));
          }
     } else if ($_REQUEST['action'] == "description" && isset($_REQUEST['id_photo']) && isset($_REQUEST['description_value'])) {

          $photo = photosTable::getPhotosById($_REQUEST['id_photo']);

          if ($photo != false) {
               $description_value = $_REQUEST['description_value'];

               $photo->{$list_champs['description'] } = $description_value;
               $photo->save();

               echo json_encode(array("photo" => array($list_champs['id_photo'] => $photo->{$list_champs['id_photo'] }, $list_champs['titre'] => $photo->{$list_champs['titre'] }, $list_champs['nom'] => $photo->{$list_champs['nom'] }, $list_champs['description'] => $photo->{$list_champs['description'] },
                       $list_champs['date'] => $photo->{$list_champs['date'] }, $list_champs['dformat'] => $photo->{$list_champs['dformat'] }, $list_champs['rate'] => $photo->{$list_champs['rate'] }), "statut" => "success"));
          } else {
               echo json_encode(array("statut" => "fail", "error" => "Erreur, photo inexistante."));
          }
     } else if ($_REQUEST['action'] == "nom" && isset($_REQUEST['id_photo']) && isset($_REQUEST['nom_value']) && isset($_REQUEST['extension_value']) && isset($_REQUEST['oldnom_value'])) {

          $photo = photosTable::getPhotosById($_REQUEST['id_photo']);

          if ($photo != false) {
               $nom_value = $_REQUEST['nom_value'];
               $extension_value = $_REQUEST['extension_value'];
               $oldnom_value = $_REQUEST['oldnom_value'];

               $initial_path = $dir_photos . 'formats';
               //echo json_encode(array("statut" => "fail", "error" => "Erreur, photo inexistante.", "value" => $initial_path));

               $format = array("carre", "horizontal", "vertical", "panoramique");
               $taille = array("grandes", "moyennes", "petites");
               $file_newname = getRewriteName($nom_value, $extension_value);
               $file_oldname = $oldnom_value . $extension_value;

               rename($_SERVER['DOCUMENT_ROOT'] . $initial_path . "/source/thumbnail/" . $file_oldname, $_SERVER['DOCUMENT_ROOT'] . $initial_path . "/source/thumbnail/" . $file_newname);
               rename($_SERVER['DOCUMENT_ROOT'] . $initial_path . "/source/" . $file_oldname, $_SERVER['DOCUMENT_ROOT'] . $initial_path . "/source/" . $file_newname);

               foreach ($format as $v_format) {
                    foreach ($taille as $v_taille) {
                         rename($_SERVER['DOCUMENT_ROOT'] . $initial_path . "/" . $v_format . "/" . $v_taille . "/" . $file_oldname, $_SERVER['DOCUMENT_ROOT'] . $initial_path . "/" . $v_format . "/" . $v_taille . "/" . $file_newname);
                    }
               }

               $photo->{$list_champs['nom'] } = $file_newname;
               $photo->save();

               echo json_encode(array("photo" => array($list_champs['id_photo'] => $photo->{$list_champs['id_photo'] }, $list_champs['titre'] => $photo->{$list_champs['titre'] }, $list_champs['nom'] => $photo->{$list_champs['nom'] }, $list_champs['description'] => $photo->{$list_champs['description'] },
                       $list_champs['date'] => $photo->{$list_champs['date'] }, $list_champs['dformat'] => $photo->{$list_champs['dformat'] }, $list_champs['rate'] => $photo->{$list_champs['rate'] }), "statut" => "success"));
          } else {
               echo json_encode(array("statut" => "fail", "error" => "Erreur, photo inexistante."));
          }
     } else {
          echo json_encode(array("arguments" => $_REQUEST, "statut" => "fail", "error" => "Erreur, problème de requête ou d'argument(s)."));
     }
} else {
     echo json_encode(array("statut" => "fail", "error" => "Erreur, aucune action n'a été définie."));
}

function getRewriteName($txt, $ext = '') {
     //Conversion des majuscules en minuscule
     $txt = preg_replace('/\s{1,}/', '-', $txt);

     $txt = str_replace('œ', 'oe', $txt);
     $txt = str_replace('Œ', 'Oe', $txt);
     $txt = str_replace('æ', 'ae', $txt);
     $txt = str_replace('Æ', 'Ae', $txt);
     mb_regex_encoding('UTF-8');
     $txt = mb_ereg_replace('[ÀÁÂÃÄÅĀĂǍẠẢẤẦẨẪẬẮẰẲẴẶǺĄ]', 'A', $txt);
     $txt = mb_ereg_replace('[àáâãäåāăǎạảấầẩẫậắằẳẵặǻą]', 'a', $txt);
     $txt = mb_ereg_replace('[ÇĆĈĊČ]', 'C', $txt);
     $txt = mb_ereg_replace('[çćĉċč]', 'c', $txt);
     $txt = mb_ereg_replace('[ÐĎĐ]', 'D', $txt);
     $txt = mb_ereg_replace('[ďđ]', 'd', $txt);
     $txt = mb_ereg_replace('[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]', 'E', $txt);
     $txt = mb_ereg_replace('[èéêëēĕėęěẹẻẽếềểễệ]', 'e', $txt);
     $txt = mb_ereg_replace('[ĜĞĠĢ]', 'G', $txt);
     $txt = mb_ereg_replace('[ĝğġģ]', 'g', $txt);
     $txt = mb_ereg_replace('[ĤĦ]', 'H', $txt);
     $txt = mb_ereg_replace('[ĥħ]', 'h', $txt);
     $txt = mb_ereg_replace('[ÌÍÎÏĨĪĬĮİǏỈỊ]', 'I', $txt);
     $txt = mb_ereg_replace('[ìíîïĩīĭįıǐỉị]', 'i', $txt);
     $txt = str_replace('Ĵ', 'J', $txt);
     $txt = str_replace('ĵ', 'j', $txt);
     $txt = str_replace('Ķ', 'K', $txt);
     $txt = str_replace('ķ', 'k', $txt);
     $txt = mb_ereg_replace('[ĹĻĽĿŁ]', 'L', $txt);
     $txt = mb_ereg_replace('[ĺļľŀł]', 'l', $txt);
     $txt = mb_ereg_replace('[ÑŃŅŇ]', 'N', $txt);
     $txt = mb_ereg_replace('[ñńņňŉ]', 'n', $txt);
     $txt = mb_ereg_replace('[ÒÓÔÕÖØŌŎŐƠǑǾỌỎỐỒỔỖỘỚỜỞỠỢ]', 'O', $txt);
     $txt = mb_ereg_replace('[òóôõöøōŏőơǒǿọỏốồổỗộớờởỡợð]', 'o', $txt);
     $txt = mb_ereg_replace('[ŔŖŘ]', 'R', $txt);
     $txt = mb_ereg_replace('[ŕŗř]', 'r', $txt);
     $txt = mb_ereg_replace('[ŚŜŞŠ]', 'S', $txt);
     $txt = mb_ereg_replace('[śŝşš]', 's', $txt);
     $txt = mb_ereg_replace('[ŢŤŦ]', 'T', $txt);
     $txt = mb_ereg_replace('[ţťŧ]', 't', $txt);
     $txt = mb_ereg_replace('[ÙÚÛÜŨŪŬŮŰŲƯǓǕǗǙǛỤỦỨỪỬỮỰ]', 'U', $txt);
     $txt = mb_ereg_replace('[ùúûüũūŭůűųưǔǖǘǚǜụủứừửữự]', 'u', $txt);
     $txt = mb_ereg_replace('[ŴẀẂẄ]', 'W', $txt);
     $txt = mb_ereg_replace('[ŵẁẃẅ]', 'w', $txt);
     $txt = mb_ereg_replace('[ÝŶŸỲỸỶỴ]', 'Y', $txt);
     $txt = mb_ereg_replace('[ýÿŷỹỵỷỳ]', 'y', $txt);
     $txt = mb_ereg_replace('[ŹŻŽ]', 'Z', $txt);
     $txt = mb_ereg_replace('[źżž]', 'z', $txt);

     $txt = $txt . $ext;
     return strtolower($txt);
}
