<?php
	use Dplus\Base\DplusDateTime;
	use Dplus\Ecomm\SalesOrdersDisplay;
	use Dplus\Content\PaginatorBootstrap4;

	$page->title = "Sales Orders";
	$salesordersdisplay = new SalesOrdersDisplay(session_id(), $page->fullURL, $modal = '', $loadint = '', $ajax = false);
	$salesordersdisplay->set('pagenbr', $input->pageNum);
	$salesordersdisplay->generate_filter($input);

	if ($user->hasRole('slsmgr')) {
		$filters = $salesordersdisplay->filters;
		$filters['salesperson'] = find_salesrepidsbyprograms(get_programtypesforuser($user->loginid));
		$salesordersdisplay->set('filters', $filters);
	}

	$salesordersdisplay->get_ordercount();
	$salesordersdisplay->set('paginationinsertafter', $page->name);
	$paginator = new PaginatorBootstrap4($salesordersdisplay->pagenbr, $salesordersdisplay->count, $salesordersdisplay->pageurl->getUrl(), $salesordersdisplay->paginationinsertafter, !empty($salesordersdisplay->ajaxdata) ? $salesordersdisplay->ajaxdata : '');

	$orders = $salesordersdisplay->get_orders();
?>
<?php include('./_head.php'); // include header markup ?>
	<div class='container top-margin'>
		<div class="form-group">
			<h1 class="text-danger font-weight-bold border-bottom border-primary">
				<?= ucwords(strtolower($page->get('headline|title'))); ?>
			</h1>
		</div>
	</div>
	<div class="container page mt-2">
		<div>
			<div class="form-group">
				<div class="list-group-item list-group-item-action bg-primary text-white font-weight-bold">
					Total Orders <span class="badge badge-pill badge-light"><?= $salesordersdisplay->count; ?></span>
					<span class="pull-right">Page <?= $salesordersdisplay->pagenbr; ?></span>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#orders-search-div" aria-expanded="false" aria-controls="orders-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>

			<div id="orders-search-div" class="<?= (empty($salesordersdisplay->filters)) ? 'collapse' : ''; ?>">
				<form action="<?= $salesordersdisplay->pageurl->getUrl(); ?>" method="get" data-ordertype="sales-orders" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="orders-search-form allow-enterkey-submit">
					<input type="hidden" name="filter" value="filter">

					<div class="row">
						<div class="col-sm-2">
							<h4>Hold Status</h4>
							<input type="checkbox" name="holdstatus[]" value="n" <?= ($salesordersdisplay->has_filtervalue('holdstatus', 'n')) ? 'checked' : ''; ?> >
							<label>&emsp;Approved</label></br>
							<input type="checkbox" name="holdstatus[]" value="R" <?= ($salesordersdisplay->has_filtervalue('holdstatus', 'R')) ? 'checked' : ''; ?> >
							<label>&emsp;On Review</label>
						</div>
						<div class="col-sm-2">
							<h4>Order #</h4>
							<input class="form-control form-group inline input-sm" type="text" name="ordernumber[]" value="<?= $salesordersdisplay->get_filtervalue('ordernumber'); ?>" placeholder="From Order #">
							<input class="form-control form-group inline input-sm" type="text" name="ordernumber[]" value="<?= $salesordersdisplay->get_filtervalue('ordernumber', 1); ?>" placeholder="Through Order #">
						</div>
						<div class="col-sm-3">
							<h4>Cust ID</h4>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-from" value="<?= $salesordersdisplay->get_filtervalue('custid'); ?>" placeholder="From CustID">
							</div>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-to" value="<?= $salesordersdisplay->get_filtervalue('custid', 1); ?>" placeholder="Through CustID">
							</div>
						</div>
						<div class="col-sm-3">
							<h4>Order Total</h4>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="total_order[]" id="order-total-min" value="<?= $salesordersdisplay->get_filtervalue('total_order'); ?>" placeholder="From Order Total">
								<span class="input-group-append">
									<button type="button" class="btn btn-outline-secondary input-group-text not-round" onclick="$('#order-total-min').val('<?= $salesordersdisplay->get_minsalesordertotal(); ?>')"> <span class="fa fa-angle-double-down" aria-hidden="true"></span> <span class="sr-only">Min</span> </button>
								</span>
							</div>
							<div class="input-group form-group">
								<input class="form-control form-group inline input-sm" type="text" name="total_order[]" id="order-total-max" value="<?= $salesordersdisplay->get_filtervalue('total_order', 1); ?>" placeholder="Through Order Total">
								<span class="input-group-append">
									<button type="button" class="btn btn-outline-secondary input-group-text not-round" onclick="$('#order-total-max').val('<?= $salesordersdisplay->get_maxsalesordertotal(); ?>')"> <span class="fa fa-angle-double-up" aria-hidden="true"></span> <span class="sr-only">Max</span> </button>
								</span>
							</div>
						</div>
						<div class="col-sm-2">
							<h4>Order Date</h4>
							<?php $name = 'order_date[]'; $value = $salesordersdisplay->get_filtervalue('order_date'); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
							<label class="small text-muted">From Date </label>

							<?php $name = 'order_date[]'; $value = $salesordersdisplay->get_filtervalue('order_date', 1); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
							<label class="small text-muted">Through Date </label>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="form-group col-md-6">
							<button class="btn btn-primary btn-block" type="submit">
								Search <i class="fa fa-search" aria-hidden="true"></i>
							</button>
						</div>
						<?php if ($input->get->filter) : ?>
							<div class="form-group col-md-6">
								<a href="<?= $salesordersdisplay->generate_loadurl(); ?>"  class="btn btn-warning btn-block">
									Clear Search <i class="fa fa-search-minus" aria-hidden="true"></i>
								</a>
							</div>
						<?php endif; ?>
					</div>
					<hr class="bg-danger">
				</form>
			</div>
		</div>
		<div class="list-group">
			<div class="form-group">
				<div href="#" class="list-group-item list-group-item-action bg-secondary font-weight-bold">
					<div class="row">
						<div class="col">
							<a href="<?= $salesordersdisplay->generate_tablesortbyurl("ordernumber") ; ?>" class="load-link text-white" <?= $salesordersdisplay->ajaxdata; ?>>
								Order # <?= $salesordersdisplay->tablesorter->generate_sortsymbol('ordernumber'); ?>
							</a>
						</div>
						<div class="col">
							<a href="<?= $salesordersdisplay->generate_tablesortbyurl("custid") ; ?>" class="load-link text-white" <?= $salesordersdisplay->ajaxdata; ?>>
								Customer <?= $salesordersdisplay->tablesorter->generate_sortsymbol('custid'); ?>
							</a>
						</div>
						<div class="col">
							<a href="<?= $salesordersdisplay->generate_tablesortbyurl("shiptoid") ; ?>" class="load-link text-white" <?= $salesordersdisplay->ajaxdata; ?>>
								Ship-To <?= $salesordersdisplay->tablesorter->generate_sortsymbol('shiptoid'); ?>
							</a>
						</div>
						<div class="col text-right">
							<a href="<?= $salesordersdisplay->generate_tablesortbyurl("total_order") ; ?>" class="load-link text-white" <?= $salesordersdisplay->ajaxdata; ?>>
								Order Totals <?= $salesordersdisplay->tablesorter->generate_sortsymbol('total_order'); ?>
							</a>
						</div>
						<div class="col text-right">
							<a href="<?= $salesordersdisplay->generate_tablesortbyurl("order_date") ; ?>" class="load-link text-white" <?= $salesordersdisplay->ajaxdata; ?>>
								Order Date <?= $salesordersdisplay->tablesorter->generate_sortsymbol('order_date'); ?>
							</a>
						</div>
					</div>
				</div>
				<?php foreach ($orders as $order) : ?>
					<?php
						if ($order->is_onreview()) {
							$class = "bg-danger text-white";
						} else {
							$class = "";
						}
					?>
					<a href="<?= $salesordersdisplay->generate_loaddetailsurl($order); ?>" class="list-group-item list-group-item-action <?= $class; ?>">
						<div class="row">
							<div class="col"><?= $order->ordernumber; ?></br></div>
							<div class="col"><?= $order->custid; ?></div>
							<div class="col">
								<?php $address = $order->shipto_address1.' '; ?>
								<?php $address .= (!empty($order->shipto_address2)) ? $order->shipto_address2 : ''; ?>
								<?php $address .= "<br>"; ?>
								<?php $address .= $order->shipto_city.", ". $order->shipto_state.' ' . $order->shipto_zip; ?>
								<?php if (!empty($order->shiptoid)) : ?>
									<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" data-html="true" title="<?= $address; ?>"><?= $order->shiptoid; ?></button>
								<?php endif; ?>
							</div>
							<div class="col text-right">$ <?= $order->total_order; ?></div>
							<div class="col text-right"><?= DplusDateTime::format_date($order->order_date); ?></div>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
			<div class="align-self-center"><?= $paginator; ?></div>
		</div>
		<a href="<?= $pages->get('/')->url; ?>" class="btn btn-primary my-1">
			<i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Go back to Account Page
		</a>
	</div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
