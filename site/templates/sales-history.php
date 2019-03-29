<?php
	use Dplus\Base\DplusDateTime;
	use Dplus\Ecomm\SalesOrderHistoryDisplay;
	use Dplus\Content\PaginatorBootstrap4;

	$page->title = "Sales History";
	$salesordershistorydisplay = new SalesOrderHistoryDisplay(session_id(), $page->fullURL, $modal = '', $loadint = '', $ajax = false);
	$salesordershistorydisplay->set('pagenbr', $input->pageNum);
	$salesordershistorydisplay->generate_filter($input);
	$dplusdatetime = new DplusDateTime();

	if ($user->is_salesmanager()) {
		$filters = $salesordershistorydisplay->filters;
		$filters['salesperson'] = $user->get_programs_reps();
		$salesordershistorydisplay->set('filters', $filters);
	}

	$filters = $salesordershistorydisplay->filters;

	$salesordershistorydisplay->get_ordercount();
	$salesordershistorydisplay->set('paginationinsertafter', $page->name);
	$paginator = new PaginatorBootstrap4($salesordershistorydisplay->pagenbr, $salesordershistorydisplay->count, $salesordershistorydisplay->pageurl->getUrl(), $salesordershistorydisplay->paginationinsertafter, !empty($salesordershistorydisplay->ajaxdata) ? $salesordershistorydisplay->ajaxdata : '');

	$orders = $salesordershistorydisplay->get_orders();
	$page->body = $config->twig->render('sales-history/sales-history.twig', ['page' => $page, 'salesordershistorydisplay' => $salesordershistorydisplay, 'dplusdatetime' => $dplusdatetime, 'filters' => $filters, 'input' => $input, 'orders' => $orders, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
?>
