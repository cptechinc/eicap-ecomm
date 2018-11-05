<?php
	if ($input->requestMethod('POST')) {
		$programcode = $input->post->text('program-code');
		$programtitle = $input->post->text('program-title');
		
		if (does_programexist($programcode)) {
			$success = false;
		} else {
			$success = add_program($programcode, $programtitle);
		}
	}
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
			<div class="mb-3">
				<a href="<?= $page->parent->url; ?>" class="btn btn-primary">
					<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Programs
				</a>
			</div>
			<?php if ($input->requestMethod('POST')) : ?>
				<?php if ($success) : ?>
					<div class="alert alert-success" role="alert">
						<h4 class="alert-heading">Success</h4>
						<p><?= $programtitle . " ($programcode) was added"; ?></p>
					</div>
				<?php else : ?>
					<div class="alert alert-danger" role="alert">
						<h4 class="alert-heading">Error!</h4>
						<p><?= $programtitle . " ($programcode) was not added"; ?></p>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<form action="<?= $page->fullURL->getUrl(); ?>" method="post">
				<div class="row">
					<div class="col-4">
						<h5>Program Code</h5>
						<div class="form-group">
							<input type="text" class="form-control" name="program-code" value="">
						</div>
					</div>
					<div class="col-4">
						<h5>Program Title</h5>
						<div class="form-group">
							<input type="text" class="form-control" name="program-title" value="">
						</div>
					</div>
					<div class="col-4">
						<h5>&nbsp;</h5>
						<button type="submit" class="btn btn-success float-right">
							<i class="fa fa-floppy-o" aria-hidden="true"></i> Add
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
