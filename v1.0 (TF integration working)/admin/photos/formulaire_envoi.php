<h2>Ajout d'une image</h2>
<p class="ko"><big>!</big> Attention : l'image ne doit pas dépasser 2 Mo</p>
<form action="index.php" method="post"  enctype="multipart/form-data">
	<input type="hidden" value="journal" name="journal" />
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	<table class="liste">
		<tr>
			<td colspan="2"><label for="image">Votre fichier</label> : <input type="file" name="image" id="image" />
				</td>
		
			<td colspan="2"><label for="titre_image">Titre de l'image (unique)</label>(64) : <input type="text" name="titre_image" id="titre_image"  size="60" maxlength="60" /><br />
<input type="checkbox" name="remplacer" /><label for="remplacer">Remplacer si nom déjà existant</label></td>
		</tr>			
<?php
foreach ($parametrages['rubriques'] as $rubrique => $rubrique_info) {
	$cellule_class = ( $cellule_class == "cellule2") ? "cellule1" : "cellule2";
	echo '<tr class="'.$cellule_class.'">';
	if( $rubrique =='index') echo '<td colspan="4"><input type="hidden" name="'.$rubrique.'" id="'.$rubrique.'" value="on" /></td>';
	else {
		echo '<td colspan="4" align="left"><input type="checkbox" name="'.$rubrique.'" id="'.$rubrique.'" checked="checked" /><label for="'.$rubrique.'">'.$rubrique.'</label><br />
<table class="liste" width="100%">';
	
		foreach ($rubrique_info['tailles_img'] as $img_size =>$img_size_info) {
			echo '<tr><td><strong>/'.$img_size.'/</strong> L:'.$img_size_info['largeur'].' x H:'.$img_size_info['hauteur'].' ';
			if($img_size_info['adapter_image'] == FALSE) echo '<strong>fixes</strong>';
			else echo '<strong>variables</strong>';
			echo '';
		
			echo '</td><td><label for="priorite">Priorité</label>
				<select name="priorite'.$rubrique.$img_size.'">
					<option value="largeur">Largeur</option>
					<option value="hauteur">Hauteur</option>
				</select>
			</td>
			<td><label for="origine_h">Origine horizontale</label>
				<select name="origine_h'.$rubrique.$img_size.'">
					<option value="centre">Centre</option>
					<option value="gauche">Gauche</option>
					<option value="droite">Droite</option>
				</select>
			</td>
			<td>
				<label for="origine_v">Origine verticale</label>
				<select name="origine_v'.$rubrique.$img_size.'">
					<option value="centre">Centre</option>
					<option value="haut">Haut</option>
					<option value="bas">Bas</option>
				</select>
			</td></tr>';
		}
		echo '</table></td>';
	}
}
?>	
	</table>
	<p><!--input type="submit" value="Analyser" name="action" /--><input type="submit" name="action" value="Envoyer" /></p>
</form>	