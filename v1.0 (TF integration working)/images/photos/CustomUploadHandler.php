<?php

/*
 * jQuery File Upload Plugin PHP Class 8.1.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

require 'UploadHandler.php';

class CustomUploadHandler extends UploadHandler {

     public function __construct($options = null, $initialize = true, $error_messages = null) {
          $this->options = $options;
          parent::__construct($this->options, $initialize, $error_messages);
     }

     protected function initialize() {
          $dns = 'mysql:' . $this->options['db_host'] . ';port=' . $this->options['db_prot'] . ';dbname=' . $this->options['db_name'];
          try {
               $this->db = new PDO($dns, $this->options['db_user'], $this->options['db_pass']);
          } catch (PDOException $e) {
               $file->error = $e->getMessage();
               //echo '<span color="red">' . $file->error . '</span>';
               return $file;
          }
          parent::initialize();
     }

     protected function handle_form_data($file, $index) {
          //var_dump($_REQUEST);
          $filename = (!empty($_REQUEST['name'])) ? $_REQUEST['name'][$index] : pathinfo($file->name, PATHINFO_FILENAME);
          $ext = (!empty($_REQUEST['extension'])) ? $_REQUEST['extension'][$index] : pathinfo($file->name, PATHINFO_EXTENSION);

          //echo $filename . '<hr/>';
          $file->title = (!empty($_REQUEST['title'])) ? $_REQUEST['title'][$index] : $filename;
          $file->description = (!empty($_REQUEST['description'])) ? $_REQUEST['description'][$index] : 'Aucune description';

          $file->name = strtolower($this->getRewriteName($filename, $ext));
          // var_dump($_REQUEST['recadrage_type']);
          $file->recadrage_type = (!empty($_REQUEST['recadrage_type'])) ? $_REQUEST['recadrage_type'][$index] : 'canvas';
          $this->options['recadrage_type'] = $file->recadrage_type;
     }

     protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
          global $list_champs;
          $file = parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
          if (empty($file->error)) {
               $sql = 'INSERT INTO `' . $this->options['db_table']
                       . '` (`' . $list_champs['nom'] . '`, `' . $list_champs['titre'] . '`, `' . $list_champs['description'] . '`)'
                       . ' VALUES (\'' . $file->name . '\',\'' . $file->title . '\',\'' . $file->description . '\')';
               //echo $sql;
               //var_dump($this->db);
               $query = $this->db->exec($sql);

               $sql = 'SELECT `' . $list_champs['id_photo'] . '`, `' . $list_champs['titre'] . '`, `' . $list_champs['description'] . '`, ' . $list_champs['date'] . ', ' . $list_champs['dformat'] . ', ' . $list_champs['rate'] . ' FROM `'
                       . $this->options['db_table'] . '` WHERE `nom`= \'' . $file->name . '\'';
               
               //echo $sql;
               try {
                    $res = $this->db->query($sql);
                    foreach ($res as $row) {
                         $file->id = $row[$list_champs['id_photo']];
                         $file->title = $row[$list_champs['titre']];
                         $file->description = $row[$list_champs['description']];
                         $file->date = $row[$list_champs['date']];
                         $file->dformat = $row[$list_champs['dformat']];
                         $file->rate = $row[$list_champs['rate']];
                    }
               } catch (PDOException $e) {
                    echo $e->getMessage();
               }
          }


          //var_dump($file);
          return $file;
     }

     protected function set_additional_file_properties($file) {
          global $list_champs;

          parent::set_additional_file_properties($file);
          if ($_SERVER['REQUEST_METHOD'] === 'GET') {
               $sql = 'SELECT `' . $list_champs['id_photo'] . '`, `' . $list_champs['titre'] . '`, `' . $list_champs['description'] . '`, ' . $list_champs['date'] . ', ' . $list_champs['dformat'] . ', ' . $list_champs['rate'] . ' FROM `'
                       . $this->options['db_table'] . '` WHERE `' . $list_champs['nom'] . '`= \'' . $file->name . '\'';
               try {
                    $res = $this->db->query($sql);

                    foreach ($res as $row) {
                         $file->id = $row[$list_champs['id_photo']];
                         $file->title = $row[$list_champs['titre']];
                         $file->description = $row[$list_champs['description']];
                         $file->date = $row[$list_champs['date']];
                         $file->dformat = $row[$list_champs['dformat']];
                         $file->rate = $row[$list_champs['rate']];
                    }
               } catch (PDOException $e) {
                    echo $e->getMessage();
               }
          }
     }

     public function delete($print_response = true) {
          global $list_champs;

          $response = parent::delete(false);
          foreach ($response as $name => $deleted) {
               if ($deleted) {
                    $sql = 'DELETE FROM `' . $this->options['db_table'] . '` WHERE `' . $list_champs['nom'] . '`=\'' . $name . '\'';
                    $query = $this->db->exec($sql);
               }
          }
          return $this->generate_response($response, $print_response);
     }

     public function getRewriteName($txt, $ext = '') {
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

          $txt = strstr($ext, '.') ? $txt . $ext : $txt . '.' . $ext;

          return $txt;
     }

}
