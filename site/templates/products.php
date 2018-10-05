<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row">
			<div class="col-sm-12 mt-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-danger">
                        <li class="breadcrumb-item text-white"><?= $page->title; ?></li>
                    </ol>
                </nav>
				<?php echo "<h1 class='text-danger font-weight-bold'>" . $page->get('headline|title') . "</h1>"; ?>
                <?php $children = $page->children(); ?>
                <ul class="product-list">
                    <?php foreach ($children as $child) : ?>
    				    <a href="<?= $child->url; ?>">
                            <li><?= $child->title; ?></li>
                        </a>
                    <?php endforeach; ?>
                </ul>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
