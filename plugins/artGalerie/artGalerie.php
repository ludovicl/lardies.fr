<?php
/**
 * Plugin artGalerie
 *
 * @package	PLX
 * @version	3.3
 * @date	12/08/2013
 * @author	Rockyhorror
 **/
class artGalerie extends plxPlugin {

	public $ActiveGalerie = '';	# Galerie en cours d'edition
	public $aGalerieDesc = array();	# Tableau des fichiers avec leurs description
	private $aGalerie = array(); # Tableau du contenu du fichier XML
	public $aGalParametres = array(); # parametres de la galerie active
	private $path = null; # chemin vers les médias
	private $thumbMotif = '/.tb.(jpg|gif|png|bmp|jpeg)$/i';
	
	/**
	 * Constructeur de la classe artGalerie
	 *
	 * @param	default_lang	langue par défaut utilisée par PluXml
	 * @return	null
	 * @author	Rockyhorror
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# Autorisation d'acces à la configuration du plugins
		$this-> setConfigProfil(PROFIL_ADMIN, PROFIL_MANAGER);

		# Autorisation d'accès à l'administration du plugin
		$this->setAdminProfil(PROFIL_ADMIN, PROFIL_MANAGER);
		
		# Déclarations des hooks
		$this->addHook('ArtgalerieDisplay','ArtgalerieDisplay');
		$this->addHook('ThemeEndHead', 'ThemeEndHead');
		$this->addHook('AdminArticleSidebar', 'AdminArticleSidebar');
		$this->addHook('plxAdminEditArticleXml', 'plxAdminEditArticleXml');
		$this->addHook('plxMotorParseArticle', 'plxMotorParseArticle');
		$this->addHook('staticGalerieShow', 'staticGalerieShow');
		$this->addHook('plxToolbarCustomsButtons', 'artGalerieButton');
		$this->addHook('AdminArticlePreview', 'AdminArticlePreview');
		$this->addHook('AdminArticlePostData', 'AdminArticlePostData');
		$this->addHook('AdminArticleParseData', 'AdminArticleParseData');
		$this->addHook('AdminArticleInitData', 'AdminArticleInitData');
		$this->addHook('plxShowStaticContent', 'plxShowStaticContent');
		$this->addHook('AdminStatic', 'AdminStatic');
		$this->addHook('plxAdminEditStatiquesXml', 'plxAdminEditStatiquesXml');
		$this->addHook('plxAdminEditStatique', 'plxAdminEditStatique');
		$this->addHook('plxMotorGetStatiques', 'plxMotorGetStatiques');
	}

	public function OnActivate() {
		$plxMotor = plxMotor::getInstance();
		if (version_compare($plxMotor->version, "5.1.7", ">=")) {
			if (!file_exists(PLX_ROOT."data/configuration/plugins/artGalerie.xml")) {
				if (!copy(PLX_PLUGINS."artGalerie/parameters.xml", PLX_ROOT."data/configuration/plugins/artGalerie.xml")) {
					return plxMsg::Error(L_SAVE_ERR.' '.PLX_PLUGINS."Blogroll/parameters.xml");
				}
			}
		}
	}

	public function AdminArticlePostData () {
		echo '<?php $galerie = $_POST["galerie"]; ?>';
	}
	
	public function AdminArticleParseData () {
		echo '<?php $galerie = $result["galerie"]; ?>';
	}
	
	public function AdminArticleInitData () {
		echo '<?php $galerie = ""; ?>';
	}

	public function AdminArticlePreview () {
		echo '<?php if(!empty($_POST["galerie"])) { $art["galerie"] = $_POST["galerie"]; } ?>';
	}

	/**
	 * Méthode qui ajoute le champs 'Galerie' dans l'edition de l'article
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function AdminArticleSidebar(){
			echo '<p><label for="id_galerie">'.$this->getlang('L_PATH').'&nbsp;:</label>&nbsp;';
			echo '<a class="help" title="'.$this->getlang('L_ARTICLE_GALERIE_FIELD_TITLE').'">&nbsp;</a></p>';
			echo '<?php $plxAdmin->plxPlugins->aPlugins["artGalerie"]->ActiveGalerie = $galerie; ?>';
			echo '<?php echo $plxAdmin->plxPlugins->aPlugins["artGalerie"]->contentFolder(); ?>';
        }

	public function plxAdminEditArticleXml(){
		echo "<?php \$xml .= '\t'.'<galerie><![CDATA['.plxUtils::cdataCheck(trim(\$content['galerie'])).']]></galerie>'.'\n'; ?>";
	}

	public function plxMotorParseArticle(){
		echo "<?php    \$art['galerie'] = (isset(\$iTags['galerie']))?trim(\$values[ \$iTags['galerie'][0] ]['value']):''; ?>";
	}

	/**
	 * Méthode qui ajoute l'insertion du code javascript dans la partie <head> du site
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/	
	public function ThemeEndHead() {
		$theme = $this->getParam('theme');
		echo "\t".'<link rel="stylesheet" href="'.PLX_PLUGINS.'artGalerie/themes/default/artGalerie.css" type="text/css" media="screen" />'."\n";
		include(PLX_PLUGINS.'artGalerie/themes/'.$theme.'/head.php');
	}


	/**
	 * Méthode qui ajoute le champ 'galerie' dans la page d'édition de la page statique
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function AdminStatic() {
		echo '
			<?php
				$galerie = plxUtils::getValue($plxAdmin->aStats[$id]["galerie"]);
				$plxAdmin->plxPlugins->aPlugins["artGalerie"]->ActiveGalerie = $galerie;		
			?>
			<fieldset>
				<p><label for="id_galerie">'.$this->getlang('L_PATH').'&nbsp;:</label>&nbsp
				<a class="help" title="'.$this->getlang('L_ARTICLE_GALERIE_FIELD_TITLE').'">&nbsp;</a></p>
				<?php echo $plxAdmin->plxPlugins->aPlugins["artGalerie"]->contentFolder(); ?>
			</fieldset>
		';
	}


	/**
	 * Méthode qui rajoute le mot de passe dans la chaine xml à sauvegarder dans statiques.xml
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
    public function plxAdminEditStatiquesXml() {
		echo "<?php \$xml .= '<galerie><![CDATA['.plxUtils::cdataCheck(trim(\$static['galerie'])).']]></galerie>'; ?>";
    }
    
    /**
	 * Méthode qui récupère la galerie saisit lors de l'édition de la page statique
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
    public function plxAdminEditStatique() {
		echo "<?php \$this->aStats[\$content['id']]['galerie'] = (!empty(\$content['galerie']) ? \$content['galerie'] : ''); ?>";
    }
    
    
    /**
	 * Méthode qui récupère la galerie stockée dans le fichier xml statiques.xml
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
    public function plxMotorGetStatiques() {
		echo "<?php \$galerie = plxUtils::getValue(\$iTags['galerie'][\$i]); ?>";
		echo "<?php \$this->aStats[\$number]['galerie']=plxUtils::getValue(\$values[\$galerie]['value']); ?>";
	}
	
	/**
	 * Méthode qui parse le fichier XML de description des images de la galerie
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	private function parseXML($dir, $galerie) {
		$filename = $dir."/".$galerie.".xml";
		
		if (!file_exists($filename)) { return; }
		
		# Mise en place du parseur XML
		$data = implode('',file($filename));
		$parser = xml_parser_create(PLX_CHARSET);
		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,0);
		xml_parse_into_struct($parser,$data,$values,$iTags);
		xml_parser_free($parser);
		
		if(isset($iTags['parametre'])){
			$nb = sizeof($iTags['parametre']);
			for($i = 0; $i < $nb; $i++) {
				$this->aGalParametres[ $values[$iTags['parametre'][$i]]['attributes']['name'] ] = $values[ $iTags['parametre'][$i] ]['value'];
			}
		}
		
		if(isset($iTags['image']) && isset($iTags['name'])) {
			$nb = sizeof($iTags['name']);
			for($i=0;$i<$nb;$i++) {
				$img = plxUtils::getValue($iTags['name'][$i]);
				$desc = plxUtils::getValue($iTags['description'][$i]);
				$this->aGalerie[$values[$img]['value']] = $values[$desc]['value'];
			}
		}
	}

	
	private function _getAllDirs($dir, $level=0) {

		# Initialisation
		$folders = array();

		# Ouverture et lecture du dossier demandé
		if($handle = opendir($dir)) {
			while (FALSE !== ($folder = readdir($handle))) {
				if($folder[0] != '.') {
					if(is_dir(($dir!=''?$dir.'/':$dir).$folder)) {
						$dir = (substr($dir, -1)!='/' AND $dir!='') ? $dir.'/' : $dir;
						$path = str_replace($this->path, '',$dir.$folder);
						$folders[] = array(
								'level' => $level,
								'name' => $folder,
								'path' => $path
							);

						$folders = array_merge($folders, $this->_getAllDirs($dir.$folder, $level+1) );
					}
				}
            }
			closedir($handle);
        }
		# On retourne le tableau
		return $folders;
	}
	
	public function contentFolder() {
		$plxMotor = plxMotor::getInstance();
		
		$this->path = PLX_ROOT.$plxMotor->aConf['images'].$this->getParam('root_dir').'/';
		$this->aDirs = (is_dir($this->path)?$this->_getAllDirs($this->path):"");
		$str  = "\n".'<select class="folder" id="id_galerie" size="1" name="galerie">'."\n";
		$selected = (empty($this->ActiveGalerie)?'selected="selected" ':'');
		$str .= '<option '.$selected.'value="">|. ('.L_PLXMEDIAS_ROOT.') &nbsp; </option>'."\n";
		# Dir non vide
		if(!empty($this->aDirs)) {
			foreach($this->aDirs as $k => $v) {
				$prefixe = '|&nbsp;&nbsp;';
				$i = 0;
				while($i < $v['level']) {
					$prefixe .= '&nbsp;&nbsp;';
					$i++;
				}
				$selected = ($v['path']==$this->ActiveGalerie?'selected="selected" ':'');
				$str .= '<option '.$selected.'value="'.$v['path'].'">'.$prefixe.$v['name'].'</option>'."\n";
			}
		}
		$str  .= '</select>'."\n";

		# On retourne la chaine
		return $str;
	}
	
	/**
	 * Méthode qui parse le contenue d'une galerie
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function parseGalerie($galerie){
		
		if(empty($galerie)) { return; }
		
		$galeriePath = $this->sanitize_path($galerie);
		$glob = plxGlob::getInstance($galeriePath);
		$galName = substr($galerie, strrpos($galerie,'/'));
		$this->parseXML($galeriePath, $galName);
		if ($files = $glob->query($this->thumbMotif, '', 'sort')) {
			$num = 0;
				foreach($files as $file){
					$this->aGalerieDesc[$num]['img'] = $galeriePath.'/'.$file;
					$this->aGalerieDesc[$num]['titre'] = str_replace('.tb', '', $file);
					$this->aGalerieDesc[$num]['tb'] = $file;
					$this->aGalerieDesc[$num]['desc'] = (isset($this->aGalerie[$file])?plxUtils::strRevCheck($this->aGalerie[$file]):"");
					$num++;
				}
		}	
	}
	
	/**
	 * Méthode qui ecrit le fichier XML de description des galeries
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function editGaleries($content){
		
		if(!empty($content['imgNum'])){
			# On génére le fichier XML
			$xml = "<?xml version=\"1.0\" encoding=\"".PLX_CHARSET."\"?>\n";
			$xml .= "<document>\n";
			$xml .= isset($content['description'])? "<parametre name=\"description\">1</parametre>\n":"<parametre name=\"description\">0</parametre>\n";
			$xml .= isset($content['thumbdesc'])? "<parametre name=\"thumbdesc\">1</parametre>\n":"<parametre name=\"thumbdesc\">0</parametre>\n";			
			foreach($content['imgNum'] as $v) {
				if (!empty($content[$v.'_desc'])){
					$xml .= "\t<image>";
					$xml .= "<name><![CDATA[".plxUtils::cdataCheck($content[$v.'_tb'])."]]></name>";
					$xml .= "<description><![CDATA[".plxUtils::strCheck(trim($content[$v.'_desc']))."]]></description>";
					$xml .= "</image>\n";
				}
			}
			$xml .= "</document>";
			
			# On écrit le fichier
			$galName = substr($content['galerie'], strrpos($content['galerie'],'/'));
			$filename = $this->sanitize_path($content['galerie']).'/'.$galName.'.xml';
			if(plxUtils::write($xml, $filename))
				return plxMsg::Info(L_SAVE_SUCCESSFUL);
			else {
				return plxMsg::Error(L_SAVE_ERR.' '.$filename);
			}
			
		}
	}
	
	/*
	 * Méthode qui affiche la galerie
	 * 
	 * @return	stdio
	 * @author	Rockyhorror
	 * 
	 */
	private function galerieDisplay($galerie_path) {
		$glob = plxGlob::getInstance($galerie_path);
		
		if ($files = $glob->query($this->thumbMotif, '', 'sort')) {
			$galerie = array();
			$randstr = mt_rand(1000, 9999);
			$galName = substr($galerie_path, strrpos($galerie_path,'/'));
			$this->parseXML($galerie_path, $galName); 
			$showDesc = isset($this->aGalParametres['description'])?$this->aGalParametres['description']: 0;
			$showThumbDesc = isset($this->aGalParametres['thumbdesc'])?$this->aGalParametres['thumbdesc']: 0;
			foreach($files as $idx => $filename) {
				$basename = str_replace('.tb', '', $filename);
				$galerie[$idx]['thumb'] = $galerie_path.'/'.$filename;
				$galerie[$idx]['file'] = $galerie_path.'/'.$basename;
				$galerie[$idx]['alt'] = substr($basename, 0,strrpos($basename,'.'));
				$galerie[$idx]['title'] = ($showDesc and isset($this->aGalerie[$filename])) ? $this->aGalerie[$filename] :$galerie[$idx]['alt'];
			}
			$theme = $this->getParam('theme');
			include(PLX_PLUGINS.'artGalerie/themes/'.$theme.'/galerie.php');
		}
	}
	
	public function scansubdir($dir, $tri='natural') {
		$aDirs = array();
		
		if(is_dir($dir)) {
			# On ouvre le repertoire
			if($dh = opendir($dir)) {
				# Pour chaque entree du repertoire
				while(false !== ($file = readdir($dh))) {
					if($file[0]!='.') {
						if(is_dir($dir.'/'.$file)) {
							if ($tri == 'mtime' or $tri == 'mtime_r'){
								$aDirs[filectime($dir.'/'.$file)] = $file;
							}
							else {
								$aDirs[] = $file;
							}
						}
					}
				}
				# On ferme la ressource sur le repertoire
				closedir($dh);
			}
			switch($tri) {
				case 'natural':
					natsort($aDirs);
					break;
				case 'mtime':
					ksort($aDirs);
					break;
				case 'mtime_r':
					krsort($aDirs);
					break;
			}
		}
		return $aDirs;
	}
	
	private function s_glob($dir, $regx){
		$files = array();
		if(is_dir($dir)){
			if($dh=opendir($dir)){
				while(($file = readdir($dh)) !== false){
					if (preg_match($regx, $file)) {
						$files[]=$dir.$file;
					}
				}
			}
		}
		return $files;
	}
	
	/*
	 * Methode pour nettoyer un chemin des '/./' '/../' '//'
	 * 
	 * @input string	chemin relatif à nettoyer
	 * @return string	chemin absolue propre
	 * @author Rockyhorror
	 * 
	 */ 
	private function sanitize_path($path) {
		$plxMotor = plxMotor::getInstance();
		
		$parts = explode('/', $path);
		foreach($parts as $idx => $part) {
			if($part == '.' | $part == '..' | empty($part)) { unset($parts[$idx]); }
		}
		$safePath = PLX_ROOT.$plxMotor->aConf['images'].$this->getParam('root_dir').'/'.implode('/', $parts);
		return $safePath;
	}
	
	/*
	 * Méthode qui affiche la galerie d'une statique
	 * 
	 * @return stdio
	 * @author Rockyhorror
	 * 
	 */ 
	public function plxShowStaticContent() {
		echo '<?php 
			$galerie = $this->plxMotor->aStats[ $this->plxMotor->cible ][\'galerie\'];
			$plxPlugin = $this->plxMotor->plxPlugins->getInstance(\'artGalerie\');
			ob_start();
			$plxPlugin->ArtgalerieDisplay($galerie);
			$galcontent = ob_get_clean();
			$output .= $galcontent;
		?>';
	}
	
	/**
	 * Méthode qui affiche la galerie dans un article ou une page statique
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function ArtgalerieDisplay($static_path) {
		$plxShow = plxShow::getInstance();
		
		if ($plxShow->mode() == 'article'){
			$plxMotor = plxMotor::getInstance();
			$galerie_path = $plxMotor->plxRecord_arts->f('galerie');
		}
		elseif($plxShow->mode() == 'static' OR $plxShow->mode() == 'home') {
			$galerie_path = (!empty($static_path))?$static_path :'';
		}
		else {
			$galerie_path = '';
		}
		
		if(empty($galerie_path)){
			return;
		}
		
		$root_dir = $this->sanitize_path($galerie_path);
		if(!is_dir($root_dir)) {
			return;
		}
		$this->galerieDisplay($root_dir);
	}
	
	/**
	 * Méthode qui liste les galeries et les affiches sous forme d'icone
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/
	public function staticGalerieShow($static_path) {
		$plxMotor = plxMotor::getInstance();
		$plxShow = plxShow::getInstance();
		
		if($plxShow->mode() != 'static' or empty($static_path)) {
			return;
		}
		
		$path = (isset($_GET['galerie']) && !empty($_GET['galerie'])) ? $_GET['galerie'] : $static_path;
		$root_dir = $this->sanitize_path($path);
		if(!is_dir($root_dir)) {
			return;
		}
		$dirs = $this->scansubdir($root_dir, $this->getParam('sortorder'));
		if (count($dirs) > 0) {
			$showThumb = $this->getParam('show_thumb');
			echo '<div class="gallery-thumbnails">';
			foreach ($dirs as $dir){
				$url = $plxMotor->urlRewrite('?static'.intval($plxMotor->cible).'/'.$plxMotor->aStats[$plxMotor->cible]['url'].'&galerie='.$path.'/'.$dir);
				if ($showThumb) {
					$imgFiles = $this->s_glob($root_dir.'/'.$dir.'/', $this->thumbMotif);
					$icon = (empty($imgFiles)?PLX_PLUGINS.'artGalerie/gallery-icon.png':$imgFiles[array_rand($imgFiles)]);
				}
				else {
					$icon = PLX_PLUGINS.'artGalerie/gallery-icon.png';
				}
				
				echo <<<END
						<div class="gallery-thumbnail">
							<div class="gallery-thumbnail-img">
								<?php echo '<a href="$url"><img src="$icon" alt="gallery-icon" /></a>'; ?>
							</div>
							<div class="gallery-thumbnail-desc">$dir</div>
						</div>
END;
			}
			echo '<div style="clear:left;"></div>';
			echo '</div>';
			
		}
		else {
			$this->galerieDisplay($root_dir);
		}
	}

	public function artGalerieButton() { ?>
		<script type="text/javascript">
			<!--
			plxToolbar.addButton( {
				icon : '<?php echo PLX_PLUGINS ?>artGalerie/lightbox.png',
				title : 'artGalerie',
				onclick : function(textarea) { 
					plxToolbar.openPopup('<?php echo PLX_PLUGINS ?>artGalerie/medias.php?id='+textarea, 'Medias', '750', '580');
					return '';
					}
			});
			-->
		</script>
		<?php
	}

}
?>
