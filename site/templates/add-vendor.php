<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger border-bottom border-primary mb-3">Add New Vendor</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="card border-primary">
					<div class="card-header">
						<h4 class="text-primary">Vendor Information</h4>
					</div>
					<div class="card-body">
						<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
							<table class="table-borderless table-sm">
								<tr>
									<td>Vendor:</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
									<td>Address:</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>

								<tr>
									<td class="control-label">Name</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
									<td class="control-label">Title:</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
									<td class="control-label">Email</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
								<td class="control-label">Office Phone</td>
								<td>
									<div class="row">
										<div class="col-sm-8">
											<div class="input-group input-group-sm">
											  <input type="text" class="form-control">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group input-group-sm">
											  <input type="text" class="form-control">
											</div>
										</div>
									</div>
								</td>
								</tr>
								<tr>
									<td class="control-label">Cell Phone</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
								<tr>
									<td class="control-label">Fax</td>
									<td>
										<div class="input-group input-group-sm">
										  <input type="text" class="form-control">
										</div>
									</td>
								</tr>
							</table>
							<button type="submit" class="btn btn-primary btn-block pull-right mt-5">Save</button>
						</form>
					</div>
				</div>
                <a href="<?= $pages->get('/')->url; ?>" class="btn btn-primary mt-3">Go back to Account Page</a>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
