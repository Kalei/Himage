<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/images/photos/conf/himage-conf.php");

if ($_GET['action'] == "type_filter") {
     $row = $pdo->query("SHOW COLUMNS FROM tag LIKE 'type_tag'")->fetch(PDO::FETCH_ASSOC);
     preg_match_all("/'(.*?)'/", $row['Type'], $categories);
     $fields = $categories[1];
} else if ($_GET['action'] == "sub_filter" && isset($_GET['selected_filter'])) {
     $selected_filter = $_GET['selected_filter'];

     switch ($selected_filter) {
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
}

if (isset($fields)) {
     header('Content-Type: application/json');
     echo json_encode($fields);
} else {
     echo 'Erreur, arguments mal renseignés';
}