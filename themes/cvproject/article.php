<?php include(dirname(__FILE__).'/header.php'); ?>

<!-- book container -->
    <div class="container book">
		<h2>Projets</h2>
		<ul class="breadcrumb">
			<li>Vous &ecirc;tes ici : <a href="index.php">Accueil</a> | </li>
			<li><a href="/index.php?book">Projet</a> | </li>
			<li><?php $plxShow->artCat(); ?> | </li>
			<li class="active"><?php $plxShow->artTitle(''); ?></li>
		</ul>
		<div class="span8">
			<h1><?php $plxShow->artTitle(''); ?></h1>
			<?php eval($plxShow->callHook('champArt', '')); ?>
			<?php $plxShow->artContent(''); ?>
			<?php eval($plxShow->callHook('ArtgalerieDisplay')); ?>
		</div>
    </div>
    <!--END: book container-->

<?php include(dirname(__FILE__).'/footer.php'); ?>
