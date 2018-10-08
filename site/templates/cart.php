<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row">
			<div class="col-sm-12 mt-5">
                <?php echo "<h1 class='text-danger font-weight-bold border-bottom border-primary'>" . ucwords(strtolower($page->get('headline|title'))) . "</h1>"; ?>
            </div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-responsive">
					<thead>
						<th>Image</th>
						<th>ItemID</th>
						<th>Description</th>
						<th>Qty</th>
						<th>Edit</th>
                        <th>Remove</th>
					</thead>
					<tbody>
						<tr>
							<form class="" action="" method="post">
								<td class="col-sm-3"><img class="card-img-top" src="<?= $child->product_image->url; ?>" alt="IMG TEXT"></td>
								<td class="col-sm-2">1234</td>
								<td class="col-sm-5"><a href="<?= $child->url; ?>">Random Item Name</a></td>
								<td class="col-sm-1">
									<input class="form-control" type="text" name="qty" size="4" value="5">
								</td>
								<td class="col-sm-1">
									<button class="btn btn-primary" type="button" name="button">Edit</button>
								</td>
                                <td class="col-sm-1">
									<button class="btn btn-danger" type="button" name="button">Remove</button>
								</td>
							</form>
						</tr>
                        <tr>
							<form class="" action="" method="post">
								<td class="col-sm-3"><img class="card-img-top" src="<?= $child->product_image->url; ?>" alt="IMG TEXT"></td>
								<td class="col-sm-2">1234</td>
								<td class="col-sm-4"><a href="<?= $child->url; ?>">Random Item Name</a></td>
								<td class="col-sm-1">
									<input class="form-control" type="text" name="qty" size="4" value="5">
								</td>
								<td class="col-sm-1">
									<button class="btn btn-primary" type="button" name="button">Edit</button>
								</td>
                                <td class="col-sm-1">
									<button class="btn btn-danger" type="button" name="button">Remove</button>
								</td>
							</form>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
        <a href="" class="btn btn-primary">Send for Review</a>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
