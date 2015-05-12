<?php if(isset($_GET['journal']) || isset($_POST['journal']) || isset($journal)) echo '<div id="journal"><h4>Journal de développement:</h4> '.$journal.'</div>';?>
</div>
<!-- Javascript -->
<?php 
if(isset($footer['bootstrap'])) {
	if($footer['bootstrap']==TRUE) {
		echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>';
		echo '<script src="/modules/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>';
		echo '<script src="/modules/bootstrap/js/jquery.form.js" type="text/javascript"></script>';
		$footer['jqueryform'] = FALSE ;
	}
}

echo '<!--  Bibliothèque javascript Jquery -->';
if (!isset($footer['jquery'])){
	 if(isset($footer['bootstrap'])) if($footer['bootstrap']!=TRUE) echo '<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>';
}
elseif ($footer['jquery']!=FALSE) if(isset($footer['bootstrap'])) if($footer['bootstrap']!=TRUE) echo '<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>';
else echo '<!-- La variable $footer[jquery] est FALSE -->';

echo '<!-- Toolbox Jquery UI-->';
if (!isset($footer['jquery-ui'])) echo '<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';
elseif ($footer['jquery-ui']!=FALSE) echo '<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';
else echo '<!-- La variable $footer[jquery-ui] est FALSE -->';

echo '<!-- Gestion des formulaires Ajax -->';
if (!isset($footer['jqueryform'])) echo '<script type="text/javascript" src="/js/jquery.form.js"></script>';
elseif ($footer['jqueryform']!=FALSE) echo '<script type="text/javascript" src="/js/jquery.form.js"></script>';
else echo '<!-- La variable $footer[jquery-form] est FALSE -->';

echo '<!--  CK Editor : éditeur html pour les formulaires -->';
if (!isset($footer['editor'])) echo '<script type="text/javascript" src="/modules/ckeditor/ckeditor.js"></script>';
elseif ($footer['editor'] == 'ckeditor') echo '<script type="text/javascript" src="/modules/ckeditor/ckeditor.js"></script>';
else echo '<!-- La variable $footer[ckeditor] est FALSE -->';

echo '<!-- Code Barre Jquery -->';
if (!isset($footer['code_EAN'])) echo '<script type="text/javascript" src="/js/jquery-barcode.min.js"></script>';
elseif ($footer['code_EAN']!=FALSE) echo '<script type="text/javascript" src="/js/jquery-barcode.min.js"></script>';
else echo '<!-- La variable $footer[jquery-form] est FALSE -->';

echo '<!-- Date Picker -->';
if (!isset($footer['date_picker'])) {
	 echo '
		<script type="text/javascript">
			$(function() {
				$( "#datepicker" ).datepicker( {dateFormat: "yy-mm-dd", firstDay:1 });
				$( ".datepicker" ).datepicker( {dateFormat: "yy-mm-dd", firstDay:1 });
			});
		</script>';
}
elseif ($footer['date_picker']!=FALSE)  echo '
		<script type="text/javascript">
			$(function() {
				$( "#datepicker" ).datepicker( {dateFormat: "yy-mm-dd", firstDay:1 });
				$( ".datepicker" ).datepicker( {dateFormat: "yy-mm-dd", firstDay:1 });
			});
		</script>';
?>
</body>
</html>