<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# récuperation d'une instance de plxShow
$plxShow = plxShow::getInstance();
$plxShow->plxMotor->plxCapcha = new plxCapcha();
$plxPlugin = $plxShow->plxMotor->plxPlugins->getInstance('plxMyContact');

$error=false;
$success=false;

$captcha = $plxPlugin->getParam('captcha')=='' ? '1' : $plxPlugin->getParam('captcha');

if(!empty($_POST)) {
	$name=plxUtils::unSlash($_POST['name']);
	$mail=plxUtils::unSlash($_POST['mail']);
	$content=plxUtils::unSlash($_POST['content']);
	if(trim($name)=='')
		$error = $plxPlugin->getLang('L_ERR_NAME');
	elseif(!plxUtils::checkMail($mail))
		$error = $plxPlugin->getLang('L_ERR_EMAIL');
	elseif(trim($content)=='')
		$error = $plxPlugin->getLang('L_ERR_CONTENT');
	elseif($captcha AND $_POST['rep2'] != sha1($_POST['rep']))
		$error = $plxPlugin->getLang('L_ERR_ANTISPAM');
	if(!$error) {
		if(plxUtils::sendMail($name,$mail,$plxPlugin->getParam('email'),$plxPlugin->getParam('subject'),$content,'text',$plxPlugin->getParam('email_cc'),$plxPlugin->getParam('email_bcc')))
			$success = $plxPlugin->getParam('thankyou');
		else
			$error = $plxPlugin->getLang('L_ERR_SENDMAIL');
	}
} else {
	$name='';
	$mail='';
	$content='';
}

?>

<div id="form_contact">
	<?php if($error): ?>
	<p class="contact_error"><?php echo $error ?></p>
	<?php endif; ?>
	<?php if($success): ?>
	<p class="contact_success"><?php echo plxUtils::strCheck($success) ?></p>
	<?php else: ?>
	<?php if($plxPlugin->getParam('mnuText')): ?>
	<div class="text_contact">
	<?php echo $plxPlugin->getParam('mnuText') ?>
	</div>
	<?php endif; ?>
	<form action="#form" method="post">
		<fieldset>
			<input id="name" name="name" type="text" size="30" value="<?php echo plxUtils::strCheck($name) ?>" placeholder="<?php $plxPlugin->lang('L_FORM_NAME') ?>" />
			<input id="mail" name="mail" type="text" size="30" value="<?php echo plxUtils::strCheck($mail) ?>" placeholder="<?php $plxPlugin->lang('L_FORM_MAIL') ?>" />
			<textarea id="message" name="content" rows="4" style="width:80%" placeholder="<?php $plxPlugin->lang('L_FORM_CONTENT') ?>"><?php echo plxUtils::strCheck($content) ?></textarea>
			<?php if($captcha): ?>
			<label for="id_rep"><strong><?php $plxPlugin->lang('L_FORM_ANTISPAM') ?></strong>&nbsp;:</label>
			<?php echo $plxShow->capchaQ() ?>&nbsp;:&nbsp;<input id="id_rep" name="rep" type="text" size="10" placeholder="Inscrire la réponse à la question" />
			<input name="rep2" type="hidden" value="<?php echo $plxShow->capchaR() ?>" />
			<?php endif; ?>
			<p>
				<button type="submit" name="submit" class="btn" value="<?php $plxPlugin->lang('L_FORM_BTN_SEND') ?>"><i class="icon-paper-plane"></i> ENVOYER</button>
				<button type="reset" name="reset" class="btn" value="<?php $plxPlugin->lang('L_FORM_BTN_RESET') ?>"><i class="icon-cancel"></i> EFFACER</button>
			</p>
		</fieldset>
	</form>
	<?php endif; ?>
</div>
