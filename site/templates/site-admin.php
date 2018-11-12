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
			<div class="row">
				<div class="col">
					<div class="border-bottom border-primary mb-3">
						<span class="h3 font-weight-bold ">Users</span>
						<span class="float-right"><a href="<?= $page->child('name=users-admin')->url; ?>">View Menu</a></span>
					</div>
					<table class="table">
						<thead>
							<tr>
								<th>User</th> <th>Program</th> <th>Role</th>
							</tr>
						</thead>
						<?php foreach ($users->find('template=user, name!=guest|apache') as $user) : ?>
							<?php
								$logmuser = LogmUser::load($user->name);
								$programs = get_customertypesforuser($user->name);
								$dplusrole = $logmuser ? $config->user_roles[$logmuser->get_dplusorole()]['label'] : 'Unknown Logm User';
								
								if (!$logmuser) {
									$rowclass = 'bg-warning';
								} else {
									$rowclass = '';
								}
							?>
							<tr  class="<?= $rowclass; ?>">
								<td><?= $user->name; ?></td>
								<td><?= implode(', ', $programs); ?></td>
								<td><?= $dplusrole; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="col">
					<div class="border-bottom border-primary mb-3">
						<span class="h3 font-weight-bold">Programs</span>
						<span class="float-right"><a href="<?= $page->child('name=programs')->url; ?>">View Menu</a></span>
					</div>
					<div class="list-group">
						<?php foreach ($pages->get('/config/programs/')->children() as $program) : ?>
							<div class="list-group-item list-group-item-action">
								<?= $program->title; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php else : ?>
			<h3>You don't have permission to this function</h3>
		<?php endif; ?>
	</div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
