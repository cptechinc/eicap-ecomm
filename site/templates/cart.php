<?php $cartdisplay = new CartDisplay(session_id(), $page->fullURL, ''); ?>
<?php $cart = $cartdisplay->get_cartquote(); ?>
<?php include('./_head.php'); ?>

	<div class='container page'>

		<div class="row">
			<div class="col-sm-12 mt-5">
                <h1 class="font-weight-bold text-danger">Cart</h1>
            </div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-borderless">
					<thead class="bg-secondary text-white font-weight-bold">
						<th>Image</th>
						<th>ItemID</th>
						<th>Qty</th>
						<th class="text-right">Price</th>
						<th class="text-right">Total</th>
						<th class="text-right">Edit / Remove</th>
					</thead>
					<tbody>
						<?php $details = get_cartdetails(session_id()); ?>
						<?php foreach ($details as $detail) : ?>
							<tr>
								<form class="" action="<?= $config->pages->root.'dplus-ecomm/cart/redir/'; ?>" method="post">
									<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
									<td class="col-sm-3"><img class="card-img-top" src="" alt="IMG TEXT"></td>
									<td class="col-sm-4">
										<?= $detail->itemid; ?></br>
										<small><?= $detail->desc1; ?></small>
									</td>
									<td class="col-sm-1">
										<input class="form-control" type="text" name="qty" size="4" value="<?= number_format($detail->qty, 0); ?>">
									</td>
									<td class="col-sm-1 text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
									<td class="col-sm-1 text-right">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></td>
									<td class="col-sm-2 text-right">
										<button class="btn btn-primary" type="button" name="button"><i class="fa fa-save text-white" aria-hidden="true"></i></button>
										<a href="<?= $cartdisplay->generate_detaildeleteurl($cart, $detail); ?>" class="btn btn-danger detail-line-icon">
											<i class="fa fa-trash text-white" aria-hidden="true"></i>
										</a>
									</td>
								</form>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
		<a href="" class="btn btn-success mt-3">Submit for Review&nbsp;&nbsp;<i class="fa fa-arrow-circle-right text-white" aria-hidden="true"></i></a></br>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
