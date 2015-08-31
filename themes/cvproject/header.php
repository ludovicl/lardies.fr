<?php if (!defined('PLX_ROOT')) exit; ?>
<!DOCTYPE html>
<html lang="<?php $plxShow->defaultLang() ?>">
<head>
<meta charset="<?php $plxShow->charset('min'); ?>">
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
<title><?php $plxShow->pageTitle(); ?></title>
<?php $plxShow->meta('description') ?>
<?php $plxShow->meta('keywords') ?>
<?php $plxShow->meta('author') ?>
<link rel="icon" href="<?php $plxShow->template(); ?>/img/favicon.png" />
<link rel="stylesheet" href="<?php $plxShow->template(); ?>/css/style.css" media="screen"/>
<link href="<?php $plxShow->template(); ?>/font/css/fontello.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
<?php $plxShow->templateCss() ?>
<?php $plxShow->pluginsCss() ?>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="<?php $plxShow->template(); ?>/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php $plxShow->template(); ?>/js/html5ie.js"></script>
<script src="<?php $plxShow->template(); ?>/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="navbar">
		<div class="navbar-inner">
			<div class="container"> 
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> 
				<!-- <a class="brand" href="index.php"><img src="data/images/profil.jpg"/></a> -->
				  <ul class="nav nav-collapse pull-left">
					<!-- <?php $plxShow->staticList($plxShow->getLang('Profil'),'<li><a href="#static_url" title="#static_name"><i class="icon-user"></i> #static_name</a></li>'); ?> -->
					<li><a href="/index.php" title="Profil"><i class="icon-user"></i>Profil</a></li>
					<li><a href="/static3/cv" title="CV"><i class="icon-tasks"></i> CV</a></li>
					<?php $plxShow->pageBook('<li><a href="#page_url" title=Projets><i class="icon-th-large"></i> Projets</a></li>'); ?>
					<li><a href="/static2/dlcv" title="Télécharger CV"><i class="icon-doc-text-inv"></i> Télécharger CV</a></li>
				  </ul>
				  <!-- Everything you want hidden at 940px or less, place within here -->
				<div class="nav-collapse collapse">
					<!-- .nav, .navbar-search, .navbar-form, etc -->
				</div>
			</div>
		</div>
    </div>