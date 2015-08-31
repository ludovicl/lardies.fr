<?php
/**
 * Plugin artGalerie
 *
 * @package     PLX
 * @version     3.3
 * @date        12/08/2013
 * @author      rockyhorror
 **/


if(!defined('PLX_ROOT')) exit;
# Control du token du formulaire
plxToken::validateFormToken($_POST);

	if(!empty($_POST)) {
		$plxPlugin->setParam('root_dir', $_POST['root_dir'], 'cdata');
		$plxPlugin->setParam('show_thumb', isset($_POST['show_thumb'])?1:0, 'numeric');
		$plxPlugin->setParam('theme', $_POST['theme'], 'cdata');
		$plxPlugin->setParam('sortorder', $_POST['sortorder'], 'cdata');
		$plxPlugin->saveParams();
		header('Location: parametres_plugin.php?p=artGalerie');
		exit;
	}

 ?>
 
	<h2><?php $plxPlugin->lang('L_TITLE') ?></h2>
	<p><?php $plxPlugin->lang('L_DESCRIPTION') ?></p>

	<form action="parametres_plugin.php?p=artGalerie" method="post">
	
	<fieldset class="withlabel">
		<p><?php echo $plxPlugin->getLang('L_CONFIG_ROOT_DIR') ?></p>
		<?php plxUtils::printInput('root_dir', $plxPlugin->getParam('root_dir'), 'text'); ?>
		
		<p><?php echo $plxPlugin->getLang('L_CONFIG_GAL_THEME') ?></p>
		<?php
			$themes_dir = $plxPlugin->scansubdir(PLX_PLUGINS.'artGalerie/themes');
			foreach($themes_dir as $theme_dir) {
				$theme_list[$theme_dir] = $theme_dir;
			}
			plxUtils::printSelect('theme', $theme_list, $selected=$plxPlugin->getParam('theme'));
		?>
		
		<p><?php echo $plxPlugin->getLang('L_CONFIG_SHOW_THUMB') ?>
		<input type="checkbox" name="show_thumb" value="True" <?php if($plxPlugin->getParam('show_thumb')) { echo 'checked="true"'; }?>/></p>
		
		<p><?php echo $plxPlugin->getLang('L_CONFIG_SORT_ORDER');
		$sortorder['natural'] = 'natural';
		$sortorder['mtime'] = 'mtime';
		$sortorder['mtime_r'] = 'mtime_r';
		plxUtils::printSelect('sortorder', $sortorder, $selected=$plxPlugin->getParam('sortorder')); ?>
		</p>
	</fieldset>
	<br />
	<?php echo plxToken::getTokenPostMethod() ?>
	<input type="submit" name="submit" value="<?php echo $plxPlugin->getLang('L_SAVE') ?>" />

	</form>
