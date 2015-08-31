<?php
/**
 * Classe plxtoolbar
 *
 * @package PLX
 * @version 1.2
 * @date	01/07/2011
 * @author	Stephane F
 **/
class plxtoolbar extends plxPlugin {

	/**
	 * Constructeur de la classe
	 *
	 * @return	null
	 * @author	St�phane F.
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# Ajoute les hooks n�cessaires pour le fonctionnement de la plxToolbar
		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		$this->addHook('AdminFootEndBody', 'AdminFootEndBody');

		# Hook d�di� � la toolbar pour les customs buttons
		$this->addHook('plxToolbarCustomsButtons', 'getCustomsButtons');
	}
	
	/**
	 * M�thode qui r�cupere les boutons utilisateurs dans le dossier cutom.buttons
	 *
	 * @return	stdio
	 * @author	St�phane F.
	 **/
	public function getCustomsButtons() {
		$str='';
		# On regarde s'il y a des boutons personnels � ajouter dans la plxtoolbar
		if(is_dir(PLX_PLUGINS.'plxtoolbar/custom.buttons/')) {
			$buttons = plxGlob::getInstance(PLX_PLUGINS.'plxtoolbar/custom.buttons/');
			if($aFiles = $buttons->query('/button.(.*).php$/')) {
				foreach($aFiles as $button) {
					echo '<?php include(\''.PLX_PLUGINS.'plxtoolbar/custom.buttons/'.$button.'\'); ?>';
				}
			}
		}
	}

	/**
	 * M�thode qui ajoute les d�clarations dans la partie <head> de l'administration
	 *
	 * @return	stdio
	 * @author	St�phane F.
	 **/
	public function AdminTopEndHead() {
		echo "\n".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'plxtoolbar/plxtoolbar/style.css" media="screen" />';
		echo "\n\t".'<script type="text/javascript" src="'.PLX_PLUGINS.'plxtoolbar/plxtoolbar/plxtoolbar.js"></script>';
		$langfile = PLX_PLUGINS.'plxtoolbar/plxtoolbar/lang/'.$this->default_lang.'.js';
		if(is_file($langfile))
		echo "\n\t".'<script type="text/javascript" src="'.$langfile.'"></script>';
	}

	/**
	 * M�thode qui ajoute les d�clarations dans le footer de l'administration
	 *
	 * @return	stdio
	 * @author	St�phane F.
	 **/
	public function AdminFootEndBody() {
		echo '<?php eval($plxAdmin->plxPlugins->callHook(\'plxToolbarCustomsButtons\', \'addCustomButtons\')); ?>';
		echo "\n\t".'<script type="text/javascript">plxToolbar.init(\''.PLX_PLUGINS.'plxtoolbar/'.'\');</script>'."\n";
	}

}
?>