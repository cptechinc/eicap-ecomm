
<?php
	$ordn = $input->get->text('ordn');
	$editorderdisplay = new Dplus\Dpluso\OrderDisplays\EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn);
	$order = $editorderdisplay->get_order();
	$page->title = "Editing Order # $ordn for ".Customer::get_customernamefromid($order->custid);

	$page->body = $config->twig->render('orders/edit-order.twig', ['page' => $page, 'page_title' => $page->title, 'editorderdisplay' => $editorderdisplay, 'ordn' => $ordn, 'order' => $order]);
	include __DIR__ . "/basic-page.php";
?>
