<?php if(!defined('PLX_ROOT')) exit; ?>

<?php
# Control du token du formulaire
plxToken::validateFormToken($_POST);
?>


<?php $nbchamp = sizeof($plxPlugin->getParams())/4; ?>

<?php
if(!empty($_POST)) {

$newchamp = $nbchamp + 1;


	if (!empty($_POST['label-new']) AND !empty($_POST['champ-new']) AND !empty($_POST['type-new'])) {
		$plxPlugin->setParam('label'.$newchamp, $_POST['label-new'], 'string');
		$plxPlugin->setParam('champ'.$newchamp, str_replace("-","_",plxUtils::title2url($_POST['champ-new'])), 'string');
		$plxPlugin->setParam('type'.$newchamp, $_POST['type-new'], 'string');
		if (empty($_POST['groupe-new'])) { // si le champ groupe n'est pas renseigné -> on crée le groupe "divers"
			$plxPlugin->setParam('groupe'.$newchamp, "Divers", 'string');
		} else {
			$plxPlugin->setParam('groupe'.$newchamp, $_POST['groupe-new'], 'string');
		}
	}

	for($i=1; $i<=$nbchamp; $i++) {
		$plxPlugin->setParam('label'.$i, $_POST['label'.$i], 'string');
		$plxPlugin->setParam('champ'.$i, str_replace("-","_",plxUtils::title2url($_POST['champ'.$i])), 'string');
		$plxPlugin->setParam('type'.$i, $_POST['type'.$i], 'string');
		$plxPlugin->setParam('groupe'.$i, $_POST['groupe'.$i], 'string');
	}
$plxPlugin->saveParams();
header('Location: parametres_plugin.php?p=champArt');
exit;
}
?>
<div id="champart">
<h2><?php $plxPlugin->lang('L_TITLE') ?></h2>
<p><?php $plxPlugin->lang('L_DESCRIPTION') ?></p>
<form action="parametres_plugin.php?p=champArt" method="post" class="champart">
<fieldset>
<table class="champart table">
	<thead>
		<tr>
			<th><?php $plxPlugin->lang('L_ID') ?></th>
			<th><?php $plxPlugin->lang('L_LABEL') ?></th>
			<th><?php $plxPlugin->lang('L_CHAMP') ?></th>
			<th><?php $plxPlugin->lang('L_TYPE') ?></th>
			<th><?php $plxPlugin->lang('L_GROUPE') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php for($i=1; $i<=$nbchamp; $i++) : ?>
		<tr class="line-<?php echo $i%2 ?>">
			<td>
				<?php echo $i; ?>
			</td>
			<td>
				<input type="text" name="label<?php echo $i; ?>" value="<?php echo plxUtils::strCheck($plxPlugin->getParam(label.$i)) ?>" />
			</td>
			<td>
				<input type="text" name="champ<?php echo $i; ?>" value="<?php echo plxUtils::strCheck($plxPlugin->getParam(champ.$i)) ?>" />
			</td>
			<td>
				<label for="ligne<?php echo $i; ?>"><?php $plxPlugin->lang('L_LIGNE') ?></label><input type="radio" name="type<?php echo $i; ?>" value="ligne" id="ligne<?php echo $i; ?>" <?php if($plxPlugin->getParam(type.$i)=='ligne'){echo "checked";}?>>
				<label for="bloc<?php echo $i; ?>"><?php $plxPlugin->lang('L_BLOC') ?></label><input type="radio" name="type<?php echo $i; ?>" value="bloc" id="bloc<?php echo $i; ?>" <?php if($plxPlugin->getParam(type.$i)=='bloc'){echo "checked";}?>>
			</td>
			<td>
				<input type="text" name="groupe<?php echo $i; ?>" value="<?php echo plxUtils::strCheck($plxPlugin->getParam(groupe.$i)) ?>" />
			</td>
		</tr>
		<?php endfor; ?>

		<tr class="new">
			<td>
				<?php $plxPlugin->lang('L_NEW') ?>
			</td>
			<td>
				<input type="text" name="label-new" value="" />
			</td>
			<td>
				<input type="text" name="champ-new" value="" />
			</td>
			<td>
				<label for="ligne-new"><?php $plxPlugin->lang('L_LIGNE') ?></label><input type="radio" name="type-new" value="ligne" id="ligne-new" checked>
				<label for="bloc-new"><?php $plxPlugin->lang('L_BLOC') ?></label><input type="radio" name="type-new" value="bloc" id="bloc-new">
			</td>
			<td>
				<input type="text" name="groupe-new" value="" />
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
<?php echo plxToken::getTokenPostMethod() ?>
<p class="center">
<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
</p>
</form>

</div>