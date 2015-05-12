<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



//On pourrait également nommé l'application himage/himage_photo/himage_article...
//Definition table photo (exemple de sauvegarde en imaginant l'implémentation du formulaire)
if (globalParamTable::getGlobalParamByNom('himage_table') == FALSE && isset($_GET['default_values'])) {
	$new_param = new GlobalParam(array("nom" => "himage_table", "value" => "photo"), TRUE);
    $new_param->save();
}

//Champs de la table (modifier la partie droite après => et vide pour désactiver le champs)
if (globalParamTable::getGlobalParamByNom('himage_table_champs') == FALSE && isset($_GET['default_values'])) {
     $to_serialize = array(
         "id_photo" => "id_photo",
         "nom" => "nom",
         "titre" => "titre",
         "description" => "description",
         "date" => "date",
         "dformat" => "dformat",
         "rate" => "rate"
     );
     $new_param = new GlobalParam(array("nom" => "himage_table_champs", "value" => serialize($to_serialize)), TRUE);
     $new_param->save();
}

//Activer options - Admin (check-list)
if (globalParamTable::getGlobalParamByNom('himages_services') == FALSE && isset($_GET['default_values'])) {
     $to_serialize = array("pagination" => TRUE, "recherche" => TRUE, "dformat" => TRUE, "rate" => TRUE, "crop" => TRUE, "tags" => TRUE);
     $new_param = new GlobalParam(array("nom" => "himages_services", "value" => serialize($to_serialize)), TRUE);
     $new_param->save();
}

?>