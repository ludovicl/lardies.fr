<?php include(dirname(__FILE__).'/header.php'); ?>
	<!--Skills container-->
    <div class="container skills">
		<h2><?php $plxShow->catName(); ?></h2>
		<?php $plxShow->catDescription(' : #cat_description'); ?>
		
		<?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>
			<div class="row">
				<div class="span3">
					<div class="skill-<?php echo $plxShow->artId(); ?>">
						<h3><?php $plxShow->artTitle(''); ?></h3>
					</div>
				</div>
				<div class="span5">
					<?php $plxShow->artContent(); ?>
				</div>
			</div>
		<?php endwhile; ?>
    </div>
    <!--END: Skills container-->

<?php include(dirname(__FILE__).'/footer.php'); ?>
