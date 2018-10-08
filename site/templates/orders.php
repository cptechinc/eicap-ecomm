<?php
	$salesordersdisplay = new SalesOrdersDisplay(session_id(), $page->fullURL, $modal = '', $loadint = '', $ajax = false);
	$salesordersdisplay->pagenbr = $input->pageNum;
	$salesordersdisplay->get_ordercount();
	$salesordersdisplay->paginationinsertafter = $page->name;
	$paginator = new Paginator($salesordersdisplay->pagenbr, $salesordersdisplay->count, $salesordersdisplay->pageurl->getUrl(), $salesordersdisplay->paginationinsertafter, $salesordersdisplay->ajaxdata);
?>

<?php $orders = $salesordersdisplay->get_orders(); ?>
<?php include('./_head.php'); // include header markup ?>
	<div class="container page top-margin">
		<h1 class="text-danger font-weight-bold">Your Orders</h1>
        <div class="list-group">
			<div class="form-group">
				<div href="#" class="list-group-item list-group-item-action bg-secondary text-white font-weight-bold">
					<div class="row">
						<div class="col">Order #</div>
						<div class="col">Customer</div>
						<div class="col">Shiptoid</div>
						<div class="col text-right">Order Total</div>
						<div class="col text-right">Order Date</div>
					</div>
				</div>
	            <?php foreach ($orders as $order) : ?>
	                <a href="<?= $salesordersdisplay->generate_loaddetailsurl($order); ?>" class="list-group-item list-group-item-action">
						<div class="row">
							<div class="col"><?= $order->orderno; ?></div>
							<div class="col"><?= $order->custid; ?></div>
							<div class="col"><?= $order->shiptoid; ?></div>
							<div class="col text-right">$ <?= $order->ordertotal; ?></div>
							<div class="col text-right"><?= $order->orderdate; ?></div>
						</div>
	                </a>
	            <?php endforeach; ?>
			</div>

			<div class="align-self-center"><?= $paginator; ?></div>
        </div>
		<a href="<?= $pages->get('/')->url; ?>" class="btn btn-primary my-1">Go back to Account Page</a>

    </div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
