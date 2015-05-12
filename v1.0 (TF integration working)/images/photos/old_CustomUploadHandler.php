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
          $this->options = array(
              'delete_type' => 'POST',
              'db_host' => 'localhost',
              'db_user' => 'topfishing',
              'db_pass' => 'z3plsb8g2013',
              'db_prot' => '8889',
              'db_name' => 'topfishi',
              'db_table' => 'photos',
              'script_url' => $this->get_full_url() . '/',
              'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')) . '/formats/source/',
              'upload_url' => $this->get_full_url() . '/formats/source/',
              'user_dirs' => false,
              'mkdir_mode' => 0755,
              'param_name' => 'files',
              // Set the following option to 'POST', if your server does not support
              // DELETE requests. This is a parameter sent to the client:
              'delete_type' => 'DELETE',
              'access_control_allow_origin' => '*',
              'access_control_allow_credentials' => false,
              'access_control_allow_methods' => array(
                  'OPTIONS',
                  'HEAD',
                  'GET',
                  'POST',
                  'PUT',
                  'PATCH',
                  'DELETE'
              ),
              'access_control_allow_headers' => array(
                  'Content-Type',
                  'Content-Range',
                  'Content-Disposition'
              ),
              // Enable to provide file downloads via GET requests to the PHP script:
              //     1. Set to 1 to download files via readfile method through PHP
              //     2. Set to 2 to send a X-Sendfile header for lighttpd/Apache
              //     3. Set to 3 to send a X-Accel-Redirect header for nginx
              // If set to 2 or 3, adjust the upload_url option to the base path of
              // the redirect parameter, e.g. '/files/'.
              'download_via_php' => false,
              // Read files in chunks to avoid memory limits when download_via_php
              // is enabled, set to 0 to disable chunked reading of files:
              'readfile_chunk_size' => 10 * 1024 * 1024, // 10 MiB
              // Defines which files can be displayed inline when downloaded:
              'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
              // Defines which files (based on their names) are accepted for upload:
              'accept_file_types' => '/.+$/i',
              // The php.ini settings upload_max_filesize and post_max_size
              // take precedence over the following max_file_size setting:
              'max_file_size' => null,
              'min_file_size' => 1,
              // The maximum number of files for the upload directory:
              'max_number_of_files' => null,
              // Defines which files are handled as image files:
              'image_file_types' => '/\.(gif|jpe?g|png)$/i',
              // Use exif_imagetype on all files to correct file extensions:
              'correct_image_extensions' => false,
              // Image resolution restrictions:
              'max_width' => null,
              'max_height' => null,
              'min_width' => 1,
              'min_height' => 1,
              // Set the following option to false to enable resumable uploads:
              'discard_aborted_uploads' => true,
              // Set to 0 to use the GD library to scale and orient images,
              // set to 1 to use imagick (if installed, falls back to GD),
              // set to 2 to use the ImageMagick convert binary directly:
              'image_library' => 0,
              // Uncomment the following to define an array of resource limits
              // for imagick:
              /*
                'imagick_resource_limits' => array(
                imagick::RESOURCETYPE_MAP => 32,
                imagick::RESOURCETYPE_MEMORY => 32
                ),
               */
              // Command or path for to the ImageMagick convert binary:
              'convert_bin' => 'convert',
              // Uncomment the following to add parameters in front of each
              // ImageMagick convert call (the limit constraints seem only
              // to have an effect if put in front):
              /*
                'convert_params' => '-limit memory 32MiB -limit map 32MiB',
               */
              // Command or path for to the ImageMagick identify binary:
              'identify_bin' => 'identify',
              'image_versions' => array(
                  // The empty image version key defines options for the original image:
                  '' => array(
                      // Automatically rotate images based on EXIF meta data:
                      'auto_orient' => true
                  ),
                  '../vertical/grandes/' => array(
                      'max_width' => 1080,
                      'max_height' => 1600,
                      'force_resizing' => true,
                  ),
                  '../vertical/moyennes/' => array(
                      'max_width' => 512,
                      'max_height' => 768,
                      'force_resizing' => true,
                  ),
                  '../vertical/petites/' => array(
                      'max_width' => 200,
                      'max_height' => 300,
                      'force_resizing' => true,
                  ),
                  '../carre/grandes/' => array(
                      'max_width' => 1600,
                      'max_height' => 1600,
                      'force_resizing' => true,
                  ),
                  '../carre/moyennes/' => array(
                      'max_width' => 768,
                      'max_height' => 768,
                      'force_resizing' => true,
                  ),
                  '../carre/petites/' => array(
                      'max_width' => 200,
                      'max_height' => 200,
                      'force_resizing' => true,
                  ),
                  '../horizontal/grandes/' => array(
                      'max_width' => 1600,
                      'max_height' => 1200,
                      'force_resizing' => true,
                  ),
                  '../horizontal/moyennes/' => array(
                      'max_width' => 800,
                      'max_height' => 600,
                      'force_resizing' => true,
                  ),
                  '../horizontal/petites/' => array(
                      'max_width' => 200,
                      'max_height' => 150,
                      'force_resizing' => true,
                  ),
                  '../panoramique/grandes/' => array(
                      'max_width' => 1600,
                      'max_height' => 800,
                      'force_resizing' => true,
                  ),
                  '../panoramique/moyennes/' => array(
                      'max_width' => 1000,
                      'max_height' => 500,
                      'force_resizing' => true,
                  ),
                  '../panoramique/petites/' => array(
                      'max_width' => 400,
                      'max_height' => 200,
                      'force_resizing' => true,
                  ),
                  'thumbnail' => array(
                      // Uncomment the following to use a defined directory for the thumbnails
                      // instead of a subdirectory based on the version identifier.
                      // Make sure that this directory doesn't allow execution of files if you
                      // don't pose any restrictions on the type of uploaded files, e.g. by
                      // copying the .htaccess file from the files directory for Apache:
                      //'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/thumb/',
                      //'upload_url' => $this->get_full_url().'/thumb/',
                      // Uncomment the following to force the max
                      // dimensions and e.g. create square thumbnails:
                      //'crop' => false,
                      'max_width' => 80,
                      'max_height' => 80
                  )
              )
          );

          parent::__construct($this->options, $initialize, $error_messages);
     }

     protected function initialize() {
          $dns = 'mysql:' . $this->options['db_host'] . ';port=' . $this->options['db_port'] . ';dbname=' . $this->options['db_name'];
          try {
               $this->db = new PDO($dns, $this->options['db_user'], $this->options['db_pass']);
          } catch (PDOException $e) {
               $file->error = $this->get_error_message('connect_error');
               return $file;
          }
          parent::initialize();
     }

     protected function handle_form_data($file, $index) {
          //var_dump($_REQUEST);
          $filename =(!empty($_REQUEST['name'])) ? $_REQUEST['name'][$index] :  pathinfo($file->name, PATHINFO_FILENAME);
          $ext =  (!empty($_REQUEST['extension'])) ? $_REQUEST['extension'][$index]: pathinfo($file->name, PATHINFO_EXTENSION);

          //echo $filename . '<hr/>';
          $file->title = (!empty($_REQUEST['title'])) ? $_REQUEST['title'][$index] : $filename;
          $file->description = (!empty($_REQUEST['description'])) ? $_REQUEST['description'][$index] : 'Aucune description';

          $file->name = $this->getRewriteName($filename,$ext);
          
          if (!empty($_REQUEST['recadrage_type']) && $_REQUEST['recadrage_type'][$index] == 'crop') {
               $file->options['crop'] = true;
          } else {
               $this->options['canvas'] = true;
          }
     }

     protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
          $file = parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
          if (empty($file->error)) {
               $sql = 'INSERT INTO `' . $this->options['db_table']
                       . '` (`nom`, `titre`, `description`, `date`)'
                       . ' VALUES (\'' . $file->name . '\',\'' . $file->title . '\',\'' . $file->description . '\', now())';
               //echo $sql;
               //var_dump($this->db);
               $query = $this->db->exec($sql);

               //var_dump($query);
               $file->id = $this->db->insert_id;

               $sql = 'SELECT `id_photo`, `titre`, `description`, date, dformat, rate FROM `'
                       . $this->options['db_table'] . '` WHERE `nom`= \'' . $file->name . '\'';

               //echo $sql;

               foreach ($this->db->query($sql) as $row) {
                    $file->id = $row['id_photo'];
                    $file->title = $row['titre'];
                    $file->description = $row['description'];
                    $file->date = $row['date'];
                    $file->dformat = $row['dformat'];
                    $file->rate = $row['rate'];
               }
          }


          //var_dump($file);
          return $file;
     }

     protected function set_additional_file_properties($file) {
          parent::set_additional_file_properties($file);
          if ($_SERVER['REQUEST_METHOD'] === 'GET') {
               $sql = 'SELECT `id_photo`, `titre`, `description`, date,  dformat, rate FROM `'
                       . $this->options['db_table'] . '` WHERE `nom`= \'' . $file->name . '\'';

               //echo $sql;

               foreach ($this->db->query($sql) as $row) {
                    $file->id = $row['id_photo'];
                    $file->title = $row['titre'];
                    $file->description = $row['description'];
                    $file->date = $row['date'];
                    $file->dformat = $row['dformat'];
                    $file->rate = $row['rate'];
               }
          }
     }

     public function delete($print_response = true) {
          $response = parent::delete(false);
          foreach ($response as $name => $deleted) {
               if ($deleted) {
                    $sql = 'DELETE FROM `' . $this->options['db_table'] . '` WHERE `nom`=\'' . $name . '\'';
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

          $txt = $txt . $ext;
          return $txt;
     }

}
