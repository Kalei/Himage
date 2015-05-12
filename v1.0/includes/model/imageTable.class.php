<?php

/**
 * Description of imageTable
 *
 * @author Rovelli
 */
class imageTable {

     public static function getImageById($id) {
          global $pdo;

          $sql = "SELECT * FROM image WHERE id_image=$id";
          $stmt = $pdo->query($sql);
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if (empty($res))
               return false;

          return new Image($res[0]);
     }

     public static function getImageByNom($nom) {
          global $pdo;

          $sql = "SELECT * FROM image WHERE nom_image=$nom";
          $stmt = $pdo->query($sql);
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($res))
               return false;

          return new Image($res[0]);
     }

}
