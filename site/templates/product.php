<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row">
			<div class="col-sm-12 mt-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-danger">
                        <li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->parent->parent->url; ?>"><?= $page->parent->parent->parent->title; ?></a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->parent->url; ?>"><?= $page->parent->parent->title; ?></a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->url; ?>"><?= ucwords(strtolower($page->parent->title)); ?></a></li>
                        <li class="breadcrumb-item text-white"><?= ucwords(strtolower($page->title)); ?></li>
                    </ol>
                </nav>
				<?php echo "<h1 class='text-danger font-weight-bold'>" . ucwords(strtolower($page->get('headline|title'))) . "</h1>";
				echo $page->body;
				renderNav($page->children); ?>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
