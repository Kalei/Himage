<?php

/**
 * Fichier de configuration du logiciel de gestion d'image
 * 
 * - Penser a modifier le fichier index dans /admin/photos/index.php
 * 
 * V1 en dur 
 * V2 avec objet global_param => penser a faire un create table if not exist voir photo.sql / global_param.sql
 */
$start = $_SERVER['DOCUMENT_ROOT'] . '/Himage/includes-exemple/start2.php';
include($start); // Base de données et fonctions communes

function myAutoloader($class) {
     require_once $_SERVER['DOCUMENT_ROOT'] . '/Himage/v1.0/includes/model/' . $class . '.class.php';
}

spl_autoload_register('myAutoloader');

$entete = $_SERVER['DOCUMENT_ROOT'] . globalParamTable::getGlobalParamValueFromNom('dir_entete');


$dir_adminphoto = globalParamTable::getGlobalParamValueFromNom("dir_adminphoto");

$list_champs = unserialize(globalParamTable::getGlobalParamValueFromNom('himage_table_champs'));

$himage_services = unserialize(globalParamTable::getGlobalParamValueFromNom('himages_services'));
$dir_photos = globalParamTable::getGlobalParamValueFromNom('dir_photos');
$dir_modules = globalParamTable::getGlobalParamValueFromNom('dir_modules');
$himage_table = globalParamTable::getGlobalParamValueFromNom('himage_table');
$crop_or_canvas = globalParamTable::getGlobalParamValueFromNom('crop_or_canvas');
$rubrique = '';
$html_head['js'] = array();
$html_head['css'] = array();
//Autres options (à implementer / option-list)

$himage_bg_color = globalParamTable::getGlobalParamValueFromNom('himage_bg_color');
//Options du CustomHandler
$options = array(
    'delete_type' => 'POST',
    'db_host' => globalParamTable::getGlobalParamValueFromNom('db_host'),
    'db_user' => globalParamTable::getGlobalParamValueFromNom('db_user'),
    'db_pass' => globalParamTable::getGlobalParamValueFromNom('db_pass'),
    'db_prot' => globalParamTable::getGlobalParamValueFromNom('db_port'),
    'db_name' => globalParamTable::getGlobalParamValueFromNom('db_name'),
    'db_table' => globalParamTable::getGlobalParamValueFromNom('himage_table'),
    'script_url' => get_full_url() . '/',
    'upload_dir' => dirname(get_server_var('SCRIPT_FILENAME')) . '/formats/source/',
    'upload_url' => get_full_url() . '/formats/source/',
    'user_dirs' => false,
    'mkdir_mode' => 0777,
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
    'sort' => 'ID_DESC',
    //Nouvelles fonctionnalité (valeurs par défault)
    'page' => 0,
    'nb_max' => 10,
    'recadrage_type' => $crop_or_canvas,
    /////////////////////////////////////////////////
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
    'bg_color' => $himage_bg_color,
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
            'max_width' => 80,
            'max_height' => 80
        )
    )
);

function get_full_url() {
     $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
             !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
             strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
     return
             ($https ? 'https://' : 'http://') .
             (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
             (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                     ($https && $_SERVER['SERVER_PORT'] === 443 ||
                     $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
             substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
}

function get_server_var($id) {
     return isset($_SERVER[$id]) ? $_SERVER[$id] : '';
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $dir_photos)) {
     include $_SERVER['DOCUMENT_ROOT'] . $dir_photos . '/conf/himage-conf-debug.php';
} else {
     $himage_conf_error [] = "himage directories: Veuillez créer l'arboressence de fichier sous le repertoir '" . $dir_photos . "' ou le chemin indiqué n'est pas valide.";
}