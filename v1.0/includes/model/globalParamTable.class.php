<?php

/**
 * Description of global_paramTable
 *
 * @author Rovelli
 */
class globalParamTable {

     public static function getGlobalParamById($id) {
          global $pdo;

          $sql = "SELECT * FROM global_param WHERE id_global_param=$id";
          $stmt = $pdo->query($sql);
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($res))
               return false;

          return new GlobalParam($res[0]);
     }

     public static function getGlobalParamByNom($nom) {
          global $pdo;

          $sql = "SELECT * FROM global_param WHERE nom='$nom'";
          $stmt = $pdo->query($sql);
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($res))
               return false;

          return new GlobalParam($res[0]);
     }

     public static function getGlobalParamValueFromNom($nom) {
          global $pdo;

          $sql = "SELECT * FROM global_param WHERE nom='$nom'";
          $stmt = $pdo->query($sql);
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (empty($res))
               return false;

          return $res[0]['value'];
     }

}
