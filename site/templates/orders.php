<?php
	use Dplus\Base\DplusDateTime;
	use Dplus\Ecomm\SalesOrdersDisplay;
	use Dplus\Content\PaginatorBootstrap4;

	$page->title = "Sales Orders";
	$salesordersdisplay = new SalesOrdersDisplay(session_id(), $page->fullURL, $modal = '', $loadint = '', $ajax = false);
	$salesordersdisplay->set('pagenbr', $input->pageNum);
	$salesordersdisplay->generate_filter($input);

	$dplusdatetime = new DplusDateTime();

	if ($user->is_salesmanager()) {
		$filters = $salesordersdisplay->filters;
		$filters['salesperson'] = $user->get_programs_reps();
		$salesordersdisplay->set('filters', $filters);
	}

	$filters = $salesordersdisplay->filters;
	$input = $input->get->filter;

	$salesordersdisplay->get_ordercount();
	$salesordersdisplay->set('paginationinsertafter', $page->name);
	$paginator = new PaginatorBootstrap4($salesordersdisplay->pagenbr, $salesordersdisplay->count, $salesordersdisplay->pageurl->getUrl(), $salesordersdisplay->paginationinsertafter, !empty($salesordersdisplay->ajaxdata) ? $salesordersdisplay->ajaxdata : '');

	$orders = $salesordersdisplay->get_orders();

	$page->body = $config->twig->render('orders/orders.twig', ['page' => $page, 'pages' => $pages, 'salesordersdisplay' => $salesordersdisplay, 'dplusdatetime' => $dplusdatetime, 'filters' => $filters, 'input' => $input, 'orders' => $orders, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
?>
