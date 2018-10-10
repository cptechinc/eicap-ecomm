<?php include('./_head.php'); // include header markup ?>

	<div class="container page">
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger">Welcome back, <?= $user->fullname; ?>!</h1>
			</div>
		</div>
		<div class="row bg-primary rounded">
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/account/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-address-card fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Profile</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/orders/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-list-alt fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Past Orders</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/cart/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Cart</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/add-vendor/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Add New Vendor</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 my-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/add-item/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Add New Item</p>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); // include footer markup ?>
