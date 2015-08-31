<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST)) {
    $plxPlugin->setParam('type', $_POST['type'], 'string');
	$plxPlugin->setParam('title', $_POST['title'], 'string');
	$plxPlugin->setParam('url', $_POST['url'], 'string');
	$plxPlugin->setParam('display', $_POST['display'], 'string');
	$plxPlugin->setParam('color', $_POST['color'], 'string');
	$plxPlugin->saveParams();
	header('Location: parametres_plugin.php?p=ribbon');
	exit;
}
    $type    = $plxPlugin->getParam('type')=='' ? '' : $plxPlugin->getParam('type');
    $title   = $plxPlugin->getParam('title')=='' ? '' : $plxPlugin->getParam('title');
    $url     = $plxPlugin->getParam('url')=='' ? '' : $plxPlugin->getParam('url');    
    $display = $plxPlugin->getParam('display')=='' ? '' : $plxPlugin->getParam('display');
    $color   = $plxPlugin->getParam('color')=='' ? '' : $plxPlugin->getParam('color');
?>
<br />
<script type="text/javascript" src="<?php echo PLX_PLUGINS ?>/ribbon/jscolor/jscolor.js"></script>
<form id="form_ribbon" action="parametres_plugin.php?p=ribbon" method="post">
	<fieldset>
		<p class="field"><label for="id_type"><?php $plxPlugin->lang('L_TYPE') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('type',array('ribbon'=>$plxPlugin->getLang('L_RIBBON'),'stickybar'=>$plxPlugin->getLang('L_STICKYBAR')),$type) ?>
		
		<p class="field"><label for="id_title"><?php $plxPlugin->lang('L_TITLE') ?>&nbsp;:</label></p>
		<?php plxUtils::printInput('title',$title,'text','50-120') ?>
				
		<p class="field"><label for="id_content"><?php $plxPlugin->lang('L_URL') ?>&nbsp;:</label></p>
		<?php plxUtils::printInput('url',$url,'text','50-120') ?>
		
		<p class="field"><label for="id_display"><?php $plxPlugin->lang('L_DISPLAY') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('display',array('left'=>$plxPlugin->getLang('L_LEFT'),'right'=>$plxPlugin->getLang('L_RIGHT')),$display) ?>
		
		<p class="field"><label for="id_color"><?php $plxPlugin->lang('L_COLOR') ?>&nbsp;:</label></p>
		<?php plxUtils::printInput('color',$color,'text','20-20',false,'color') ?>
		
		<p>
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
		</p>
	</fieldset>
</form>
