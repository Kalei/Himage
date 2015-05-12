<html>
    <body>
        <?php
        $dir = isset($_GET['dir']) ? $_GET['dir'] : '.';
        $BASE = ".";

        function list_dir($base, $cur, $level = 0) {
             global $PHP_SELF, $BASE;
             $dir = opendir($BASE);
             if ($dir != FALSE) {
                  while ($entry = readdir($dir)) {
                       /* chemin relatif à la racine */
                       $file = $base . "/" . $entry;
                       if (is_dir($file) && !in_array($entry, array(".", ".."))) {
                            /* marge gauche */
                            for ($i = 1; $i <= (4 * $level); $i++) {
                                 echo "&nbsp;";
                            }
                            /* l'entrée est-elle le dossier courant */
                            if ($file == $cur) {
                                 echo "<b>$entry</b><br />\n";
                            } else {
                                 echo "<a href=\"$PHP_SELF?dir=" . rawurlencode($file) . "\">$entry</a><br />\n";
                            }
                            /* l'entrée est-elle dans la branche dont le dossier courant est la feuille */
                            if (ereg($file . "/", $cur . "/")) {
                                 list_dir($file, $cur, $level + 1);
                            }
                       }
                  }
                  closedir($dir);
             }
        }

        function list_file($cur) {
             $dir = opendir($cur);
             if ($dir != FALSE) {
                  while ($file = readdir($dir)) {
                       echo "<a href='$cur/$file'>$file</a><br />\n";
                  }
                  closedir($dir);
             }
        }
        ?>
        
        <h1>Projet Himage</h1>

        <table width="100%" border="1" cellspacing="0" cellpadding="10" bordercolor="gray">
            <tr valign="top"><td>

                    <!-- liste des répertoires
                    et des sous-répertoires -->
                    <?php
                    /* lien sur la racine */

                    echo "<a href=\"index.php\">/</a><br />";

                    var_dump($dir);
                    list_dir($BASE, rawurldecode($dir), 1);
                    ?>

                </td><td>

                    <!-- liste des fichiers -->
                    <?php
                    /* répertoire initial à lister */
                    if (!isset($dir)) {
                         $dir = $BASE;
                    }
                    list_file(rawurldecode($dir));
                    ?>

                </td></tr>
        </table>

    </body>
</html>