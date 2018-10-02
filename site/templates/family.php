<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row">
			<div class="col-sm-12 mt-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-danger">
                        <li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->parent->url; ?>"><?= $page->parent->parent->title; ?></a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->url; ?>"><?= $page->parent->title; ?></a></li>
                        <li class="breadcrumb-item text-white"><?= ucwords(strtolower($page->title)); ?></li>
                    </ol>
                </nav>
                <?php echo "<h1 class='text-danger font-weight-bold'>" . ucwords(strtolower($page->get('headline|title'))) . "</h1>"; ?>
                <?php $children = $page->children(); ?>
            </div>
            <?php foreach ($children as $child) : ?>
                <div class="col-sm-4 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="<?= $child->product_image->url; ?>" alt="<?= ucwords(strtolower($child->imagetext)); ?>">
                        <div class="card-body">
                            <p class="card-text">
                                <a href="<?= $child->url; ?>"><?= ucwords(strtolower($child->title)); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
