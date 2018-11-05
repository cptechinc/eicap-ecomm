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
			<div class="row mb-3">
				<div class="col">
					<a href="<?= $page->parent->url; ?>" class="btn btn-primary">
						<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to App Settings
					</a>
				</div>
				<div class="col">
					<a href="<?= $page->child('name=add')->url; ?>" class="btn btn-success float-right">
						<i class="fa fa-plus" aria-hidden="true"></i> Add Program
					</a>
				</div>
			</div>
			<div class="list-group">
				<?php foreach ($roles->find('name*=program-') as $program) : ?>
					<?php $programID = str_replace('program-', '', $program->name); ?>
					<div class="list-group-item list-group-item-action">
						<h4><?= $pages->get('/config/programs/')->child("name=$programID")->title; ?> (<?= $programID; ?>)</h4>
						<h5><?= $program->name; ?></h5>
						
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<h3>You don't have permission to this function</h3>
		<?php endif; ?>
	</div>
	<!-- end content -->
<?php include('./_foot.php'); // include footer markup ?>
