<?php
if (empty($html_head)) {
     if (!isset($js))
          $js = '';
     if (!isset($css))
          $css = '';
     if (!isset($code_ean))
          $code_ean = '';
     if (!isset($date_picker))
          $date_picker = '';
     $html_head = array(
         'title' => $title,
         'css' => $css,
         'code_EAN' => $code_ean,
         'editor' => 'ckeditor',
         'jquery' => TRUE,
         'jquery-ui' => TRUE,
         'date_picker' => TRUE,
         'fancybox' => FALSE,
         'jqueryform' => FALSE,
         'display_error' => FALSE
     );
}
if (isset($html_head['display_error']))
     if ($html_head['display_error'] == TRUE) {
          // Afficher les erreurs à l'écran
          ini_set('display_errors', 1);
          // Enregistrer les erreurs dans un fichier de log
          ini_set('log_errors', 1);
          // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
          ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
          // On augmente le temps d'éxécution d'un script
          set_time_limit(20000);
          ob_implicit_flush(TRUE);
     }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $html_head['title'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href='http://fonts.googleapis.com/css?family=Quicksand:300,400' rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'/>
                <link rel="stylesheet" href=<?php echo $dir_modules . "/bootstrap/css/bootstrap.min.css" ?> />
                <!-- CSS par défaut pour Jquery UI -->                    
                <link src="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" /> 

                <!-- CSS Supplémentaires -->
                <?php
                if (is_array($html_head['css']))
                     foreach ($html_head['css'] as $css)
                          echo $css;
                else
                     echo $html_head['css'];
                ?>
                </head>
                <body>
                    <nav class="navbar navbar-default noprint">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#">Himage Gestinnaire d'image</a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                                <ul class="nav navbar-nav">

                                </ul>
                            </div><!-- /.navbar-collapse -->

                        </div><!-- /.container-fluid -->
                    </nav>
                    <div class="container-fluid">
                        <div class="containter" id="contenu_2015">
                            <?php
                            if (isset($titre))
                                 echo '<h2>' . $titre . '</h2>';

                            if (isset($alert_ko))
                                 echo '<ul class="ko">' . $alert_ko . '</ul>';
                            if (isset($alert_ok))
                                 echo '<ul class="ok">' . $alert_ok . '</ul>';
// Rapport 
                            if (isset($rapport['ok'])) {
                                 echo '<div class="noprint">';
                                 echo '<h3>Rapport</h3>';
                                 echo '<ul class="ok">';
                                 foreach ($rapport['ok'] as $info => $valeur) {
                                      echo '<li>' . $info . ' : ' . $valeur . '</li>';
                                 }
                                 echo '</ul>';
                                 echo '</div>';
                            }
                            if (isset($rapport['ko'])) {
                                 echo '<div class="noprint">';
                                 echo '<h3>Rapport d\'erreurs</h3>';
                                 echo '<ul class="ko">';
                                 foreach ($rapport['ko'] as $info => $valeur) {
                                      echo '<li>' . $info . ' : ' . $valeur . '</li>';
                                 }
                                 echo '</ul>';
                                 echo '</div>';
                            }
                            ?>