<?php
    $ordn = $input->get->text('ordn');
    $editorderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '', $ordn);
    $order = $editorderdisplay->get_order();
    $page->title = "Order #$ordn";
?>
<?php include('./_head.php'); // include header markup ?>
	<div class="container page top-margin">
		<h1 class="text-danger font-weight-bold border-bottom border-danger"><?= $page->title; ?></h1>
        <div class="alert alert-danger" role="alert">
            <strong><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;Pending Order!</strong>&nbsp;&nbsp;This order will be processed once it is approved.
        </div>
        <h5 class="font-weight-bold">Ordered on <?= $order->orderdate; ?></h5>

        <div class="row mt-4">
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Billing</legend>
                <address>
                    <?= $order->custname; ?> (<?= $order->custid; ?>)<br>
                    <?= $order->billaddress; ?><br>
                    <?= !empty($order->billaddress2) ? $order->billaddress2."<br>" : ''; ?>
                    <?= "$order->billcity, $order->billstate $order->billzip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Shipping</legend>
                <address>
                    <?= $order->shipname." ($order->shiptoid)"; ?><br>
                    <?= $order->shipaddress; ?><br>
                    <?= !empty($order->shipaddress2) ? $order->shipaddress2."<br>" : ''; ?>
                    <?= "$order->shipcity, $order->billstate $order->shipzip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Order Summary</legend>
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

        <h3 class="font-weight-bold text-danger mt-4">Order Details</h3>
        <table class="table table-striped table-borderless">
				<thead class="bg-secondary text-white font-weight-bold">
                    <div class="row">
                        <th class="col-sm-7">Item ID</th>
    					<th class="col-sm-1 text-right">Qty</th>
    					<th class="col-sm-2 text-right">Price</th>
                        <th class="col-sm-2 text-right">Total Price</th>
                    </div>
				</thead>
                <?php $details = $editorderdisplay->get_orderdetails($order); ?>
                <?php foreach ($details as $detail) : ?>
                <tr>
                    <td class="col-sm-7">
                        <?= $detail->itemid; ?></br>
                        <small><?= $detail->desc1; ?></small>
                    </td>
                    <td class="col-sm-1 text-right"><?= number_format($detail->qty, 0); ?></td>
                    <td class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
                    <td class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
        <div class="row">
            <div class="col-sm-10 text-right">Subtotal:</div>
            <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->subtotal); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-10 text-right">Shipping:</div>
            <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->freight); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-10 text-right">Tax:</div>
            <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->salestax); ?></div>
        </div>
        <div class="row font-weight-bold">
            <div class="col-sm-10 text-right">Total:</div>
            <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->ordertotal); ?></div>
        </div>
        <a href="<?= $page->parent->url; ?>" class="btn btn-primary mt-3"><i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Back to Orders Page</a>
    </div>

	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
