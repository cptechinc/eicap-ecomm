<?php 
    $ordn = $input->get->text('ordn');
    $editorderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '', $ordn);
    $order = $editorderdisplay->get_order();
    $page->title = "Order #$ordn";
?>
<?php include('./_head.php'); // include header markup ?>
	<div class="container page top-margin">
		<h1 class="text-danger font-weight-bold"><?= $page->title; ?></h1>
        <h6>Ordered on <?= $order->orderdate; ?></h6>
        <div class="row">
            <div class="col-sm-4">
                <legend>Billing</legend>
                <address>
                    <?= $order->custname; ?> (<?= $order->custid; ?>)<br>
                    <?= $order->billaddress; ?><br>
                    <?= !empty($order->billaddress2) ? $order->billaddress2."<br>" : ''; ?>
                    <?= "$order->billcity, $order->billstate $order->billzip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend>Shipping</legend>
                <address>
                    <?= $order->shipname." ($order->shiptoid)"; ?><br>
                    <?= $order->shipaddress; ?><br>
                    <?= !empty($order->shipaddress2) ? $order->shipaddress2."<br>" : ''; ?>
                    <?= "$order->shipcity, $order->billstate $order->shipzip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend>Order Summary</legend>
                <div class="row">
                    <div class="col-sm-7">Subtotal:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->subtotal); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Shipping:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->freight); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Tax:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->salestax); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Total:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->ordertotal); ?></div>
                </div>
            </div>
        </div>
        <h3>Order Details</h3>
        <div class="row">
            
        </div>
    </div>
    
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
