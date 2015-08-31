<?php
/**
 * Plugin ribbon
 *
 * @version	1.0
 * @date	12/10/2013
 * @author	Frédéric K.
 **/
class ribbon extends plxPlugin {

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	Frédéric KAPLON
	 **/
	public function __construct($default_lang) {

        # appel du constructeur de la classe plxPlugin (obligatoire)
        parent::__construct($default_lang);

		# droits pour accèder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);
		
		# déclaration des hooks
		$this->addHook('ThemeEndHead', 'ThemeEndHead');
		$this->addHook('ThemeEndBody', 'ThemeEndBody');
    }
	/**
	 * Méthode qui pré-enregistre les paramètres
	 *
	 * @return	stdio
	 * @author	Frédéric KAPLON
	 **/    
    public function OnActivate() {
        $this->setParam('type', 'ribbon',  'string');
        $this->setParam('title', 'Découvrez PluXml !',  'string');
        $this->setParam('url', 'http://pluxml.org',  'string');
        $this->setParam('display', 'right',  'string');
        $this->setParam('color', 'EB593C',  'string');
        $this->saveParams();
    }
    
	/**
	 * Méthode qui ajoute le code css dans la partie <head>
	 *
	 * @return	stdio
	 * @author	Frédéric KAPLON
	 **/
    public function ThemeEndHead() {?>
    
    <?php 
     if($this->getParam('type')=='ribbon') {
         echo '<style type="text/css" media="screen">
         .ribbon{ background-color: #'.$this->getParam('color').'; z-index:1000;padding: 3px;position:fixed; top:2.5em; '.$this->getParam('display').':-3em; -moz-transform:rotate(' .($this->getParam('display')=='left'? '-45':'45'). 'deg); -webkit-transform:rotate(' .($this->getParam('display')=='left'? '-45':'45'). 'deg); -moz-box-shadow:0 0 1em #888; -webkit-box-shadow:0 0 1em #888} 
          .ribbon a{ border:1px dotted rgba(255,255,255,1); color:#fff; display:block; font:bold 81.25% "Helvetiva Neue",Helvetica,Arial,sans-serif; margin:0.05em 0 0.075em 0; padding:0.5em 3.5em; text-align:center; text-decoration:none;text-shadow:0 0 0.5em #333}
          .ribbon a:hover{ opacity: 0.8}
         </style>';
     } 
     if($this->getParam('type')=='stickybar') {
        echo '<style type="text/css" media="screen">
        .stickybar{position:fixed;left:0;right:0;top:0;font-size:14px; font-weight:400; height:35px; line-height:35px; overflow:visible; text-align:center; width:100%; z-index:1000; border-bottom-width:3px; border-bottom-style:solid; font-family:Georgia,Times New Roman,Times,serif; color:#fff; border-bottom-color:#fff; margin:0; padding:0; background-color: #'.$this->getParam('color').';-webkit-border-bottom-right-radius:5px;-webkit-border-bottom-left-radius:5px;-moz-border-radius-bottomright:5px;-moz-border-radius-bottomleft:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;}
         body {margin-top:35px !important}
        .stickybar a, .stickybar a:link, .stickybar a:visited, .stickybar a:hover{color:#fff;font-size:14px; text-decoration:none; border:none;  padding:0}
        .stickybar a:hover{text-decoration:underline}
        .stickybar a{color:#fff; display:block;padding-bottom: 8px; text-align:center; text-decoration:none;text-shadow:0 0 0.1em #000}
        .stickybar a:hover{ opacity: 0.8}
        </style>';
     }
     ?>

	<?php
    }

	/**
	 * Méthode qui ajoute le rubban
	 *
	 * @return	stdio
	 * @author	Frédéric KAPLON
	 **/
    public function ThemeEndBody() {?>
   
     <div class="<?php echo $this->getParam('type') ?>">
           <a href="<?php echo $this->getParam('url') ?>"><?php echo $this->getParam('title') ?></a>
     </div>

	<?php
    }
    
}
?>