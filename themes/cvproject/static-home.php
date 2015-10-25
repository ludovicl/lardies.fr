<?php include(dirname(__FILE__).'/header.php'); ?>

	<!--Profile container-->
    <div class="container profile">
      <div class="span3"> <img src="data/images/mini.png" > </div>
      <div class="span5">
        <h1><?php $plxShow->staticTitle(); ?></h1>
		<?php $plxShow->staticContent(); ?>
		
		<!-- <a href="/index.php?contact" class="button-static"><i class="icon-mail"></i> Contactez moi </a> -->
		<a href="mailto:ludovic.lardies@icloud.com" class="button-static"><i class="icon-mail"></i> Contactez moi </a>

        <!-- <a href="<?php $plxShow->urlRewrite('feed.php?rss') ?>" class="button-static"><i class="icon-rss"></i> Suivez-moi </a> --> </div>

    </div>
    <div class="row social">
      <ul class="social-icons">
		  <strong>Retrouvez moi sur</strong> <br>
   		<li><a href="skype:ludoviclrds@outlook.com" target="_blank"><img src="data/images/icones/skype.png" alt="skype"></a></li>
		<li><a href="http://fr.linkedin.com/pub/ludovic-lardies/58/b73/3b7/" target="_blank"><img src="data/images/icones/linkedin.png" alt="linkedin"></a></li>
		<li><a href="https://github.com/ludovicl" target="_blank" ><img src="data/images/icones/github.png" alt="github"></a></li>
      </ul>
    </div>
    <!--END: Profile container-->

<?php include(dirname(__FILE__).'/footer.php'); ?>