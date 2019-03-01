
<?php
	$ordn = $input->get->text('ordn');
	$editorderdisplay = new Dplus\Dpluso\OrderDisplays\EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn);
	$order = $editorderdisplay->get_order();
	$page->title = "Editing Order # $ordn for ".Customer::get_customernamefromid($order->custid);

	$searchitems = $pages->get('/products/search/')->url.'?ordn=';
	$ordersredir = $config->pages->orders.'redir/';

	$page->body = $config->twig->render('orders/edit-order.twig', ['page' => $page, 'page_title' => $page->title, 'editorderdisplay' => $editorderdisplay, 'ordn' => $ordn, 'order' => $order, 'searchitems' => $searchitems, 'ordersredir' => $ordersredir]);
	include __DIR__ . "/basic-page.php";
?>
