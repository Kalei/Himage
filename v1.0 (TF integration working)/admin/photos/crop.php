<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/images/photos/conf/himage-conf.php');
?>
<html>
    <head>
        <title>Recadrer l'image</title>
        <meta http-equiv = "Content-type" content = "text/html;charset=UTF-8" />
        <script src = "./js/jquery.min.js"></script>
        <script src="./js/jquery.Jcrop.js"></script>
        <script>
             var $_POST = <?php echo json_encode($_POST); ?>;

             jQuery(function ($) {

                 if ($_POST["format"] == 'horizontal') {
                     var width = 1600 / 5;
                     var height = 1200 / 5;
                     $('#preview-pane .preview-container').css({"width": width,
                         "height": height,
                         "overflow": "hidden"});
                 } else if ($_POST["format"] == 'panoramique') {
                     var width = 1600 / 5;
                     var height = 800 / 5;
                     $('#preview-pane .preview-container').css({"width": width,
                         "height": height,
                         "overflow": "hidden"});

                 } else if ($_POST["format"] == 'carre') {
                     var width = 1600 / 5;
                     var height = 1600 / 5;
                     $('#preview-pane .preview-container').css({"width": width,
                         "height": height,
                         "overflow": "hidden"});

                 } else if ($_POST["format"] == 'vertical') {
                     var width = 1080 / 5;
                     var height = 1600 / 5;
                     $('#preview-pane .preview-container').css({"width": width,
                         "height": height,
                         "overflow": "hidden"});
                 }

                 // Create variables (in this scope) to hold the API and image size
                 var jcrop_api,
                         boundx,
                         boundy,
                         // Grab some information about the preview pane
                         $preview = $('#preview-pane'),
                         $pcnt = $('#preview-pane .preview-container'),
                         $pimg = $('#preview-pane .preview-container img'),
                         xsize = $pcnt.width(),
                         ysize = $pcnt.height();

                 console.log('init', [xsize, ysize]);


                 $('#target').Jcrop({
                     onChange: updatePreview,
                     onSelect: updatePreview,
                     aspectRatio: xsize / ysize
                 }, function () {
                     // Use the API to get the real image size
                     var bounds = this.getBounds();
                     boundx = bounds[0];
                     boundy = bounds[1];
                     // Store the API in the jcrop_api variable
                     jcrop_api = this;

                     // Move the preview into the jcrop container for css positioning
                     $preview.appendTo(jcrop_api.ui.holder);
                 });

                 function updatePreview(c)
                 {
                     $('#x').val(c.x);
                     $('#y').val(c.y);
                     $('#w').val(c.w);
                     $('#h').val(c.h);

                     //alert(c.w+' '+c.h);
                     //alert(c.x+' '+c.y);
                     if (parseInt(c.w) > 0)
                     {
                         var rx = xsize / c.w;
                         var ry = ysize / c.h;

                         $pimg.css({
                             width: Math.round(rx * boundx) + 'px',
                             height: Math.round(ry * boundy) + 'px',
                             marginLeft: '-' + Math.round(rx * c.x) + 'px',
                             marginTop: '-' + Math.round(ry * c.y) + 'px'
                         });
                     }
                 }

                 function checkCoords()
                 {
                     if (parseInt($('#w').val()))
                         return true;
                     alert('Please select a crop region then press submit.');
                     return false;
                 }
             });
        </script>
        <link rel="stylesheet" href="jcrop_style/main.css" type="text/css" />
        <link rel="stylesheet" href="jcrop_style/demos.css" type="text/css" />
        <style type="text/css">

            /* Apply these styles only when #preview-pane has
               been placed within the Jcrop widget */
            .jcrop-holder #preview-pane {
                display: block;
                position: fixed;
                z-index: 2000;
                right: 10px;
                top: 150px;
                padding: 6px;

                border: 1px rgba(0,0,0,.4) solid;
                background-color: white;

                -webkit-border-radius: 6px;
                -moz-border-radius: 6px;
                border-radius: 6px;

                -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            }

            /* The Javascript code will set the aspect ratio of the crop
               area based on the size of the thumbnail preview,
               specified here */
            /*   #preview-pane .preview-container {
                   width: 320px;
                   height: 240px;
                   overflow: hidden;
               }
            */

            #submit_crop {
                z-index: 3000;
                position: fixed;
                right: 30px;
                top: 140px;
            }
        </style>

    </head>
    <body>
        <?php
        ini_set('display_errors', true);
        include './parametrages.php';
        if ($_POST['nom'] && $_POST['format'] && $_POST['src']) {
             $src = $_POST['src'];
             $nom = $_POST['nom'];
             $format = $_POST['format'];
             $zoom = isset($_POST['zoom']) ? $_POST['zoom'] : 1;


             if ($_POST['action'] == 'crop_it') {
                  echo'<ul>';
                  foreach ($parametrages['formats'][$format]['tailles_img'] as $img_size => $img_size_info) {
                       $targ_w = $img_size_info['largeur'];
                       $targ_h = $img_size_info['hauteur'];
                       $qualite = $img_size_info['qualite'];

                       try {
                            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $src)) {
                                 echo "Ce fichier n'existe pas!!!!" . $src;
                                 echo '<a href = "' . $dir_adminphoto . ' ">Retourner au listing des images</a> <span class = "divider">';
                                 die();
                            }

                            $info = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);

                            if ($info === false)
                                 throw new Exception('This file is not a valid image');

                            $type = $info[2];
                            $width = $info[0]; // you don't need to use the imagesx and imagesy functions
                            $height = $info[1];

                            switch ($type) {
                                 case IMAGETYPE_JPEG:
                                      $img_r = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $src);
                                      break;
                                 case IMAGETYPE_GIF:
                                      $img_r = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . $src);
                                      break;
                                 case IMAGETYPE_PNG:
                                      $img_r = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $src);
                                      break;
                                 default:
                                      throw new Exception('This file is not in JPG, GIF, or PNG format!');
                            }
                            //$img_r = imagecreatefromjpeg($src);
                            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

                            //Postion du point de départ de la zone séléctionnée x distance gauche, y distance haut
                            $real_x = ($zoom == 1) ? $_POST['x'] : $_POST['x'] / $zoom;
                            $real_y = ($zoom == 1) ? $_POST['y'] : $_POST['y'] / $zoom;

                            //Taille de la box (ex: carre w=30px h=30pw) le ratio est bon normalement
                            $src_w = ($zoom == 1) ? $_POST['w'] : $_POST['w'] / $zoom;
                            $src_h = ($zoom == 1) ? $_POST['h'] : $_POST['h'] / $zoom;

                            imagecopyresampled($dst_r, $img_r, 0, 0, $real_x, $real_y, $targ_w, $targ_h, $src_w, $src_h);
                       } catch (Exception $e) {
                            echo 'ERREUR : ' . $e->getMessage();
                       }

                       imagejpeg($dst_r, '../..' . $dir_photos . 'formats/' . $format . '/' . $img_size . '/' . $nom, $qualite);
                       //echo $_POST['x'] . ' ' . $_POST['y'] . ' ' . $targ_w . ' ' . $targ_h . ' ' . $_POST['w'] . ' ' . $_POST['h'];
                       imagedestroy($dst_r);
                       //unlink('../../images/photos/' . $format . '/' . $img_size . '/' . trim($del_image['nom_image']));
                  }
                  echo'<ul>';
                  /*  echo '<script>'
                    . 'setTimeout(function () {'
                    . 'window.location.href = "'. $dir_adminphoto .' ?nom=' . $nom . '";}, 2000)'
                    . '</script>';
                    echo 'Le recadrage a bien été effectué <br/>'; */
                  echo '<a href = "' . $dir_adminphoto . '?nom=' . $nom . '">Retourner au listing des images</a> <span class = "divider">';
                  echo '<h3>Résultats: </h3>';
                  echo '<img src ="' . $dir_photos . 'formats/' . $format . '/grandes/' . $nom . '"  alt = "grandes_' . $nom . '" />';
             }

             if ($_POST['action'] == 'recadrage') {
                  list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $src);
                  $zoom = isset($_POST['zoom']) ? $_POST['zoom'] : 1;
                  //echo '<script>alert("zoom : ' . $zoom . ' width: ' . $width . 'px height: ' . $height . 'px new_width' . ($width * $zoom) . '")</script>';
                  ?>

                  <div class="container">
                      <div class="row">
                          <div class="span12">
                              <div class="jc-demo-box">

                                  <div class="page-header">
                                      <ul class="breadcrumb first">
                                          <li><a href="'. $dir_adminphoto .' ">Liste images</a> <span class="divider">/</span></li>
                                          <li class="active">Recadrer l'image - <?php echo $nom . ' (' . $format . ')'; ?></li>
                                      </ul>
                                      <h1>Recadrer l'image - <?php echo $nom . ' (' . $format . ')'; ?></h1>
                                      <form action="" method="POST">
                                          <?php
                                          $zoom_options = array(
                                              "100%" => 1, "75%" => 0.75, "50%" => 0.50, "25%" => 0.25,
                                              "150%" => 1.5, "200%" => 2
                                          );
                                          echo '<select name="zoom" onChange="submit()" >';
                                          foreach ($zoom_options as $zoption_key => $zoption_val) {
                                               $select_zoption = (isset($_POST['zoom']) && $_POST['zoom'] == $zoption_val) ? ' selected="selected" ' : '';
                                               echo '<option value="' . $zoption_val . '" ' . $select_zoption . '>' . $zoption_key . '</option>';
                                          }
                                          echo '</select>';
                                          ?>
                                          <input type = "hidden" id = "nom" name = "nom" value = "<?php echo $nom;
                                          ?>" />
                                          <input type = "hidden" id = "src"  name = "src" value = "<?php echo $src; ?>" />
                                          <input type = "hidden" id = "format" name = "format" value = "<?php echo $format; ?>" />
                                          <input type = "hidden" id = "action" name = "action" value = "recadrage" />
                                          <noscript>
                                          <input type="submit">
                                          </noscript>
                                      </form>
                                  </div>
                                  <form id="submit_crop" action = "crop.php" method = "post" onsubmit="return checkCoords();">
                                      <input type = "hidden" id = "x" name = "x" />
                                      <input type = "hidden" id = "y" name = "y" />
                                      <input type = "hidden" id = "w" name = "w" />
                                      <input type = "hidden" id = "h" name = "h" />
                                      <input type = "hidden" id = "crop_it" name = "crop_it" />
                                      <input type = "hidden" id = "nom" name = "nom" value = "<?php echo $nom; ?>" />
                                      <input type = "hidden" id = "src"  name = "src" value = "<?php echo $src; ?>" />
                                      <input type = "hidden" id = "format" name = "format" value = "<?php echo $format; ?>" />
                                      <input type = "hidden" id = "action" name = "action" value = "crop_it" />
                                      <input type = "hidden" id = "zoom" name = "zoom" value = "<?php echo $zoom; ?>" />
                                      <input style="float:right;"type = "submit" value = "Valider le recadrage" class = "btn btn-small btn-inverse" />
                                  </form>

                                  <img style="<?php echo "width:" . ($width * $zoom) . "px; height:" . ($height * $zoom) . "px"; ?>" src = "<?php echo $src ?>" id = "target" alt = "Image à recadrer"/>

                                  <div class = "clearfix"></div>

                              </div>

                              <div id = "preview-pane">
                                  <h5>Aperçue miniature</h5>
                                  <div class = "preview-container">
                                      <img src = "<?php echo $src ?>" class = "jcrop-preview" alt = "Preview" />
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>

              </body>
          </html>
          <?php
     }
} else {
     echo 'Erreur parametres manquant.';
     echo '<a href = "' . $dir_adminphoto . ' ">Liste images</a> <span class = "divider">';
}    