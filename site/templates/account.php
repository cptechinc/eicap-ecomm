<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger border-bottom border-primary">Your Profile</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-sm">
					<tr>
						<td class="control-label">Customer:</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Address:</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Name:</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Title:</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Email</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Office Phone</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Cell Phone</td>
						<td></td>
					</tr>
					<tr>
						<td class="control-label">Fax</td>
						<td></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-6">
				<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
					<input type="hidden" name="action" value="edit-contact">
					<input type="hidden" name="custID" value="<?= $contact->custid; ?>">
					<input type="hidden" name="shipID" value="<?= $contact->shiptoid; ?>">
					<input type="hidden" name="contactID" value="<?= $contact->contact; ?>">
					<input type="hidden" name="page" value="<?= $page->fullURL; ?>">
					<table class="table table-sm">
						<tr>
							<td>Customer:</td>
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
					<div class="panel-footer">
						<button type="submit" class="btn btn-primary">Save Changes</button>
					</div> <!-- end panel footer -->
				</form>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
