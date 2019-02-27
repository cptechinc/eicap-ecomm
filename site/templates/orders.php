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

	$page->body = $config->twig->render('orders/orders.twig', ['page' => $page, 'salesordersdisplay' => $salesordersdisplay, 'filters' => $filters, 'orders' => $orders, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
?>
