<?php
    use Dplus\Base\DplusDateTime;

    $ordn = $input->get->text('ordn');
    $orderdisplay = new Dplus\Dpluso\OrderDisplays\SalesOrderDisplay(session_id(), $page->fullURL, '', $ordn);
    $order = $orderdisplay->get_order();
    $page->title = "Order #$ordn for ".Customer::get_customernamefromid($order->custid);;

    $customer = new Customer();

    $dplusdatetime = new DplusDateTime();

    $salesmngr = $user->hasRole($config->user_roles['sales-manager']['dplus-code']);
    $admin = $user->hasRole($config->user_roles['admin']['dplus-code']);

    $page->body = $config->twig->render('orders/order.twig', ['page' => $page, 'page_title' => $page->title, 'orderdisplay' => $orderdisplay, 'dplusdatetime' => $dplusdatetime, 'ordn' => $ordn, 'order' => $order, 'customer' => $customer, 'salesmngr' => $salesmngr, 'admin' => $admin]);
	include __DIR__ . "/basic-page.php";
?>
