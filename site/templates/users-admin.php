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
					<h3 class="font-weight-bold border-bottom border-primary">Users</h3>
					<div class="list-group">
						<?php foreach ($users->find('template=user') as $user) : ?>
							<div class="list-group-item list-group-item-action">
								<?= $user->name; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col">
					<h3 class="font-weight-bold border-bottom border-primary">Programs</h3>
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
