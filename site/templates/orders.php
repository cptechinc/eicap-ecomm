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

<!-------------------------------- START SEARCH FORM  -->
		<div class="panel-body">
			<div class="row mb-3">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#orders-search-div" aria-expanded="false" aria-controls="orders-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div id="orders-search-div" class="collapse">
				<form action="" method="get" data-ordertype="sales-orders" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="orders-search-form allow-enterkey-submit">
					<input type="hidden" name="filter" value="filter">

					<div class="row">
						<div class="col-sm-2">
							<h4>Order #</h4>
							<input class="form-control form-group inline input-sm" type="text" name="orderno[]" value="" placeholder="From Order #">
							<input class="form-control form-group inline input-sm" type="text" name="orderno[]" value="" placeholder="Through Order #">
						</div>
						<div class="col-sm-2">
							<h4>Cust ID</h4>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-from" value="" placeholder="From CustID">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-sm not-round get-custid-search" data-field="#sales-order-cust-from"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
								</span>
							</div>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-to" value="" placeholder="Through CustID">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-sm not-round get-custid-search" data-field="#sales-order-cust-to"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
								</span>
							</div>
						</div>
						<div class="col-sm-2">
							<h4>Order Total</h4>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="ordertotal[]" id="order-total-min" value="" placeholder="From Order Total">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-sm not-round" onclick="$('#order-total-min').val('')"> <span class="fa fa-angle-double-down" aria-hidden="true"></span> <span class="sr-only">Min</span> </button>
								</span>
							</div>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="ordertotal[]" id="order-total-max" value="" placeholder="Through Order Total">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-sm not-round" onclick="$('#order-total-max').val('')"> <span class="fa fa-angle-double-up" aria-hidden="true"></span> <span class="sr-only">Max</span> </button>
								</span>
							</div>
						</div>
						<div class="col-sm-2">
							<h4>Order Date</h4>
							<?php $name = 'orderdate[]'; $value = ''; ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
							<label class="small text-muted">From Date </label>

							<?php $name = 'orderdate[]'; $value = ''; ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
							<label class="small text-muted">Through Date </label>
						</div>
					</div>
					</br>
					<div class="form-group">
						<button class="btn btn-primary btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
					generate clear search link
				</form>

			</div>
		</div>

<!-------------------------------- END SEARCH FORM  -->
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
		<a href="<?= $pages->get('/')->url; ?>" class="btn btn-primary my-1"><i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Go back to Account Page</a>

    </div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
