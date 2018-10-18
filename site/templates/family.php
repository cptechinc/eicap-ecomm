<?php include('./_head.php'); ?>
	<div class='container page top-margin'>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-danger">
				<li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->parent->url; ?>"><?= $page->parent->parent->title; ?></a></li>
				<li class="breadcrumb-item"><a class="text-white" href="<?= $page->parent->url; ?>"><?= $page->parent->title; ?></a></li>
				<li class="breadcrumb-item text-white"><?= ucwords(strtolower($page->title)); ?></li>
			</ol>
		</nav>
		<div class="form-group">
		    <?php include "{$config->paths->content}products/search/form.php"; ?>
		</div>
		<div class="row">
			<?php foreach ($page->children() as $product) : ?>
				<div class="col-12 col-sm-4 form-group">
					<div class="card">
						<img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1665ef17807%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1665ef17807%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.18333435058594%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
						<div class="card-body">
							<h5 class="card-title"><?= $product->itemid; ?></h5>
							<p class="card-text"><?= ucwords(strtolower($product->title)); ?></p>
							<form class="form-inline" action="<?= $config->pages->root. 'cart/redir/'; ?>" method="post">
								<input type="hidden" name="action" value="add-to-cart">
								<input type="hidden" name="itemID" value="<?= $product->itemid; ?>">
								<div class="row">
									<div class="col">
										<input class="form-control" type="text" name="qty" size="4" value="1">
									</div>
									<div class="col">
										<button class="btn btn-success" type="submit" name="add_to_cart">Add</button>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
