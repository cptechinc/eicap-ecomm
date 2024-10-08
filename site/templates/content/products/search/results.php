<?php
	if ($input->get->ordn) {
		$formaction = "{$config->pages->orders}redir/";
	} else {
		$formaction = "{$config->pages->cart}redir/";
	}
?>
<h1 class="text-danger font-weight-bold border-bottom border-primary mb-4"><?= $page->title; ?></h1>
<div class="form-group">
	<?php include "{$config->paths->content}products/search/form.php"; ?>
</div>
<div class="row">
	<?php foreach ($products as $product) : ?>
		<div class="col-12 col-sm-4 form-group">
			<div class="card">
				<?php if (!empty($product->product_image)) : ?>
					<img class="card-img-top" src="<?= $product->product_image->url; ?>" alt="Card image cap">
				<?php else :?>
					<img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1665ef17807%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1665ef17807%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.18333435058594%22%20y%3D%2296.3%22%3ENo Image Found%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
				<?php endif; ?>
				<div class="card-body">
					<h5 class="card-title"><?= $product->itemid; ?></h5>
					<p class="card-text"><?= htmlspecialchars_decode(ucwords(strtolower($product->title))); ?></p>
					<p class="card-text"><?= htmlspecialchars_decode(ucwords(strtolower($product->name2))); ?></p>
					<p class="card-text"><?= ucwords(strtolower($product->itemgroup)); ?></p>
					<form class="form-inline" action="<?= $formaction; ?>" method="post">
						<input type="hidden" name="action" value="add-to-order">
						<?php if ($input->get->ordn) : ?>
							<input type="hidden" name="ordn" value="<?= $input->get->text('ordn'); ?>">
						<?php endif; ?>
						<input type="hidden" name="itemID" value="<?= $product->itemid; ?>">
						<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
						<div class="row">
							<div class="col">
								Qty
								<input class="form-control" type="text" name="qty" size="4" value="1">
							</div>
							<div class="col">
								<button class="btn btn-success" type="submit">Add to Order</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
