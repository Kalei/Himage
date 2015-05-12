<!DOCTYPE html>
<html>
    <head>
        <title>
            Exemple de HTML
        </title>
    </head>
    <body>
        <a class="hex-twitch" href="http://www.twitch.tv/miklassqc" target="_blank">
            <span class="hb hb-lg">
                <img class="logo-twitch" src="img/twitch-logo.jpg" alt="Twitch" style="z-index:0">

                <?php
                $channels = array('miklassqc');

                $callAPI = implode(",", $channels);
                $online = 'online.png';
                $offline = 'offline.png';
                $dataArray = json_decode(@file_get_contents('https://api.twitch.tv/kraken/streams?channel=' . $callAPI), true);

                if (count($dataArray['streams']) == 1) {
                     $mydata = $dataArray['streams'][0];
                     if (isset($mydata['_id']) && $mydata['_id'] != null) {
                          $name = $mydata['channel']['display_name'];
                          $game = $mydata['channel']['game'];
                          $url = $mydata['channel']['url'];
                          echo "<p style='font-size:0.1em; margin-left:30px; margin-top:-115px; z-index:10;transform: rotate(-30deg);' class='Online'>ONLINE</p>";
                     }
                } else {
                     echo "<p style='font-size:0.1em; margin-left:30px; margin-top:-115px; z-index:10;transform: rotate(-30deg);' class='Offline'>OFFLINE</p>";
                }
                ?>
            </span>
        </a>
        <div class="num_para"><p>0</p></div>
        <div class="part">
            <textarea class="my-input"><h2>Ceci est mon test 0</h2><p>On test cette valeur 0</p></textarea>
            <a href="#" class="btn_fusion">Fusion</a>
        </div>
        <div class="num_para"><p>1</p></div>
        <div class="part">
            <textarea class="my-input"><h2>Ceci est mon test1</h2><p>On test cette valeur 1</p></textarea>
            <a href="#" class="btn_fusion">Fusion</a>
        </div>
        <div class="num_para"><p>2</p></div>
        <div class="part">
            <textarea class="my-input"><h2>Ceci est mon test2</h2><p>On test cette valeur 2</p></textarea>
            <a href="#" class="btn_fusion">Fusion</a>
        </div>
    </body>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script>
         $(document).ready(function () {
             $(document).on("click", ".btn_fusion", function (event) {
                 var current_text = $(this).prev('textarea').val();
                 var prev_text = $(this).parent('.part').prevAll('.part:first').find('textarea').val();

                 if (prev_text !== undefined) {
                     var merge_text = prev_text + current_text;
                     $(this).parent('.part').prevAll('.part:first').find('textarea').val(merge_text);
                     $(this).parent('.part').prevAll('.num_para:first').remove();
                     $(this).parent('.part').nextAll('.num_para').each(function (index) {
                         $(this).text($(this).text() - 1);
                     });
                     $(this).parent('.part').remove();
                 } else {
                     alert('impossible de fusionner avec un vers le haut !');
                 }
             });

             $(document).on("textarea", ".btn_fusion", function (event) {

             });

         });
    </script>
</html>

