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
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-responsive">
					<thead>
						<th>Image</th>
						<th>ItemID</th>
						<th>Description</th>
						<th>Qty</th>
						<th>Submit</th>
					</thead>
					<tbody>
						<?php foreach ($children as $child) : ?>
						<tr>
							<form class="" action="<?= $config->pages->root. 'cart/redir/'; ?>" method="post">
								<input type="hidden" name="action" value="add-to-cart">
								<input type="hidden" name="itemID" value="<?= $child->itemid; ?>">
								<td class="col-sm-3"><img class="card-img-top" src="<?= $child->product_image->url; ?>" alt="<?= ucwords(strtolower($child->imagetext)); ?>"></td>
								<td class="col-sm-2"><?= $child->itemid; ?></td>
								<td class="col-sm-5"><a href="<?= $child->url; ?>"><?= ucwords(strtolower($child->title)); ?></a></td>
								<td class="col-sm-1">
									<input class="form-control" type="text" name="qty" size="4" value="0">
								</td>
								<td class="col-sm-1">
									<button class="btn btn-primary" type="submit" name="add_to_cart">Add</button>
								</td>
							</form>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
