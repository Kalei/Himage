<?php

include ($_SERVER['DOCUMENT_ROOT'] . "/Himage/v1.0/images/photos/conf/himage-conf.php");

if ($_REQUEST['action'] == "add" && isset($_REQUEST['id_photo']) && isset($_REQUEST['id_cible']) && isset($_REQUEST['type_tag'])) {

     $type_tag = $pdo->quote($_REQUEST['type_tag']);
     $id_photo = $pdo->quote($_REQUEST['id_photo']);
     $id_cible = $pdo->quote($_REQUEST['id_cible']);

     $sql_tag = "INSERT INTO tag (id_tag, id_photo, type_tag, id_cible) 
		VALUES ('',  " . $id_photo . "," . $type_tag . ",  " . $id_cible . ")";

     if ($pdo->exec($sql_tag)) {
          $sql_tags = "SELECT * FROM tag ORDER BY id_tag DESC LIMIT 1";
          $tag_res = $pdo->query($sql_tags)->fetchAll(PDO::FETCH_ASSOC);
          $tag = $tag_res[0];
          switch ($tag['type_tag']) {
               case 'marque':


                    break;
               case 'article':


                    break;
               case 'materiels':


                    break;
               case 'technique':


                    break;
               case 'produit':


                    break;
               case 'actualite':


                    break;
               default:
                    break;
          }


          header('Content-Type: application/json');
          echo json_encode($tag);
     } else {
          header('Content-Type: application/json');
          echo json_encode(array("error" => "Probleme lors de l'ajout."));
     }
} else if ($_REQUEST['action'] == "delete" && isset($_REQUEST['id_tag'])) {

     $sql_tag = "DELETE FROM tag WHERE id_tag=" . $_REQUEST['id_tag'];
     echo $sql;

     if ($pdo->exec($sql_tag)) {
          header('Content-Type: application/json');
          echo json_encode(array("id_tag" => $_REQUEST['id_tag']));
     } else {
          header('Content-Type: application/json');
          echo json_encode(array("error" => "Probleme lors de la suppression."));
     }
} else {
     echo 'Erreur, arguments non renseignés';
}
     