<?php

/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
/* $options = array(
  'delete_type' => 'POST',
  'db_host' => 'localhost:8889',
  'db_user' => 'abrideceu',
  'db_pass' => 'aRt6ndh32',
  'db_name' => 'abrideceu',
  'db_table' => 'images_pages'
  ); */


//Je ne sais pas pourquoi le chemin absolu ne marche pas, à voir sous environnement en ligne
error_reporting(E_ALL | E_STRICT);
require ('./conf/himage-conf.php');
require('CustomUploadHandler.php');

if (isset($_GET['page']) && isset($_GET['nb_max'])) {
     $options['page'] = $_GET['page'];
     $options['nb_max'] = $_GET['nb_max'];
}

$options['sort'] = isset($_GET['sort']) ? $_GET['sort'] : 'ID_DESC';

if (isset($_GET['recherche'])) {
     $options['recherche'] = $_GET['recherche'];
}

$options['recadrage_type'] = (isset($_REQUEST['recadrage_type'][0]) && $_REQUEST['recadrage_type'][0] == 'crop') ? $options['recadrage_type'] = 'crop' : $options['recadrage_type'] = 'canvas';

$upload_handler = new CustomUploadHandler($options);
