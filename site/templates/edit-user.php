<?php
	$userID = $input->get->text('user');
	$edituser = $users->get("name=$userID");
	$edituser->of(false);
	$logmuser = LogmUser::load($userID);
	$programs = $pages->get('/config/programs/')->children();

	if ($input->requestMethod('POST')) {
		foreach ($programs as $program) {
			$programcode = get_processwireprogramcode($program->name);

			if (strtoupper($input->post->text($programcode)) == "Y") {
				if (!$edituser->hasRole($programcode)) {
					$edituser->addRole($programcode);
				}
			} else {
				if ($edituser->hasRole($programcode)) {
					$edituser->removeRole($programcode);
				}
			}
		}
		$edituser->save();
		$edituser->of(true);
	}

	$typecodes = get_customertypesforuser($userID);
    $customers = get_typecodescustomers($typecodes, $debug = false);

	$programnames = Array();
	foreach ($programs as $program) {
		$programnames[] = $program->name;
	}

	$typecodestoremove = array_diff($programnames, $typecodes);

	if ($typecodestoremove) {
		$customerstoremove = get_typecodescustomers($typecodestoremove, $debug = false);
		foreach ($customerstoremove as $customertoremove) {
			$custID = $customertoremove['custid'];
			if (does_userhavecustomer($userID, $custID)) {
				remove_usercustomer($userID, $custID, $debug = false);
			}
		}
	}

	$page->title = "Editing User $edituser->name";
	$dplusrole = $logmuser ? $config->user_roles[$logmuser->get_dplusorole()]['label'] : 'Not Found';
?>
<?php include('./_head.php'); // include header markup ?>
	<div class='container top-margin'>
		<div class="form-group">
			<h1 class="text-danger font-weight-bold border-bottom border-primary">
				<?= ucwords(strtolower($page->get('headline|title'))); ?>
			</h1>
		</div>
	</div>
	<div class="container page mt-2">
		<?php if ($user->hasRole('admin')) : ?>
			<form action="<?= $page->fullURL->getUrl(); ?>" method="post">
				<div class="row">
					<div class="col-4">
						<h5>User</h5>
						<div class="form-group mb-2">
							<input type="text" readonly class="form-control-plaintext" name="user" value="<?= $edituser->name; ?>">
						</div>
					</div>
					<div class="col-4">
						<h5>Role</h5>
						<?= $dplusrole; ?>
					</div>
					<div class="col-4">
						<h5>Programs</h5>
						<?php foreach ($programs as $program) : ?>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="<?= get_processwireprogramcode($program->name); ?>" value="Y" <?= $edituser->hasRole(get_processwireprogramcode($program->name)) ? 'checked' : ''; ?>>
								<label class="form-check-label">
									<?= $program->title; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<a href="<?= $page->child('name=edit-user-customers')->url."?user=$userID"; ?>" class="btn btn-warning">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit User Customers
				</a>
				<hr>
				<div class="row">
					<div class="col">
						<a href="<?= $page->parent->url; ?>" class="btn btn-primary">
							<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Users
						</a>
					</div>
					<div class="col">
						<button type="submit" class="btn btn-success float-right">
							<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
						</button>
					</div>
				</div>
			</form>
		<?php else : ?>
			<h3>You don't have permission to this function</h3>
		<?php endif; ?>
	</div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
