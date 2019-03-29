<?php
    use Dplus\Base\DplusDateTime;

    if ($input->get->ordn) {
        $ordn = $input->get->text('ordn');
        $orderhistorydisplay = new Dplus\Ecomm\SalesOrderHistoryDisplay(session_id(), $page->fullURL, '', $ordn);

        if (SalesOrderHistory::is_saleshistory($ordn)) {
            $order = $orderhistorydisplay->get_order();
            $customer = Customer::load($order->custid, $order->shiptoid);
            $page->title = "Order #$ordn for $customer->name";

            $dplusdatetime = new DplusDateTime();

            $page->body = $config->twig->render('sales-history/history-order.twig', ['page' => $page, 'orderhistorydisplay' => $orderhistorydisplay, 'dplusdatetime' => $dplusdatetime, 'order' => $order, 'customer' => $customer]);
        } else {
            $page->title = "Error: Order #$ordn could not be loaded";
            $msg = "Order #$ordn may not exist or an error occured during loading";
            $page->body = $config->twig->render('common/error-page.twig', ['title' => $page->title, 'msg' => $msg]);
        }
    } else {
        $page->title = "Error: Order # was not provided";
        $msg = "Order # was not provided";
        $page->body = $config->twig->render('common/error-page.twig', ['title' => $page->title, 'msg' => $msg]);
    }

	include __DIR__ . "/basic-page.php";
