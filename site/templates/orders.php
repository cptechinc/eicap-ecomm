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
						<div class="col">Order Total</div>
						<div class="col">Order Date</div>
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
			
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1"><?= $order->custid; ?></h5>
					<small class="text-muted"><?= $order->orderno; ?></small>
				</div>
				<p class="mb-1"><?= $order->custpo; ?></p>
				<small class="text-muted">$<?= $order->ordertotal; ?></small>
			</a>
        </div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Customer</th>
					<th scope="col">Ship to</th>
					<th scope="col">Order Total</th>
					<th scope="col">Order Date</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row"><?= $order->orderno; ?></th>
					<td><?= $order->custid; ?></td>
					<td><?= $order->shiptoid; ?></td>
					<td>$ <?= $order->ordertotal; ?></td>
					<td><?= $order->orderdate; ?></td>
				</tr>
			</tbody>
		</table>
    </div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
