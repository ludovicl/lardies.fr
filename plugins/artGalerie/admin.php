<?php if(!defined('PLX_ROOT')) exit; 

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST) && isset($_POST['update'])) {
	$plxPlugin->editGaleries($_POST);
	header('Location: plugin.php?p=artGalerie&galerie='.$_POST['galerie']);
	exit;
}

if(!empty($_POST) && isset($_POST['Select'])) {
	$plxPlugin->ActiveGalerie = $_POST['galerie'];
}

if(empty($plxPlugin->ActiveGalerie)){
	$plxPlugin->ActiveGalerie = (isset($_GET['galerie'])) ? $_GET['galerie'] : '';
}
$plxPlugin->parseGalerie($plxPlugin->ActiveGalerie);
?>

<h2><?php $plxPlugin->lang('L_TITLE'); ?></h2>

<form action="plugin.php?p=artGalerie" method="post" id="form_artgalerie">
	<p>
		<?php echo $plxPlugin->contentFolder() ?>&nbsp;
		<input class="button submit" type="submit" name="Select" value="<?php echo L_OK ?>" />
	</p>
	
	<?php
		if(!empty($plxPlugin->ActiveGalerie)) {
			echo "<p>" .$plxPlugin->getLang('L_ADMIN_SHOWDESC');
			echo '<input type="checkbox" name="description" value="1"';
			if((isset($plxPlugin->aGalParametres['description'])?$plxPlugin->aGalParametres['description']:0)) { echo 'checked="true"'; } 
			echo '/></p>';
			echo "<p>" .$plxPlugin->getLang('L_ADMIN_THUMBDESC');
			echo '<input type="checkbox" name="thumbdesc" value="1"';
			if((isset($plxPlugin->aGalParametres['thumbdesc'])?$plxPlugin->aGalParametres['thumbdesc']:0)) { echo 'checked="true"'; } 
			echo '/></p>';
		}
	?>
	<table class="table">
	<thead>
		<tr>
			<th><?php $plxPlugin->lang('L_ADMIN_IMG') ?></th>
			<th><?php $plxPlugin->lang('L_ADMIN_TITLE') ?></th>
			<th><?php $plxPlugin->lang('L_ADMIN_DESC') ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		<?php
		if ($plxPlugin->aGalerieDesc) {
			$num = 0;
			foreach($plxPlugin->aGalerieDesc as $k=>$v){
				echo '<tr class="line-'.($num%2).'">';
				echo '<td><input type="hidden" name="imgNum[]" value="'.$k.'" /><img src="'.$v['img'].'" /></td>';
				echo '<td>'.$v['titre'].'</td><td>';
				plxUtils::printInput($k.'_desc', plxUtils::strCheck($v['desc']), 'text', '50-150');
				echo '</td><td><input type="hidden" name="'.$k.'_tb" value="'.$v['tb'].'" /></td></tr>'."\n";
				$num++;
			}
		}
		else {
			echo '<tr><td>'.$plxPlugin->getlang('L_ADMIN_SELECT').'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
		}
		
		?>
	</tbody>
	</table>
	
	<p class="center">
	<?php echo plxToken::getTokenPostMethod() ?>
		<input class="button update " type="submit" name="update" value="<?php $plxPlugin->lang('L_ADMIN_APPLY_BUTTON'); ?>" />
	</p>
</form>

