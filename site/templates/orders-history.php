<?php
	use Dplus\Base\DplusDateTime;
	use Dplus\Dpluso\OrderDisplays\SalesOrderHistoryPanel;
	use Dplus\Content\PaginatorBootstrap4;

	$page->title = "Sales Orders History";
	$salesordershistorydisplay = new SalesOrderHistoryPanel(session_id(), $page->fullURL, $modal = '', $loadint = '', $ajax = false);
	$salesordershistorydisplay->set('pagenbr', $input->pageNum);
	$salesordershistorydisplay->generate_filter($input);

	$dplusdatetime = new DplusDateTime();

	if ($user->is_salesmanager()) {
		$filters = $salesordershistorydisplay->filters;
		$filters['salesperson'] = $user->get_programs_reps();
		$salesordershistorydisplay->set('filters', $filters);
	}

	$filters = $salesordershistorydisplay->filters;
	$input = $input->get->filter;

	$salesordershistorydisplay->get_ordercount();
	$salesordershistorydisplay->set('paginationinsertafter', $page->name);
	$paginator = new PaginatorBootstrap4($salesordershistorydisplay->pagenbr, $salesordershistorydisplay->count, $page->fullURL, $salesordershistorydisplay->paginationinsertafter, !empty($salesordershistorydisplay->ajaxdata) ? $salesordershistorydisplay->ajaxdata : '');

	$orders = $salesordershistorydisplay->get_orders();

	$page->body = $config->twig->render('orders-history/orders-history.twig', ['page' => $page, 'pages' => $pages, 'salesordershistorydisplay' => $salesordershistorydisplay, 'dplusdatetime' => $dplusdatetime, 'filters' => $filters, 'input' => $input, 'orders' => $orders, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
?>
