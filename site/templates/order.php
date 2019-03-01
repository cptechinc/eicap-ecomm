<?php
    use Dplus\Base\DplusDateTime;


    if ($input->get->ordn) {
        $ordn = $input->get->text('ordn');
        $orderdisplay = new Dplus\Dpluso\OrderDisplays\SalesOrderDisplay(session_id(), $page->fullURL, '', $ordn);

        if (SalesOrder::exists($ordn)) {
            $order = $orderdisplay->get_order();
            $customer = Customer::load($order, $custid);
            $page->title = "Order #$ordn for ".Customer::get_customernamefromid($order->custid);

            $dplusdatetime = new DplusDateTime();
            $salesmngr = $user->hasRole($config->user_roles['sales-manager']['dplus-code']);
            $admin = $user->hasRole($config->user_roles['admin']['dplus-code']);

            $page->body = $config->twig->render('orders/order.twig', ['page' => $page, 'page_title' => $page->title, 'orderdisplay' => $orderdisplay, 'dplusdatetime' => $dplusdatetime, 'ordn' => $ordn, 'order' => $order, 'customer' => $customer, 'salesmngr' => $salesmngr, 'admin' => $admin]);
        } else {
            $page->title = "Error: Order #$ordn could not be loaded";
            $msg = "Order #$ordn may not exist or an error occured during loading";
            $page->body = $config->twig->render('error-page.twig', ['title' => $page->title, 'msg' => $msg]);
        }
    } else {
        $page->title = "Error: Order # was not provided";
        $msg = "Order # was not provided";
        $page->body = $config->twig->render('error-page.twig', ['title' => $page->title, 'msg' => $msg]);
    }

	include __DIR__ . "/basic-page.php";
