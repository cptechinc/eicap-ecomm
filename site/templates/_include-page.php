<?php include('./_head.php'); ?>

	<div class='container page top-margin'>
        <div class="form-group">
            <h1 class="text-danger font-weight-bold border-bottom border-primary"><?= ucwords(strtolower($page->get('headline|title'))); ?></h1>
        </div>
        
		<?php include $page->body; ?>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
