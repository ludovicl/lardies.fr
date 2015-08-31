<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

$plxPlugin->initconfiguration();
$param = $plxPlugin->getParams();
//echo("<pre>");
//print_r($param);
//echo("</pre>");

if(!empty($_POST)) {
	
	
	/*
		'prettyphoto' => array(
				'animation_speed' => 'normal',
				'slideshow' => FALSE,
				'slideshow_delay' => 5000,
				'slideshow_autoplay' => FALSE,
				'opacity' => 0.75,
				'show_title' => TRUE,
				'allow_resize' => TRUE,
				'width' => 1080,
				'height' => 720,
				'separator' => '/',
				'theme' => 'pp_default',
				'horizontal_padding' => 20,
				'hide_flash' => FALSE,
				'wmode' => 'opaque',
				'video_autoplay' => FALSE,
				'modal' => FALSE,
				'deeplinking' => FALSE,
				'overlay_gallery' => TRUE,
				'keyboard_shortcuts' => TRUE,
				'social' => FALSE
			),
			'swipebox' => array(
				
				
				useCSS : true,
				hideBarsDelay : 3000,
				videoMaxWidth : 1140,
				vimeoColor : 'CCCCCC',
				
		
		
			)
	
	*/

	
	$plxPlugin->setParam('article', $_POST['article'], 'string');
	$plxPlugin->setParam('static', $_POST['static'], 'string');
	$plxPlugin->setParam('extra_small_device', $_POST['extra_small_device'], 'string');
	$plxPlugin->setParam('small_device', $_POST['small_device'], 'string');
	$plxPlugin->setParam('medium_device', $_POST['medium_device'], 'string');
	$plxPlugin->setParam('large_device', $_POST['large_device'], 'string');
	$plxPlugin->setParam('videos', $_POST['videos'], 'string');
	$plxPlugin->setParam('image_links', $_POST['image_links'], 'string');
	$plxPlugin->setParam('image_solo', $_POST['image_solo'], 'string');
	$plxPlugin->setParam('image_tb', $_POST['image_tb'], 'string');
	
	# PRETTYPHOTO PARAMS
	
	$plxPlugin->setParam('pp_animation_speed', $_POST['pp_animation_speed'], 'string');
	$plxPlugin->setParam('pp_slideshow', $_POST['pp_slideshow'], 'string');
	$plxPlugin->setParam('pp_slideshow_delay', $_POST['pp_slideshow_delay'], 'numeric');
	$plxPlugin->setParam('pp_slideshow_autoplay', $_POST['pp_slideshow_autoplay'], 'string');
	$plxPlugin->setParam('pp_opacity', $_POST['pp_opacity'], 'numeric');
	$plxPlugin->setParam('pp_show_title', $_POST['pp_show_title'], 'string');
	$plxPlugin->setParam('pp_allow_resize', $_POST['pp_allow_resize'], 'string');
	$plxPlugin->setParam('pp_width', $_POST['pp_width'], 'number');
	$plxPlugin->setParam('pp_height', $_POST['pp_height'], 'number');
	$plxPlugin->setParam('pp_separator', $_POST['pp_separator'], 'string');
	$plxPlugin->setParam('pp_theme', $_POST['pp_theme'], 'string');
	$plxPlugin->setParam('pp_horizontal_padding', $_POST['pp_horizontal_padding'], 'numeric');
	$plxPlugin->setParam('pp_hide_flash', $_POST['pp_hide_flash'], 'string');
	$plxPlugin->setParam('pp_wmode', $_POST['pp_wmode'], 'string');
	$plxPlugin->setParam('pp_deeplinking', $_POST['pp_deeplinking'], 'string');
	$plxPlugin->setParam('pp_overlay_gallery', $_POST['pp_overlay_gallery'], 'string');
	$plxPlugin->setParam('pp_keyboard_shortcuts', $_POST['pp_keyboard_shortcuts'], 'string');
	$plxPlugin->setParam('pp_social', $_POST['pp_social'], 'string');
	$plxPlugin->setParam('pp_video_autoplay', $_POST['pp_video_autoplay'], 'string');
	$plxPlugin->setParam('pp_modal', $_POST['pp_modal'], 'string');
	
	# SWIPEBOX PARAMS
	$plxPlugin->setParam('sb_useCSS', $_POST['sb_useCS'], 'string');
	$plxPlugin->setParam('sb_hide_bars_delay', $_POST['sb_hide_bars_delay'], 'numeric');
	$plxPlugin->setParam('sb_video_max_width', $_POST['sb_video_max_width'], 'numeric');
	$plxPlugin->setParam('sb_vimeoColor', $_POST['sb_vimeoColor'], 'string');
	
	# ZOOMBOX PARAMS
	$plxPlugin->setParam('zb_theme', $_POST['zb_theme'], 'string');
	$plxPlugin->setParam('zb_opacity', $_POST['zb_opacity'], 'string');
	$plxPlugin->setParam('zb_duration', $_POST['zb_duration'], 'numeric');
	$plxPlugin->setParam('zb_animation', $_POST['zb_animation'], 'string');
	$plxPlugin->setParam('zb_width', $_POST['zb_width'], 'numeric');
	$plxPlugin->setParam('zb_height', $_POST['zb_height'], 'numeric');
	$plxPlugin->setParam('zb_gallery', $_POST['zb_gallery'], 'string');
	$plxPlugin->setParam('zb_autoplay', $_POST['zb_autoplay'], 'string');
	
	$plxPlugin->saveParams();
	
	header('Location: parametres_plugin.php?p=spxlightbox');
	exit;
}


$adevice = array('0'=>L_NO,'swipebox'=>'swipebox','prettyphoto'=>'prettyphoto','zoombox'=>'zoombox');

?>

<h2><?php echo $plxPlugin->getInfo('title') ?></h2>

<form action="parametres_plugin.php?p=spxlightbox" method="post" id="form_spxlightbox">
	<fieldset>
		
        <p class="field_head">&nbsp;<?php $plxPlugin->lang('L_PARAM') ?>
				<strong><?php $plxPlugin->lang('L_GENERAL') ?></strong>
		</p>
        
        <p class="field"><label for="id_article"><?php echo $plxPlugin->lang('L_ARTICLE') ?></label></p>
		<?php plxUtils::printSelect('article',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('article'));?>
		<br />
       
        <p class="field"><label for="id_static"><?php echo $plxPlugin->lang('L_STATIC') ?></label></p>
		<?php plxUtils::printSelect('static',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('static'));?>
		<br />
        
         <p class="field"><?php echo $plxPlugin->lang('L_DEVICES') ?></p>
        
        <p class="field"><label for="id_extra_small_device"><?php echo $plxPlugin->lang('L_EXTRA_SMALL_DEVICE') ?></label></p>
		<?php plxUtils::printSelect('extra_small_device',$adevice, $plxPlugin->getParam('extra_small_device'));?>
		<br />
        
         <p class="field"><label for="id_small_device"><?php echo $plxPlugin->lang('L_SMALL_DEVICE') ?></label></p>
		<?php plxUtils::printSelect('small_device',$adevice, $plxPlugin->getParam('small_device'));?>
		<br />
        
         <p class="field"><label for="id_medium_device"><?php echo $plxPlugin->lang('L_MEDIUM_DEVICE') ?></label></p>
		<?php plxUtils::printSelect('medium_device',$adevice, $plxPlugin->getParam('medium_device'));?>
		<br />
        
         <p class="field"><label for="id_large_device"><?php echo $plxPlugin->lang('L_LARGE_DEVICE') ?></label></p>
		<?php plxUtils::printSelect('large_device',$adevice, $plxPlugin->getParam('large_device'));?>
		<br />
        
        <p class="field"><?php echo $plxPlugin->lang('L_MEDIAS_ACTIVATE') ?></p>
         <p class="field"><label for="id_videos"><?php echo $plxPlugin->lang('L_VIDEOS') ?></label></p>
		<?php plxUtils::printSelect('videos',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('videos'));?>
		<br />
        
         <p class="field"><label for="id_image_links"><?php echo $plxPlugin->lang('L_IMAGE_LINKS') ?></label></p>
		<?php plxUtils::printSelect('image_links',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('image_links'));?>
		<br />
        
         <p class="field"><label for="id_image_solo"><?php echo $plxPlugin->lang('L_IMAGE_SOLO') ?></label></p>
		<?php plxUtils::printSelect('image_solo',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('image_solo'));?>
		<br />
        
         <p class="field"><label for="id_image_tb"><?php echo $plxPlugin->lang('L_IMAGE_TB') ?></label></p>
		<?php plxUtils::printSelect('image_tb',array('1'=>L_YES,'0'=>L_NO), $plxPlugin->getParam('image_tb'));?>
		<br />
        <!--
        
        
        
        
        
        
        -->
        
        
        
        
        
        <p class="field_head">&nbsp;<?php $plxPlugin->lang('L_PARAM') ?>
				<strong><?php $plxPlugin->lang('L_PARAMSWIPEBOX') ?></strong>
		</p>
        
        <p class="field"><label for="id_sb_useCSS"><?php $plxPlugin->lang('L_ANIMATION_TYPE') ?></label></p>
		<?php plxUtils::printSelect('sb_useCSS',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('sb_useCSS')) ?>
     
       <p class="field"><label for="id_hide_bars_delay"><?php $plxPlugin->lang('L_HIDE_BARS_DELAY') ?></label></p>
		<?php plxUtils::printInput('sb_hide_bars_delay',$plxPlugin->getParam('sb_hide_bars_delay'),'text','4-4') ?>
          <p class="field"><label for="id_sb_video_max_width"><?php $plxPlugin->lang('L_VIDEO_MAX') ?></label></p>
		<?php plxUtils::printInput('sb_video_max_width',$plxPlugin->getParam('sb_video_max_width'),'text','4-4') ?>
         <p class="field"><label for="id_sb_vimeoColor"><?php $plxPlugin->lang('L_VIMEO_COLOR') ?></label></p>
		<?php plxUtils::printInput('sb_vimeoColor',$plxPlugin->getParam('sb_vimeoColor'),'text','6-6') ?>
        
        
        
        <p class="field_head">&nbsp;<?php $plxPlugin->lang('L_PARAM') ?>
				<strong><?php $plxPlugin->lang('L_PARAMPRETTYPHOTO') ?></strong>
		</p>
        
        	
        <p class="field"><label for="id_pp_theme"><?php $plxPlugin->lang('L_THEME') ?></label></p>
		<?php plxUtils::printSelect('pp_theme',array('pp_default'=>'pp_default','light_rounded'=>'light_rounded','dark_rounded'=>'dark_rounded','light_square'=>'light_square','dark_square'=>'dark_square','facebook'=>'facebook'),$plxPlugin->getParam('pp_theme')) ?>
          <p class="field"><label for="id_pp_separator"><?php $plxPlugin->lang('L_SEPARATOR') ?></label></p>
		<?php plxUtils::printSelect('pp_separator',array('/'=>'/','-'=>'-'),$plxPlugin->getParam('pp_separator')) ?>
          <p class="field"><label for="id_pp_animation_speed"><?php $plxPlugin->lang('L_ANIMATIONSPEED') ?></label></p>
		<?php plxUtils::printSelect('pp_animation_speed',array('fast'=>'fast','normal'=>'normal','slow'=>'slow'),$plxPlugin->getParam('pp_animation_speed')) ?>
          <p class="field"><label for="id_pp_wmode"><?php $plxPlugin->lang('L_WMODE') ?></label></p>
		<?php plxUtils::printSelect('pp_wmode',array('opaque'=>'opaque','window'=>'window','direct'=>'direct','transparent'=>'transparent','gpu'=>'gpu'),$plxPlugin->getParam('pp_wmode')) ?>
        
        
       
       <p class="field"><label for="id_pp_width"><?php $plxPlugin->lang('L_WIDTH') ?></label></p>
		<?php plxUtils::printInput('pp_width',$plxPlugin->getParam('pp_width'),'text','4-4') ?>
		<p class="field"><label for="id_pp_height"><?php $plxPlugin->lang('L_HEIGHT') ?></label></p>
		<?php plxUtils::printInput('pp_height',$plxPlugin->getParam('pp_height'),'text','4-4') ?>
        
        <p class="field"><label for="id_pp_slideshow_delay"><?php $plxPlugin->lang('L_SLIDESHOW_DELAY') ?></label></p>
		<?php plxUtils::printInput('pp_slideshow_delay',$plxPlugin->getParam('pp_slideshow_delay'),'text','4-4') ?>
        <p class="field"><label for="id_pp_opacity"><?php $plxPlugin->lang('L_OPACITY') ?></label></p>
		<?php plxUtils::printInput('pp_opacity',$plxPlugin->getParam('pp_opacity'),'text','4-4') ?>
        <p class="field"><label for="id_pp_horizontal_padding"><?php $plxPlugin->lang('L_HORIZONTAL_PADDING') ?></label></p>
		<?php plxUtils::printInput('pp_horizontal_padding',$plxPlugin->getParam('pp_horizontal_padding'),'text','4-4') ?>
        
       <p class="field"><label for="id_slideshow"><?php $plxPlugin->lang('L_SLIDESHOW') ?></label></p>
		<?php plxUtils::printSelect('pp_slideshow',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_slideshow')) ?>
        <p class="field"><label for="id_pp_slideshow_autoplay"><?php $plxPlugin->lang('L_SLIDESHOW_AUTOPLAY') ?></label></p>
		<?php plxUtils::printSelect('pp_slideshow_autoplay',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_slideshow_autoplay')) ?>
        <p class="field"><label for="id_pp_show_title"><?php $plxPlugin->lang('L_SHOWTITLE') ?></label></p>
		<?php plxUtils::printSelect('pp_show_title',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_show_title')) ?>
        <p class="field"><label for="id_pp_allow_resize"><?php $plxPlugin->lang('L_ALLOW_RESIZE') ?></label></p>
		<?php plxUtils::printSelect('pp_allow_resize',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_allow_resize')) ?>
        <p class="field"><label for="id_pp_hide_flash"><?php $plxPlugin->lang('L_HIDEFLASH') ?></label></p>
		<?php plxUtils::printSelect('pp_hide_flash',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_hide_flash')) ?>
        <p class="field"><label for="id_pp_video_autoplay"><?php $plxPlugin->lang('L_VIDEOAUTOPLAY') ?></label></p>
		<?php plxUtils::printSelect('pp_video_autoplay',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_video_autoplay')) ?>
        <p class="field"><label for="id_pp_modal"><?php $plxPlugin->lang('L_MODAL') ?></label></p>
		<?php plxUtils::printSelect('pp_modal',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_modal')) ?>
        <p class="field"><label for="id_pp_deeplinking"><?php $plxPlugin->lang('L_DEEPLINKING') ?></label></p>
		<?php plxUtils::printSelect('pp_deeplinking',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_deeplinking')) ?>
        <p class="field"><label for="id_pp_overlay_gallery"><?php $plxPlugin->lang('L_OVERLAY_GALLERY') ?></label></p>
		<?php plxUtils::printSelect('pp_overlay_gallery',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_overlay_gallery')) ?>
        <p class="field"><label for="id_pp_keyboard_shortcuts"><?php $plxPlugin->lang('L_KEYBOARDSHORCUTS') ?></label></p>
		<?php plxUtils::printSelect('pp_keyboard_shortcuts',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_keyboard_shortcuts')) ?>
        <p class="field"><label for="id_pp_social"><?php $plxPlugin->lang('L_SOCIAL') ?></label></p>
		<?php plxUtils::printSelect('pp_social',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('pp_social')) ?>
       
       
        
        <p class="field_head">&nbsp;<?php $plxPlugin->lang('L_PARAM') ?>
				<strong><?php $plxPlugin->lang('L_PARAMZOOMBOX') ?></strong>
		</p>
        
        <p class="field"><label for="id_theme"><?php $plxPlugin->lang('L_THEME') ?></label></p>
		<?php plxUtils::printSelect('zb_theme',array('zoombox'=>'zoombox','lightbox'=>'lightbox','prettyphoto'=>'prettyphoto','darkprettyphoto'=>'darkprettyphoto','simple'=>'simple'),$plxPlugin->getParam('zb_theme')) ?>
		<p class="field"><label for="id_opacity"><?php $plxPlugin->lang('L_OPACITY') ?></label></p>
		<?php plxUtils::printInput('zb_opacity',$plxPlugin->getParam('zb_opacity'),'text','4-4') ?>
		<p class="field"><label for="id_duration"><?php $plxPlugin->lang('L_DURATION') ?></label></p>
		<?php plxUtils::printInput('zb_duration',$plxPlugin->getParam('zb_duration'),'text','4-4') ?>
		<p class="field"><label for="id_animation"><?php $plxPlugin->lang('L_ANIMATION') ?></label></p>
		<?php plxUtils::printSelect('zb_animation',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('zb_animation')) ?>
		<p class="field"><label for="id_width"><?php $plxPlugin->lang('L_WIDTH') ?></label></p>
		<?php plxUtils::printInput('zb_width',$plxPlugin->getParam('zb_width'),'text','4-4') ?>
		<p class="field"><label for="id_height"><?php $plxPlugin->lang('L_HEIGHT') ?></label></p>
		<?php plxUtils::printInput('zb_height',$plxPlugin->getParam('zb_height'),'text','4-4') ?>
		<p class="field"><label for="id_gallery"><?php $plxPlugin->lang('L_GALLERY') ?></label></p>
		<?php plxUtils::printSelect('zb_gallery',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('zb_gallery')) ?>
		<p class="field"><label for="id_autoplay"><?php $plxPlugin->lang('L_AUTOPLAY') ?></label></p>
		<?php plxUtils::printSelect('zb_autoplay',array('true'=>$plxPlugin->getLang('L_YES'),'false'=>$plxPlugin->getLang('L_NO')),$plxPlugin->getParam('zb_autoplay')) ?>
		
        
        <p class="field_head"></p>
        <p>
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
		</p>
	</fieldset>
</form>