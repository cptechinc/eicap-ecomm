<?php
	$userID = $user->loginid; //TODO: better way of doing this
	$edituser = $users->get("name=$userID");
	$edituser->of(false);
	$logmuser = LogmUser::load($userID);
	$programs = $pages->get('/config/programs/')->children();

	$page->title = "Editing Customers for $userID";
	$dplusrole = $logmuser ? $config->user_roles[$logmuser->get_dplusorole()]['label'] : 'Not Found';

    $typecodes = get_customertypesforuser($userID);
    $customers = get_usercustomers($userID, $typecodes, $debug = false);
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
					<div class="col-3">
						<h5>User</h5>
						<div class="form-group mb-2">
							<input type="text" readonly class="form-control-plaintext" name="user" value="<?= $edituser->name; ?>">
						</div>
					</div>
                    <div class="col-3">
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
                    <div class="col-3">
						<h5>Current Customers</h5>
                        <div class="form-group">
                            <?php foreach ($customers as $customer) : ?>
							    <p><?= ucwords(strtolower($customer['name'])); ?></p>
                            <?php endforeach; ?>
                        </div>
					</div>
					<div class="col-3">
						<h5>Customers</h5>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="" value="Y" >
							<label class="form-check-label">
								Customer
							</label>
						</div>
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
