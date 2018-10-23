<?php include('./_head.php'); ?>
	<div class='container top-margin'>
		<div class="form-group">
			<h1 class="text-danger font-weight-bold border-bottom border-primary"><?= ucwords(strtolower($page->get('headline|title'))); ?></h1>
		</div>
	</div>
	<div class='container page top-margin'>
		<div class="form-group">
		    <?php include "{$config->paths->content}products/search/form.php"; ?>
		</div>

		<div class="row">
			<div class="col-sm-12">
                <?php $children = $page->children(); ?>
                <ul class="product-list">
                    <?php foreach ($page->children() as $child) : ?>
    				    <a href="<?= $child->url; ?>">
                            <li><?= ucwords(strtolower($child->title)); ?></li>
                        </a>
                    <?php endforeach; ?>
                </ul>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
