<?php
	// TODO: when you delete program from user, customers are still held in table, but do not display

	$userID = $input->get->text('user');
	$edituser = $users->get("name=$userID");
	$edituser->of(false);
	$logmuser = LogmUser::load($userID);

	$programs = $pages->get('/config/programs/')->children();
    $typecodes = get_customertypesforuser($userID);
    $customers = get_typecodescustomers($typecodes, $debug = false);

	if ($input->requestMethod('POST')) {
		foreach ($customers as $customer) {
			$custID = $customer['custid'];
			if (($input->post->text($custID)) == "Y") {
				if (!does_userhavecustomer($userID, $custID)) {
					add_usercustomer($userID, $custID, $debug = false);
				}
			} else {
				if (does_userhavecustomer($userID, $custID)) {
					remove_usercustomer($userID, $custID, $debug = false);
				}
			}
		}
		// $edituser->save();
		// $edituser->of(true);
	}

	$page->title = "Editing Customers for $userID";
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
                        <h5>Programs</h5>
                        <div class="form-group">
                            <?php foreach ($programs as $program) : ?>
                                <?php foreach ($typecodes as $typecode) : ?>
                                    <?php if ($typecode == $program->name) : ?>
                                        <p><?= $program->title; ?></p>
                                    <?php endif; ?>
        						<?php endforeach; ?>
    						<?php endforeach; ?>
                        </div>
					</div>
                    <div class="col-4">
						<h5>Customers</h5>
						<?php foreach ($customers as $customer) : ?>
							<?php $custID = $customer['custid']; ?>
	                        <div class="form-check">
								<input class="form-check-input" type="checkbox" name="<?= $custID; ?>" value="Y" <?= does_userhavecustomer($userID, $custID) ? 'checked' : ''; ?>>
							    <label class="form-check-label">
									<?= ucwords(strtolower($customer['name'])); ?>
								</label>
	                        </div>
						<?php endforeach; ?>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col">
						<a href="<?= $page->parent->url."?user=$userID"; ?>" class="btn btn-primary">
							<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Edit User
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
