<?php include('./_head-blank.php'); ?>
	<div class="container page d-flex">
        <form method="POST" action="<?= $pages->get('template=account')->child('template=redir')->url(); ?>" class="form-signin text-center">
            <input type="hidden" name="action" value="login">
            <img class="mb-4 ml-5" src="<?= $site->company_logo->url; ?>" height="200" alt="">
            <?php if (!$user->loggedin) : ?>
				<?php $errormsg = get_loginerrormsg(session_id()); ?>
				<?php if (!empty($errormsg)) : ?>
					<div class="alert alert-danger alert-dismissible not-round" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Warning!</strong></br><?= $errormsg; ?>
					</div>
				<?php else : ?>
					<br>
				<?php endif; ?>
			<?php endif; ?>
            <div class="form-group">
                <label for="inputUsername" class="sr-only">Username</label>
                <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required="">
            </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted"><?= $site->company_name; ?> &copy; <?= date('Y'); ?></p>
        </form>
	</div>
	<!-- end content -->

<?php include('./_foot-blank.php'); ?>
