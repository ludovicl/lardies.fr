<?php include(dirname(__FILE__) . '/header.php'); ?>

<!-- Static container -->
    <div class="container static">
		<div class="span8">
			<div class="modal-header">
				<h2><?php $plxShow->staticTitle(); ?></h2>
			</div>
			<div class="modal-body">
				<?php $plxShow->staticContent(); ?>
			</div>
		</div>
    </div>
    <!--END: Static container-->

<?php include(dirname(__FILE__) . '/footer.php'); ?>
