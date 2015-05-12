<?php
/*
  if ($_GET['action'] == 'copy') {
  if (recurse_copy('<?php echo $dir_photos; ?>formats/source/f/', '<?php echo $dir_photos; ?>formats/source/')) {
  echo 'Les fichiers ont bien été changés de répertoir';
  }
  }

  function recurse_copy($src, $dst) {
  $dir = opendir($src);
  @mkdir($dst);
  while (false !== ( $file = readdir($dir))) {
  if (( $file != '.' ) && ( $file != '..' )) {
  if (is_dir($src . '/' . $file)) {
  recurse_copy($src . '/' . $file, $dst . '/' . $file);
  } else {
  copy($src . '/' . $file, $dst . '/' . $file);
  }
  }
  }

  } */// Désactiver le rapport d'erreurs
?>
<div class="row">        
    <div style="padding-left: 40px" class="col-md-3">
        <?php
        if ($himage_services['recherche'] == TRUE) {
             ?>
             <form action="index.php" method="GET" >
                 <input type="text" name="recherche" /> 
                 <input type="submit" value="rechercher"/>
             </form>
        <?php } ?>
    </div>
    <div class="col-md-2">
        <form action="index.php" method="GET" >
            <label for="sort-form">Organiser par</label>
            <?php echo (isset($_GET['recherche'])) ? '<input type="hidden" name="recherche" value="' . $_GET['recherche'] . '"/>' : ''; ?>
            <select class="sort-form" name="sort" onchange="submit();">
                <option <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'ID_DESC') ? 'selected' : ''; ?> value = "ID_DESC" >Ajouts décroissants</option>
                <option <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'ID_ASC') ? 'selected' : ''; ?> value = "ID_ASC">Ajouts croissants</option>
                <option <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'RATE_DESC') ? 'selected' : ''; ?>  value = "RATE_DESC">Notes décroissantes</option>
                <option <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'RATE_ASC') ? 'selected' : ''; ?>  value = "RATE_ASC">Notes croissantes</option>
            </select>
        </form>
    </div>
</div>
<div class = "row" style = "margin: 10px;">
    <div class = "col-md-12">
        <!--The file upload form used as target for the file upload widget -->
        <form id = "fileupload" action = "<?php echo $dir_photos; ?>" method = "POST" enctype = "multipart/form-data">
            <!--The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class = "row fileupload-buttonbar">
                <div class = "col-md-7">
                    <!--The fileinput-button span is used to style the file input field as button -->
                    <span class = "btn btn-success fileinput-button">
                        <i class = "glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input type = "file" name = "files[]" multiple>
                    </span>
                    <button type = "submit" class = "btn btn-primary start">
                        <i class = "glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>
                    <button type = "reset" class = "btn btn-warning cancel">
                        <i class = "glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                    </button>
                    <button type = "button" class = "btn btn-danger delete">
                        <i class = "glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <span class = "fileupload-process"></span>
                </div>
                <!--The global progress state -->
                <div class = "col-md-5 fileupload-progress fade">
                    <!--The global progress bar -->
                    <div class = "progress progress-striped active" role = "progressbar" aria-valuemin = "0" aria-valuemax = "100">
                        <div class = "progress-bar progress-bar-success" style = "width:0%;"></div>
                    </div>
                    <!--The extended global progress state -->
                    <div class = "progress-extended">&nbsp;
                    </div>
                </div>
            </div>
            <?php
            if (globalParamTable::getGlobalParamValueFromNom('pagination'))
                 include('navigation.php');
            ?>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped row">
                <tbody class="files"></tbody>
            </table>
            <?php if (globalParamTable::getGlobalParamValueFromNom('pagination')) include('navigation.php'); ?>
        </form>
        <br>
        <!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
    </div>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {%for (var i=0, file; file=o.files[i]; i++) { %}     
    <tr class="template-upload fade">
    <td>
    <span class="preview col-md-1"></span>
    </td>
    <td class="col-md-7">
    {%    
    var ext = file.name.substring(file.name.lastIndexOf("."));
    var file_name = file.name.substring(0,file.name.indexOf(".",0));  
    %}
    <p class="name"><label>Nom: <input name="name[]" required size="50" value="{%=file_name%}"/>{%=ext%}</label></p>
    <input type="hidden" name="extension[]" value="{%=ext%}" />
    <p>
    <label>Recadrage automatique:
    <select class="recadrage_type" name="recadrage_type[]">
    <option selected value="canvas" >default (canvas)</option>
    <option value="crop">crop</option>
    </select>
    </label>
    </p>
    <!-- p class="title"><label>Title: <input name="title[]" size="30"></label></p>
    <p><label>Description: <input name="description[]" size="50" / ></label></p>
    <p class="description">{%=file.description||''%}</p -->

    <strong class="error text-danger"></strong>
    </td>
    <td class="col-md-1">
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    <p class="size">Processing...</p>
    </td>
    <td class="col-md-3">
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download --> 
<script id="template-download" type="text/x-tmpl">

    {% 
    o.files
    var string_filter = getUrlParameter('recherche') ? getUrlParameter('recherche') : false;

    for (var i=0, file; file=o.files[i]; i++) { 
    file=o.files[i];

    if(i>=o.files.length){break;}

    //if(file==false) break;
    //alert(i+' et '+(page_actuel*page_elements));
    %}
    <tr class="template-download fade">
    <td  class="preview col-md-1">
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% }else{ %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo $dir_photos; ?>formats/carre/petites/{%=file.name%}"/></a>
    {% }%}
    </span>
    </td>
    <td  class="col-md-5">
    <p class="title">
    <form action="./modif_infos.php" methode="GET" class="form-titre">
    <label style="margin-right:10px;">Title: </label>
    <input size="30" class="input-text" type="text" name="titre_value" value="{%=file.title||''%}" />
    <input  type="submit" value="Modifier" />
    <input type="hidden" name="id_photo" value="{%=file.id||''%}" />
    <input type="hidden" name="action" value="titre" />
    </form>
    </p>
    <p class="description">
    <form action="./modif_infos.php" methode="GET" class="form-description">
    <label style="margin-right:10px;">Description: </label>
    <input size="60" class="input-text" name="description_value" type="text" value="{%=file.description||''%}" />
    <input type="submit" value="Modifier" />
    <input type="hidden" name="id_photo" value="{%=file.id||''%}" />
    <input type="hidden" name="action" value="description" />
    </form>
    </p>
    <p class="description">
    <form action="./modif_infos.php" methode="GET" class="form-nom">
    <label style="margin-right:10px;">Nom: </label>
    <input size="30" class="input-text" name="nom_value" type="text" value="{%=file.name.substring(0,file.name.indexOf(".",0))%}" /><span>{%=file.name.substring(file.name.lastIndexOf("."))%}</span>
    <input type="submit" value="Modifier" />
    <input type="hidden" name="extension_value" value="{%=file.name.substring(file.name.lastIndexOf("."))%}" />
    <input type="hidden" name="oldnom_value" value="{%=file.name.substring(0,file.name.indexOf(".",0))%}" />
    <input type="hidden" name="id_photo" value="{%=file.id||''%}" />
    <input type="hidden" name="action" value="nom" />
    </form>
    </p>

    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td  class="col-md-2">
    <p><span class="date">Ajouté le {%=file.date%}</span></p>
    <p><span class="size">{%=o.formatFileSize(file.size)%}</span></p>
    <p><span class="date">Id en base {%=file.id%}</span></p>
    </td>
    <td>
    <?php if ($himage_services['rate'] == TRUE) { ?>
         <label>Notation</label>
         <form class="rate-form" action="./modif_infos.php" methode="GET">
         <ul id="rank-list-{%=file.id||''%}" class="notes-echelle list-inline">
         <li class="{%if(file.rate<1){ %}note-off{% } %} {%if(file.rate==1){ %}note-checked{% } %}">
         <label for="note01-{%=file.id||''%}" title="Note&nbsp;: 1 sur 5"></label>
         <input type="radio" name="rate_value" id="note01-{%=file.id||''%}" value="1"  {%if(file.rate==1){ %}checked{% } %}/>
         </li>
         <li class="{%if(file.rate<2){ %}note-off{% } %} {%if(file.rate==2){ %}note-checked{% } %}">
         <label for="note02-{%=file.id||''%}" title="Note&nbsp;: 2 sur 5"></label>
         <input type="radio" name="rate_value" id="note02-{%=file.id||''%}" value="2"  {%if(file.rate==2){ %}checked{% } %}/>
         </li>
         <li class="{%if(file.rate<3){ %}note-off{% } %} {%if(file.rate==3){ %}note-checked{% } %}">
         <label for="note03-{%=file.id||''%}" title="Note&nbsp;: 3 sur 5"></label>
         <input type="radio" name="rate_value" id="note03-{%=file.id||''%}" value="3"  {%if(file.rate==3){ %}checked{% } %}/>
         </li>
         <li class="{%if(file.rate<4){ %}note-off{% } %} {%if(file.rate==4){ %}note-checked{% } %}">
         <label for="note04-{%=file.id||''%}" title="Note&nbsp;: 4 sur 5"></label>
         <input type="radio" name="rate_value" id="note04-{%=file.id||''%}" value="4"  {%if(file.rate==4){ %}checked{% } %}/>
         </li>
         <li class="{%if(file.rate<5){ %}note-off{% } %} {%if(file.rate==5){ %}note-checked{% } %}">
         <label for="note05-{%=file.id||''%}" title="Note&nbsp;: 5 sur 5"></label>
         <input type="radio" name="rate_value" id="note05-{%=file.id||''%}" value="5" {%if(file.rate==5){ %}checked{% } %}/>
         </li>
         </ul>
         <input type="hidden" name="id_photo" value="{%=file.id||''%}" />
         <input type="hidden" name="action" value="rate" />
         </form>
    <?php } ?>
    <br/>
    <br/>
    <?php if ($himage_services['dformat'] == TRUE) { ?>
         <label>Format par défault</label>
         <form action="./modif_infos.php" methode="GET">
         <input type="hidden" name="id_photo" value="{%=file.id||''%}" />
         <input type="hidden" name="action" value="dformat" />
         <select class="dformat_list" name="dformat_value">
         <option {% if (file.dformat == "carre") { %} selected {% } %} value="carre">Carre</option>
         <option {% if (file.dformat == "panoramique") { %} selected {% } %} value="panoramique">Panoramique</option>
         <option {% if (file.dformat == "horizontal") { %} selected {% } %} value="horizontal">Horizontal</option>
         <option {% if (file.dformat == "vertical") { %} selected {% } %} value="vertical">Vertical</option>
         </select>
         </form>
    <?php } ?>
    </td>
    <td  class="col-md-2">
    {% if (file.deleteUrl) { %}
    <?php if ($himage_services['tags'] == TRUE) { ?>
         <p><a style="margin-top:10px;" href="#tags_{%=file.id||''%}" class="btn btn-primary" data-toggle="modal" data-target="#tags_{%=file.id||''%}">
         <i class="glyphicon glyphicon-tags"></i>
         <span>Gestion des Tags/Infos</span> 
         </a></p>    
    <?php } ?>
    <p>
    <a href="#collapse_{%=file.id||''%}" class="btn btn-info show_formats" data-toggle="collapse">
    <i class="glyphicon glyphicon-resize-full"></i>
    <span> Show formats</span> 
    </a></p>

    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-trash"></i>
    <span>Delete</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle"> 
    <?php if ($himage_services['tags'] == TRUE) { ?>
         <div class="modal fade" style="height:80%;" id="tags_{%=file.id||''%}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog"  style="width: 70%;">
         <div class="modal-content">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="exampleModalLabel"> {% if (file.thumbnailUrl) { %}
         <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
         {% }else{ %}
         <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="/images/photos/carre/petites/{%=file.name%}" width="80"/></a>
         {% }%}Tags associé à '{%=file.name||''%}'</h4>
         </div>
         <div class="modal-body">
         <form role="form" action="tags_controller.php" method="GET" name="form_tags" class="form_tags" 
         onsubmit="var $form = $( this ),url = $form.attr( 'action' ), data = $(this).serialize();
         var link = url+'?'+data;
         $.getJSON( link, function( data ) {
         var first = '<li style=\'background-color: skyblue; display: inline-block;  -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; border:1px; border-style: solid; padding: 2px; margin-top: 5px;\'>';
         var second = '<span style= \'font-weight: bold;margin-right:3px;\'>'+data.libelle+'</span>';
         var third =  '<span style=\'border-left: 1px solid #333; padding-right:2px;\'></span>';
         var forth = '<a  class=\'delete_tag\' href=\'tags_controller.php?action=delete&id_tag='+data.id_tag+'\'>Ã—</a></span></li>';
         var all = first+second+third+forth;
         $(all).appendTo('#image_'+data.id_image+' .tags_display');
         });
         return false;" >

         <div class="form-group">
         <label class="control-label">Selectionner Tags...</label>
         <div class="filter_list">
         </div>
         <input type="hidden" name="action" value="add" />
         <input type="hidden" class="id_image_save" name="id_image" value="{%=file.id||''%}" />
         <input type="submit" class="save_tag btn btn-primary" style="margin-top:5px;" disabled="disabled"/>
         </div>
         </form>
         <div class="bs-example" id="tags_list" style="background-color: #ddd; min-height:200px; padding:10px;">
         <ul class="tags_display" style="padding-left:0;">
         {%
         if(file.tags != null){
         for(var j=0; j<file.tags.length; j++){
         var tag = file.tags[j];
         %}
         <li style="background-color: skyblue; display: inline-block;  -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; border:1px; border-style: solid; padding: 2px; margin-top: 5px;">
         <span style="font-weight: bold;margin-right:3px;">{%=tag.libelle %}</span>
         <span style="border-left: 1px solid #333; padding-right:2px;"></span>
         <a  class="delete_tag" style="" href="tags_controller.php?action=delete&id_tag={%=tag.id_tag %}">Ã—</a></span>
         </li>
         {%  
         }
         }
         %}
         </ul>
         </div>
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
         </div>
         </div>
         </div>
    <?php } ?>

    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    <tr class="row" style="padding:0;">
    <td colspan="3" style="padding:0;">
    <div id="collapse_{%=file.id||''%}" class="panel-collapse collapse" style="padding:0;">
    <div class="panel-body">
    <div class="col-md-3">
    <h4>horizontal</h4>
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo $dir_photos; ?>formats/horizontal/petites/{%=file.name%} "/></a>
    <form action="crop.php" method="post" name="Recadrer">
    <input type="hidden" name="nom" value="{%=file.name%}" />
    <input type="hidden" name="format" value="horizontal" />
    <input type="hidden" name="action" value="recadrage" />
    <input type="hidden" name="r" value="admin/photo/index.php" />
    <input type="hidden" name="src" value="<?php echo $dir_photos; ?>formats/source/{%=file.name%}" />
    <button type="submit" value=" Send" class="btn alert-info" id="submit" style="position: absolute;margin-top: -60px;margin-left: 100px;"><i class="glyphicon glyphicon-resize-small"></i>Recadrer</button>
    </form>
    </div>
    <div class="col-md-3">
    <h4>carre</h4>
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo $dir_photos; ?>formats/carre/petites/{%=file.name%}"/></a>
    <form action="crop.php" method="post" name="Recadrer">
    <input type="hidden" name="nom" value="{%=file.name%}" />
    <input type="hidden" name="format" value="carre" />
    <input type="hidden" name="action" value="recadrage" />
    <input type="hidden" name="r" value="admin/photo/index.php" />
    <input type="hidden" name="src" value="<?php echo $dir_photos; ?>formats/source/{%=file.name%}" />
    <button type="submit" value=" Send" class="btn alert-info" id="submit" style="position: absolute;margin-top: -60px;margin-left: 100px;"><i class="glyphicon glyphicon-resize-small"></i>Recadrer</button>
    </form>
    </div>
    <div class="col-md-4">
    <h4>panoramique</h4>
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo $dir_photos; ?>formats/panoramique/petites/{%=file.name%} "/></a>
    <form action="crop.php" method="post" name="Recadrer">
    <input type="hidden" name="nom" value="{%=file.name%}" />
    <input type="hidden" name="format" value="panoramique" />
    <input type="hidden" name="action" value="recadrage" />
    <input type="hidden" name="r" value="admin/photo/index.php" />
    <input type="hidden" name="src" value="../../photo/photos/formats/source/{%=file.name%}" />
    <button type="submit" value=" Send" class="btn alert-info" id="submit" style="position: absolute;margin-top: -60px;margin-left: 285px;"><i class="glyphicon glyphicon-resize-small"></i>Recadrer</button>
    </form>
    </div>
    <div class="col-md-2">
    <h4>vertical</h4>
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo $dir_photos; ?>formats/vertical/petites/{%=file.name%}"/></a>
    <form action="crop.php" method="post" name="Recadrer">
    <input type="hidden" name="nom" value="{%=file.name%}" />
    <input type="hidden" name="format" value="vertical" />
    <input type="hidden" name="action" value="recadrage" />
    <input type="hidden" name="r" value="admin/photo/index.php" />
    <input type="hidden" name="src" value="<?php echo $dir_photos; ?>formats/source/{%=file.name%}" />
    <button type="submit" value=" Send" class="btn alert-info" id="submit" style="position: absolute;margin-top: -60px;margin-left: 100px;"><i class="glyphicon glyphicon-resize-small"></i>Recadrer</button>
    </form>
    </div>
    </div>
    </div>
    </td>
    </tr>
    {%
    } %}

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo $dir_modules . "JUpload/js/vendor/jquery.ui.widget.js"; ?>" ></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.iframe-transport.js" ?>" ></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload.js"; ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-process.js" ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-image.js" ?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-audio.js" ?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-video.js" ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-validate.js" ?>"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo $dir_modules . "JUpload/js/jquery.fileupload-ui.js" ?>"></script>

<!-- A modifier pour addapter le comportement js au momen de l'upload et le chemin du script php -->
<!-- The main application script -->
<script src="./js/main.js"></script>


<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->


<?php
//    <tr>
//        <td colspan="2">
//            <nav>
//                <ul class="pagination">
//                    <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
//                    {%
//                    for (var i=0, file; file=o.files[i]; i++) { 
//                        if(file.id>0){
//                            total_elements++; 
//                            if(parseFloat(total_elements/page_elements) == parseInt(total_elements/page_elements)){ %}
//                            <li {%=((page_actuel == (total_elements/page_elements)) ? "class=active" : " ")%}><a href="#">{%=(total_elements/page_elements) %}</a></li>
//                            
//                    {%      }
//                        }
//                    }
//                    %}
//                    <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
//                </ul>
//            </nav>
//        </td>
//        <td colspan="2">{%=page_elements %} / {%=total_elements %} en cour de réalisation</td>
//    </tr>
?>