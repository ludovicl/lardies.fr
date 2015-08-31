<?php include(dirname(__FILE__).'/header.php'); ?>

	<!-- Book container -->
    <div class="container book">
		<h2>Projets</h2>
		<ul class="booknav">
			<li><a href="/index.php?book" class="active" title="Tout">Tout</a></li>
			<?php $plxShow->catList('','<li><a href="#cat_url" title="#cat_name">#cat_name</a></li>'); ?>
		</ul>
		<ul class="book-images">
			<?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>
				<li>
					<div class="book-images"><a href="<?php $plxShow->artUrl() ?>"><?php $plxShow->artChapo(''); ?></a></div>
				</li>
			<?php endwhile; ?>
		</ul>
    </div>
    <!--END: Book container-->
	
	<div id="pagination">
			<?php $plxShow->pagination(); ?>
	</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
