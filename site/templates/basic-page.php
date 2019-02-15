<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row">
			<div class="col-sm-12">
				<?php // echo "<h1>" . $page->get('headline|title') . "</h1>";
				echo $page->body;
				renderNav($page->children); ?>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
