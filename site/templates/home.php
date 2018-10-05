<?php include('./_head.php'); // include header markup ?>

<div class="jumbotron page-banner" style="background: url('<?= $page->pagebanner->url; ?>'); background-size: cover;"></div>
	<div class="container page">
		<h1 class="text-danger font-weight-bold">Welcome back, <?= $user->fullname; ?>!</h1>
		<div class="row mt-4">
			<a href="#" class="col-sm-4">
				<div class="card bg-primary">
				    <div class="card-body">
				    	<h5 class="card-title text-center"><i class="fa fa-cart-plus fa-5x text-white" aria-hidden="true"></i></h5>
				    	<p class="card-text text-center text-white">Create New Order</p>
				  	</div>
				</div>
			</a>
			<a href="<?= $pages->get('/user/orders/')->url; ?>" class="col-sm-4">
				<div class="card bg-primary">
				    <div class="card-body">
				    	<h5 class="card-title text-center"><i class="fa fa-list-alt fa-5x text-white" aria-hidden="true"></i></h5>
				    	<p class="card-text text-center text-white">Past Orders</p>
				  	</div>
				</div>
			</a>
			<a href="<?= $pages->get('/user/')->url; ?>" class="col-sm-4">
				<div class="card bg-primary">
				    <div class="card-body">
				    	<h5 class="card-title text-center"><i class="fa fa-user fa-5x text-white" aria-hidden="true"></i></h5>
				    	<p class="card-text text-center text-white">Your Account</p>
				  	</div>
				</div>
			</a>
		</div>
		<div class="row mt-4">
			<div class="col-sm-12">
				<h3 class="text-danger font-weight-bold"><?= $page->summary; ?></h3>
				<p><?= $page->body; ?></p>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); // include footer markup ?>
