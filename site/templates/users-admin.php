<?php import_logmintoprocesswire(); ?>

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
			<div class="mb-3">
				<a href="<?= $page->parent->url; ?>" class="btn btn-primary">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to App Settings
				</a>
			</div>
			<div class="list-group">
				<?php foreach ($users->find('template=user, name!=guest') as $appuser) : ?>
					<div class="list-group-item list-group-item-action">
						<h4><?= $appuser->name; ?></h4>
						<?php
							$logmuser = LogmUser::load($appuser->name);
							$programs = get_customertypesforuser($appuser->name);
							$dplusrole = $logmuser ? $config->user_roles[$logmuser->get_dplusorole()]['label'] : 'Not Found';
						?>
						<div class="row">
							<div class="col-4">
								<b>Role:</b> <?= $dplusrole; ?>
							</div>
							<div class="col-4">
								<b>Programs:</b> <?= implode(', ', $programs); ?>
							</div>
							<div class="col-4">
								<a href="<?= $page->child('name=edit-user')->url."?user=$appuser->name"; ?>" class="btn btn-warning">
									<i class="fa fa-pencil" aria-hidden="true"></i> Edit User 
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<h3>You don't have permission to this function</h3>
		<?php endif; ?>
	</div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
