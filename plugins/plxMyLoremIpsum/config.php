<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST)) {

	# sauvegarde des paramètres
	$plxPlugin->setParam('nbart', $_POST['nbart'], 'numeric');
	$plxPlugin->setParam('nbcomsart', $_POST['nbcomsart'], 'numeric');
	$plxPlugin->saveParams();

	if(!empty($_POST['create'])) {

		# génération des articles
		include(dirname(__FILE__)).'/class.plx.loremipsum.php';
		include(dirname(__FILE__)).'/class.plx.generator.php';
		$loremipsum = new plxLoremIpsumGenerator();
		$loremipsum->nbart = $plxPlugin->getParam('nbart');
		$loremipsum->nbcomsart = $plxPlugin->getParam('nbcomsart');
		$loremipsum->generate();
	}

	# redirection sur la page de configuration du plugin
	header('Location: parametres_plugin.php?p=plxMyLoremIpsum');
	exit;
}

# initialisation des paramètres par défaut
$params = $plxPlugin->getParams();
$nbart = empty($params['nbart']) ? '20' : $params['nbart']['value'];
$nbcomsart = empty($params['nbcomsart']) ? '10' : $params['nbcomsart']['value'];

?>

<h2><?php echo $plxPlugin->getInfo('title') ?></h2>
<h3><?php echo $plxPlugin->getInfo('description') ?></h3>

<form action="parametres_plugin.php?p=plxMyLoremIpsum" method="post" id="form_loremipsum">
	<fieldset>
		<p class="field"><label for="id_nbart">Nombre d'articles &agrave; cr&eacute;er</label></p>
		<?php plxUtils::printInput('nbart', $nbart, 'text', '1-2'); ?>
		<p class="field"><label for="id_nbcomsart">Nombre maximum de commentaires cr&eacute;&eacute;s al&eacute;atoirement par article</label></p>
		<?php plxUtils::printInput('nbcomsart', $nbcomsart, 'text', '1-2'); ?>
		<p>
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="save" value="Sauvegarder" />
			&nbsp;
			<input type="submit" name="create" value="Cr&eacute;er articles" />
		</p>
	</fieldset>
</form>

