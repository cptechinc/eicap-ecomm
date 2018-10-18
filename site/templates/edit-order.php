
<?php 
	$ordn = $input->get->text('ordn'); 
	$editorderdisplay = new Dplus\Dpluso\OrderDisplays\EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn);
	$order = $editorderdisplay->get_order();
	$page->title = "Editing Order # $ordn for ".Customer::get_customernamefromid($order->custid);
	
	include('./_head.php');
?>
<div class="container page top-margin">
	<div class="form-group">
		<h1 class="text-danger font-weight-bold border-bottom border-primary"><?= ucwords(strtolower($page->get('headline|title'))); ?></h1>
	</div>
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

	<div class="list-group mt-3">
		<div class="list-group-item list-group-item-action bg-secondary text-white font-weight-bold">
			<div class="row">
				<div class="col">Item / Description</div>
				<div class="col text-right">Qty</div>
				<div class="col text-right">Price</div>
				<div class="col text-right">Total</div>
				<div class="col text-right">Edit / Remove</div>
			</div>
		</div>
		<?php $order_details = $editorderdisplay->get_orderdetails($order); ?>
		<?php foreach ($order_details as $detail) : ?>
			<form action="<?= $config->pages->orders.'redir/'; ?>" method="post" class="">
				<input type="hidden" name="action" value="quick-update-line">
				<input type="hidden" name="ordn" value="<?= $ordn; ?>">
				<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
				<div class="list-group-item list-group-item-action">
					<div class="row">
						<div class="col-12 col-sm">
							<?= $detail->itemid; ?><br>
							<small><?= $detail->desc1; ?></small>
						</div>
						<div class="col-6 col-sm text-right">
							<div class="d-sm-none"><b>Price</b></div>
							<br>
							$ <?= $page->stringerbell->format_money($detail->price); ?>
						</div>
						<div class="col-6 col-sm text-right">
							<div class="d-sm-none"><b>Qty</b></div>
							<br>
							<input class="form-control pull-right text-right qty" type="text" name="qty" size="4" value="<?= number_format($detail->qty, 0); ?>">
						</div>
						<div class="col-6 col-sm text-right">
							<div class="d-sm-none"><b>Item Total</b></div>
							<br>
							$ <?= $page->stringerbell->format_money($detail->price * $detail->qty); ?>
						</div>
						<div class="col-12 col-sm text-right">
							<br>
							<button type="submit" class="btn btn-success save-button" title="Save Changes">
								<span class="fa fa-floppy-o"></span> <span class="sr-only">Save Line</span>
							</button>
							<a href="<?= $editorderdisplay->generate_deletedetailurl($order, $detail); ?>" class='btn btn-danger'>
								<i class="fa fa-trash"></i> <span class="sr-only">Delete Line</span>
							</a>
						</div>
					</div>
				</div>
			</form>
		<?php endforeach; ?>
		<div class="list-group-item bg-light">
			<div class="row">
				<div class="col-12 col-sm"></div>
				<div class="col-6 col-sm text-right"></div>
				<div class="col-6 col-sm text-right"></div>
				<div class="col-6 col-sm text-right">
					<div class="d-sm-none"><b>Order Total</b></div>
					<br>
					<strong>Order Total:&emsp;$ <?= $page->stringerbell->format_money($order->subtotal); ?></strong>
				</div>
				<div class="col-12 col-sm text-right"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<a href="<?= $editorderdisplay->generate_unlockurl($order); ?>" class="btn btn-block btn-success mt-3" data-type="order">
					Save and Exit &nbsp;&nbsp;<i class="fa fa-floppy-o" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<?php include('./_foot.php'); ?>
