<?php
    use Dplus\Base\DplusDateTime;

    $ordn = $input->get->text('ordn');
    $orderdisplay = new Dplus\Dpluso\OrderDisplays\SalesOrderDisplay(session_id(), $page->fullURL, '', $ordn);
    $order = $orderdisplay->get_order();
    $page->title = "Order #$ordn";
?>
<?php include('./_head.php'); // include header markup ?>
	<div class="container page top-margin">
		<h1 class="text-danger font-weight-bold border-bottom border-primary"><?= $page->title; ?></h1>
        <?php if ($order->is_onreview()) : ?>
            <div class="alert alert-danger" role="alert">
                <strong><i class="fa fa-warning" aria-hidden="true"></i>&nbsp;Pending Order!</strong>&nbsp;&nbsp;This order will be processed once it is approved.
            </div>
        <?php endif; ?>
        <h5 class="font-weight-bold">Ordered on <?= DplusDateTime::format_date($order->order_date); ?></h5>
        
        <a href="<?= $page->parent->url; ?>" class="btn btn-primary mt-3">
            <i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Back to Orders Page
        </a>

        <div class="row mt-4">
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Billing</legend>
                <?php $customer = Customer::load($order->custid); ?>
                <address>
                    <?= $customer->name; ?> (<?= $order->custid; ?>)<br>
                    <?= $customer->addr1; ?><br>
                    <?= !empty($customer->addr2) ? $customer->addr2."<br>" : ''; ?>
                    <?= "$customer->city, $customer->state $customer->zip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Shipping</legend>
                <address>
                    <?= $order->shipto_name." ($order->shiptoid)"; ?><br>
                    <?= $order->shipto_address1; ?><br>
                    <?= !empty($order->shipto_address2) ? $order->shipto_address2."<br>" : ''; ?>
                    <?= "$order->shipto_city, $order->shipto_state $order->shipto_zip"; ?>
                </address>
            </div>
            <div class="col-sm-4">
                <legend class="font-weight-bold text-danger">Order Summary</legend>
                <div class="row">
                    <div class="col-sm-7">Subtotal:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->subtotal_nontax); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Shipping:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->total_freight); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Tax:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->total_tax); ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-7">Total:</div>
                    <div class="col-sm-5 text-right">$ <?= $page->stringerbell->format_money($order->total_order); ?></div>
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
                <?php $details = $orderdisplay->get_orderdetails($order); ?>
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
        <div class="pb-5">
            <div class="row">
                <div class="col-sm-10 text-right">Subtotal:</div>
                <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->subtotal_nontax); ?></div>
            </div>
            <div class="row">
                <div class="col-sm-10 text-right">Shipping:</div>
                <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->total_freight); ?></div>
            </div>
            <div class="row">
                <div class="col-sm-10 text-right">Tax:</div>
                <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->total_tax); ?></div>
            </div>
            <div class="row font-weight-bold">
                <div class="col-sm-10 text-right">Total:</div>
                <div class="col-sm-2 text-right">$ <?= $page->stringerbell->format_money($order->total_order); ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="<?= $page->parent->url; ?>" class="btn btn-primary">
                    <i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Back to Orders Page
                </a>
            </div>
            <?php if ($user->hasRole($config->user_roles['sales-manager']['dplus-code'])) : ?>
                <div class="col">
                    <?php if ($order->can_editapproved()) : ?>
                        <a href="#" class="btn btn-warning float-right">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Approve Sales Order
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="col">
                <?php if ($order->can_editapproved()) : ?>
                    <a href="<?= $orderdisplay->generate_editurl($order); ?>" class="btn btn-warning float-right">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit Sales Order
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
