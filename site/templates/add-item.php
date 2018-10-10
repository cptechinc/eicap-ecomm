<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger border-bottom border-primary mb-3">Add New Item</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="card border-primary">
					<div class="card-header">
						<h4 class="text-primary">Item Information</h4>
					</div>
					<div class="card-body">
						<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
							<table class="table-borderless table-sm">
								<tr>
									<td>Item ID:</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
									<td>Item Description:</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>

								<tr>
									<td class="control-label">Price</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
                                <tr>
                                    <td class="control-label">Example file input</td>
                                    <td><input type="file" class="form-control-file" id="exampleFormControlFile1"></td>
                                </tr>
							</table>
							<button type="submit" class="btn btn-primary btn-block pull-right mt-5">Save Changes</button>
						</form>
					</div>
				</div>
                <a href="<?= $pages->get('/')->url; ?>" class="btn btn-primary mt-3"><i class="fa fa-arrow-circle-left text-white" aria-hidden="true"></i>&nbsp;&nbsp;Go back to Account Page</a>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
