<?php
/**
 * Plugin spxlightbox
 *
 * @package SPX
 * @version	
 * @date	07/09/2013
 * @author	EVRARD J
 **/
class spxlightbox extends plxPlugin {
	
	public static $options =array();
	/**
	 * Constructeur de la classe tynimce
	 *
	 * @param	default_lang	langue par défaut utilisée par PluXml
	 * @return	null
	 * @author	
	 **/
	public function __construct($default_lang) {
		
		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		
		# droits pour accéder à la page config.php du plugin
		$this->initconfiguration();
		$this->setConfigProfil(PROFIL_ADMIN);
		$this->spxname="spxlightbox";
		
		$this->sselector="swipebox";
		
		self::$options['settings']=array();
		self::$options['settings']['image_solo']=$this->getParam('image_solo');
		self::$options['settings']['videos']=$this->getParam('videos');
		self::$options['settings']['image_links']=$this->getParam('image_links');
		
		
		//self::$options['settings']['selector']=$this->sselector;
		//self::$options['settings']['selector']='spxlightbox';
		# Déclarations des hooks
		
		# si affichage des articles coté visiteurs: protection des emails contre le spam
		if(!defined('PLX_ADMIN')) {
			if ($this->getParam('article')=='1'){
				$this->addHook('plxMotorParseArticle', 'addplugclassArticle');
			}
			if ($this->getParam('static')=='1'){
				$this->addHook('plxShowStaticContent', 'addplugclassStatic');
			}
			
			$this->addHook('ThemeEndHead', 'addCssLibrairy');
			$this->addHook('ThemeEndBody', 'addJSlibrairy');
		}
		
		
	}
	
	
	
	public function initconfiguration() {
		
		
		# VARIOUS PARAMS
	
		$this->aoptions['images_as_gallery']=true;
	
		
		if (plxUtils::strCheck($this->getParam('article'))=="") $this->setParam('article', '1', 'string');
		if (plxUtils::strCheck($this->getParam('static'))=="") $this->setParam('static', '1', 'string');
		if (plxUtils::strCheck($this->getParam('extra_small_device'))=="") $this->setParam('extra_small_device', 'swipebox', 'string');
		if (plxUtils::strCheck($this->getParam('small_device'))=="") $this->setParam('small_device', 'swipebox', 'string');
		if (plxUtils::strCheck($this->getParam('medium_device'))=="") $this->setParam('medium_device', 'zoombox', 'string');
		if (plxUtils::strCheck($this->getParam('large_device'))=="") $this->setParam('large_device', 'zoombox', 'string');
		if (plxUtils::strCheck($this->getParam('videos'))=="") $this->setParam('videos', '1', 'string');
		if (plxUtils::strCheck($this->getParam('image_links'))=="") $this->setParam('image_links', '1', 'string');
		if (plxUtils::strCheck($this->getParam('image_solo'))=="") $this->setParam('image_solo', '1', 'string');
		if (plxUtils::strCheck($this->getParam('image_tb'))=="") $this->setParam('image_tb', '0', 'string');
		
		# PRETTYPHOTO PARAMS
		if (plxUtils::strCheck($this->getParam('pp_animation_speed'))=="") $this->setParam('pp_animation_speed', 'normal', 'string');
		if (plxUtils::strCheck($this->getParam('pp_slideshow'))=="") $this->setParam('pp_slideshow', '0', 'string');
		if (plxUtils::strCheck($this->getParam('pp_slideshow_delay'))=="") $this->setParam('pp_slideshow_delay', 5000, 'numeric');
		if (plxUtils::strCheck($this->getParam('pp_slideshow_autoplay'))=="") $this->setParam('pp_slideshow_autoplay', '0', 'string');
		if (plxUtils::strCheck($this->getParam('pp_show_title'))=="") $this->setParam('pp_show_title', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('pp_allow_resize'))=="") $this->setParam('pp_allow_resize', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('pp_hide_flash'))=="") $this->setParam('pp_hide_flash', 'false', 'string');
		if (plxUtils::strCheck($this->getParam('pp_wmode'))=="") $this->setParam('pp_wmode', 'opaque', 'string');
		if (plxUtils::strCheck($this->getParam('pp_video_autoplay'))=="") $this->setParam('pp_video_autoplay', 'false', 'string');
		if (plxUtils::strCheck($this->getParam('pp_modal'))=="") $this->setParam('pp_modal', 'false', 'string');
		if (plxUtils::strCheck($this->getParam('pp_deeplinking'))=="") $this->setParam('pp_deeplinking', 'false', 'string');
		if (plxUtils::strCheck($this->getParam('pp_overlay_gallery'))=="") $this->setParam('pp_overlay_gallery', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('pp_keyboard_shortcuts'))=="") $this->setParam('pp_keyboard_shortcuts', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('pp_social'))=="") $this->setParam('pp_social', '0', 'string');
		if (plxUtils::strCheck($this->getParam('pp_theme'))=="") $this->setParam('pp_theme', 'pp_default', 'string');
		if (plxUtils::strCheck($this->getParam('pp_separator'))=="") $this->setParam('pp_separator', '/', 'string');
		
		if (plxUtils::strCheck($this->getParam('pp_opacity'))=="") $this->setParam('pp_opacity', '0.8', 'string');
		if (plxUtils::strCheck($this->getParam('pp_width'))=="") $this->setParam('pp_width', '1080', 'numeric');
		if (plxUtils::strCheck($this->getParam('pp_height'))=="") $this->setParam('pp_height', '720', 'numeric');
		if (plxUtils::strCheck($this->getParam('pp_horizontal_padding'))=="") $this->setParam('pp_horizontal_padding', '20', 'numeric');
		
		
		# SWIPEBOX PARAMS
		if (plxUtils::strCheck($this->getParam('sb_useCSS'))=="") $this->setParam('sb_useCSS', 'true', 'string');
		
		if (plxUtils::strCheck($this->getParam('sb_hide_bars_delay'))=="") $this->setParam('sb_hide_bars_delay', '5000', 'numeric');
		if (plxUtils::strCheck($this->getParam('sb_video_max_width'))=="") $this->setParam('sb_video_max_width', '1140', 'numeric');
		if (plxUtils::strCheck($this->getParam('sb_vimeoColor'))=="") $this->setParam('sb_vimeoColor', 'CCCCCC', 'string');
		
        
		
		# ZOOMBOX
		if (plxUtils::strCheck($this->getParam('zb_theme'))=="") $this->setParam('zb_theme', 'zoombox', 'string');
		if (plxUtils::strCheck($this->getParam('zb_opacity'))=="") $this->setParam('zb_opacity', '0.8', 'string');
		if (plxUtils::strCheck($this->getParam('zb_duration'))=="") $this->setParam('zb_duration', '800', 'string');
		if (plxUtils::strCheck($this->getParam('zb_animation'))=="") $this->setParam('zb_animation', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('zb_width'))=="") $this->setParam('zb_width', '1000', 'string');
		if (plxUtils::strCheck($this->getParam('zb_height'))=="") $this->setParam('zb_height', '800', 'string');
		if (plxUtils::strCheck($this->getParam('zb_gallery'))=="") $this->setParam('zb_gallery', 'true', 'string');
		if (plxUtils::strCheck($this->getParam('zb_autoplay'))=="") $this->setParam('zb_autoplay', 'false', 'string');
	}
	

		/**
	 * Méthode qui ajoute lightbox dans les articles
	 *
	 * @return	$output
	 * @author	Evrard J
	 **/
	public function addplugclassArticle() {
		echo '<?php
			$art["chapo"] = spxlightbox::addplugclass($art["chapo"]);
			$art["content"] = spxlightbox::addplugclass($art["content"]);
		?>';

	
	}
	
	/**
	 * Méthode qui lightbox dans les pages statiques
	 *
	 * @return	$output
	 * @author	Evrard J
	 **/
	public function addplugclassStatic() {

		echo '<?php
			$output = spxlightbox::addplugclass($output);
		?>';

	}
	
	
	/**
	 * Méthode qui ajoute le plugin
	 *
	 * @parm	txt		chaine de caractères à checker
	 * @return	string	chaine de caractères modifiée
	 * @author	Evrard J
	 **/
	

	public static function addplugclass($txt) {
		
		$txt = self::add_protectforAIMG($txt);
		
		if (self::$options['settings']['videos']=="1"){
			$txt = self::add_videos_lightbox_selector($txt);
		}
		if (self::$options['settings']['image_links']=="1"){
			$txt = self::add_links_lightbox_selector($txt);
		}
		if (self::$options['settings']['image_solo']=="1"){
			$txt = self::add_image_lightbox_selector($txt);
		}
		
		return $txt;
	}


	public static function add_protectforAIMG($content) {
		preg_match_all('/<a\s[^>]*href=\"([^\"]*)\"[^>]*>(.*)<\/a>/siU', $content, $links);
		if(isset($links[0])) {
			foreach($links[0] as $id => $txt){
				if(preg_match_all('/<img[^>]+>/i', $txt, $matches)){
					foreach($matches[0] as $k => $v) {
						$img = $v;
						if (!preg_match( '/data-spxlightboxp="([^"]*)"/i', $img, $dataprotected )){;
							if (isset($dataprotected[1])!="true"){
								$newsrcdata = '<img data-spxlightboxp="true"';
								$img2 = str_replace("<img", $newsrcdata , $img);
								$txt2 = str_replace($img, $img2 , $txt);
								$content = str_replace($txt, $txt2 , $content);
							}
						}
					}
				}
				
			}
		}

		return $content;
	}
	
	
	public static function add_image_lightbox_selector($txt) {
		if(preg_match_all('/<img[^>]+>/i', $txt, $matches)){
			$areplace = array();
			foreach($matches[0] as $k => $v) {
				$img = $v;
					if(!preg_match('/data-spxlightboxp="true"/i', $img, $dataspxtynimce)){
						if(preg_match( '/data-spxtynimce="([^"]*)"/i', $img, $dataspxtynimce )){ ;
							$link='';
							if ($dataspxtynimce[1]=="true"){
								preg_match( '/src="([^"]*)"/i', $img, $src ) ;
								$link = '<a href='.$src[1].' data-spxlighbox="true" >'.$img.'</a>';
								$areplace[$img]=$link;
							}
						}
					}
			}
			foreach($areplace as $img => $link) {
				$txt = str_replace($img, $link , $txt);
			}
		};
		return $txt;
	}
	// miniature !preg_match('/^(.*\.)tb.([^.]+)$/D', $file)
	public static function add_image_lightbox_selectorOLD($txt) {
		
		if(preg_match_all('/<img[^>]+>/i', $txt, $matches)){
			$areplace = array();
			foreach($matches[0] as $k => $v) {
				$img = $v;
					preg_match( '/data-spxtynimce="([^"]*)"/i', $img, $dataspxtynimce ) ;
					//preg_match( '/class="([^"]*)"/i', $img, $class ) ;
					preg_match( '/src="([^"]*)"/i', $img, $src ) ;
					//echo("data-spxtynimce=".$dataspxtynimce[1]);
					//print_r( $src[1] ) ;
					$link='';
					if ($dataspxtynimce[1]=="true"){
						$link = '<a href='.$src[1].' data-spxlighbox="true" >'.$img.'</a>';
						$areplace[$img]=$link;
						//$txt = str_replace($img, $link , $txt);
					}
			}
			foreach($areplace as $img => $link) {
				$txt = str_replace($img, $link , $txt);
			}
		};
		return $txt;
	}
	
	public static function add_videos_lightbox_selector($content) {
		preg_match_all('/<a(.*?)href=(?:\'|")(http:\/\/(?:www\.)?((youtube\.com\/watch\?v=[a-z0-9]{11})|(vimeo\.com\/[0-9]{8,})))(?:\'|")(.*?)>/i', $content, $links);

		if(isset($links[0]))
		{
			foreach($links[0] as $id => $link)
			{
				
					$content = str_replace($link, '<a'.$links[1][$id].'href="'.$links[2][$id].'"'.$links[6][$id].' data-spxlighbox="true" >', $content);
				
			}
		}

		return $content;
	}

	public static function add_links_lightbox_selector($content) {
		preg_match_all('/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png)(?:\'|")(.*?)>/i', $content, $links);

		if(isset($links[0])) {
			foreach($links[0] as $id => $link){
					$content = str_replace($link, '<a'.$links[1][$id].'href="'.$links[2][$id].'.'.$links[3][$id].'"'.$links[4][$id].' data-spxlighbox="true" >', $content);
				
			}
		}

		return $content;
	}

	
	/**
	 * Méthode qui ajoute le fichier css de Zoombox
	 *
	 * @return	stdio
	 * @author	Evrard jerome
	 **/
	public function addZoomboxCss() {
		echo "\t".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'spxlightbox/assets/zoombox/zoombox.css" />'."\n";
	}
	
	/**
	 * Méthode qui ajoute le fichier javascript de Zoombox
	 *
	 * @return	init zoombox
	 * @author	Evrard jerome
	 **/
	public function addZoombox() {
		return "\n".'
		
				// You can also use specific options
			
				//$(\'a.spxlightbox\').zoombox({
				$(\'a[data-spxlighbox="true"]\').zoombox({
					theme		: \''.$this->getParam('zb_theme').'\',	// available themes : zoombox, lightbox, prettyphoto, darkprettyphoto, simple
					opacity		: '.$this->getParam('zb_opacity').',	// Black overlay opacity
					duration	: '.$this->getParam('zb_duration').',	// Animation duration
					animation	: '.$this->getParam('zb_animation').',	// Do we have to animate the box ?
					width		: '.$this->getParam('zb_width').',		// Default width
					height		: '.$this->getParam('zb_height').',	// Default height
					gallery		: '.$this->getParam('zb_gallery').',	// Allow gallery thumb view
					autoplay	: '.$this->getParam('zb_autoplay').'	// Autoplay for video
				});
		   ';

	}
	
	/**
	 * Méthode qui ajoute le fichier css de Zoombox
	 *
	 * @return	stdio
	 * @author	Evrar J
	 **/
	
	public function addSwipeboxCss() {
		echo "\t".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'spxlightbox/assets/swipebox/source/swipebox.css" />'."\n";
	}
	/**
	 * Méthode qui initialise swipebox
	 *
	 * @return	
	 * @author	Evrard J
	 **/
	 
	public function addSwipebox() {
		return "\n".'
		
				$(\'a[data-spxlighbox="true"]\').swipebox({
					useCSS : '.$this->getParam('sb_useCSS').', // false will force the use of jQuery for animations
					hideBarsDelay : '.$this->getParam('sb_hide_bars_delay').', // 0 to always show caption and action bar
					videoMaxWidth : '.$this->getParam('sb_video_max_width').', // videos max width
					vimeoColor : "'.$this->getParam('sb_vimeoColor').'" // vimeo color
				});
		   ';
	}
	
	/**
	 * Méthode qui ajoute le fichier css de Zoombox
	 *
	 * @return	stdio
	 * @author	Evrard jerome
	 **/
	
	public function addPrettyPhotoCss() {
		echo "\t".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'spxlightbox/assets/prettyphoto/css/prettyPhoto.css" />'."\n";
	}
	
	/**
	 * Méthode qui initialise prettyphoto
	 *
	 * @return	
	 * @author	Evrard J
	 **/
	public function addPrettyPhoto() {
		if ($this->getParam('pp_slideshow')=="false"){
			$slideshow="false";
		}else{
			$slideshow=$this->getParam('pp_slideshow_delay');
		}
		return "\n".'
		
				$(\'a[data-spxlighbox="true"]\').prettyPhoto(
				
				{
					
					animation_speed: "'.$this->getParam('pp_animation_speed').'", /* fast/slow/normal */
					slideshow: '.$slideshow.', /* false OR interval time in ms */
					autoplay_slideshow: '.$this->getParam('pp_slideshow_autoplay').', /* true/false */
				
				opacity: '.$this->getParam('pp_opacity').', /* Value between 0 and 1 */
					show_title: '.$this->getParam('pp_show_title').', /* true/false */
					allow_resize: '.$this->getParam('pp_allow_resize').', /* Resize the photos bigger than viewport. true/false */
					default_width: '.$this->getParam('pp_width').',
					default_height: '.$this->getParam('pp_height').',
					counter_separator_label: "'.$this->getParam('pp_separator').'", /* The separator for the gallery counter 1 "of" 2 */
					theme: "'.$this->getParam('pp_theme').'", /* light_rounded / dark_rounded / light_square / dark_square / facebook */
					horizontal_padding: '.$this->getParam('pp_horizontal_padding').', /* The padding on each side of the picture */
					hideflash: '.$this->getParam('pp_hide_flash').', /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
					wmode: "'.$this->getParam('pp_wmode').'", /* Set the flash wmode attribute */
					autoplay: '.$this->getParam('pp_video_autoplay').', /* Automatically start videos: True/False */
				modal: '.$this->getParam('pp_modal').', /* If set to true, only the close button will close the window */
					deeplinking: '.$this->getParam('pp_deeplinking').', /* Allow prettyPhoto to update the url to enable deeplinking. */
					overlay_gallery: '.$this->getParam('pp_overlay_gallery').', /* If set to true, a gallery will overlay the fullscreen image on mouse over */
					keyboard_shortcuts: '.$this->getParam('pp_keyboard_shortcuts').', /* Set to false if you open forms inside prettyPhoto */
					ie6_fallback: true,
					social: '.$this->getParam('pp_social').'
				
				}
				);
		   ';
			
	}
	
	/**
	 * Méthode qui ajoute le fichier css 
	 *
	 * @return	stdio
	 * @author	Evrard jerome
	 **/
	
	public function addCssLibrairy() {
		$this->addSwipeboxCss();
		$this->addZoomboxCss();
		$this->addPrettyPhotoCss();
	}
	
	public function addJSlibrairy() {
		$this->addJSgetDevice();
		
		// Set
		//$('#element').attr('data-value', 'value');
		// Get
		//var value = $('#element').attr('data-value');
		// Select
		//var elem = $('#element[data-value = "' +value+ '"]');
		echo "\n".'
		<script type="text/javascript">
		/* <![CDATA[ */
		!window.jQuery && document.write(\'<script  type="text/javascript" src="'.PLX_PLUGINS.'spxlightbox/assets/swipebox/lib/jquery-2.0.3.min.js"><\/script>\');
		/* !]]> */
		</script>
		<script type="text/javascript" src="'.PLX_PLUGINS.'spxlightbox/assets/swipebox/source/jquery.swipebox.js"></script>
		<script type="text/javascript" src="'.PLX_PLUGINS.'spxlightbox/assets/zoombox/zoombox.js"></script>
		<script type="text/javascript" src="'.PLX_PLUGINS.'spxlightbox/assets/prettyphoto/js/jquery.prettyPhoto.js"></script>
		<script type="text/javascript">
		
			jQuery(function($){
				
				var apxlightbox_devices_lib = new Array();
				apxlightbox_devices_lib["large_devices"]="'.$this->getParam('large_device').'";
				apxlightbox_devices_lib["medium_devices"]="'.$this->getParam('medium_device').'";
				apxlightbox_devices_lib["small_devices"]="'.$this->getParam('small_device').'";
				apxlightbox_devices_lib["extra_small_devices"]="'.$this->getParam('extra_small_device').'";
				
				// You can also use specific options
				var ww = $(window).width();
				var sdeviceType = spxlightbox_getdevice(ww);
				//console.log("sdeviceType="+sdeviceType);
				var alib = apxlightbox_devices_lib[sdeviceType];
				switch(alib) { 
						case "zoombox": 
							'.$this->addZoombox().'
						break; 
						case "prettyphoto": 
							'.$this->addPrettyPhoto().'
						break; 
						default: 
							'.$this->addSwipebox().'
						break; 
						}
	
		    })
		</script>';
		
	}
	public function addJSgetDevice() {
		// pg._nwinWidth = $(window).width();
		// pg._sdeviceType=pg._getdevice(pg._nwinWidth);
		echo "\n".'
		<script type="text/javascript">
			function spxlightbox_getdevice(w){
				//console.log("getdevice"+w);
						if (w>=1200){
							var device="large_devices";
						} else if (w>=992) {
							var device="medium_devices";
						} else if (w>=768) {
							var device="small_devices";
						}else{
							var device="extra_small_devices";
						}
						return device;
			}
		</script>';
	
	}
	


}

?>