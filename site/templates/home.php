<?php include('./_head.php'); // include header markup ?>
	<div class="container page">
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger">Welcome back, <?= $user->fullname; ?>!</h1>
			</div>
		</div>
		<div class="row bg-primary rounded">
			<div class="col-sm-3 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/products/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-database fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Products</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-3 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/customers/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-user fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Customers</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-3 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/orders/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-list-alt fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Open Orders</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-3 my-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/cart/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text font-weight-bold text-center text-danger">Cart</p>
						</div>
					</a>
				</div>
			</div>
			<?php if ($user->hasRole('admin')) : ?>
				<div class="col-sm-3 my-3">
					<div class="card bg-white">
						<a href="<?= $pages->get('template=build-items')->url; ?>">
							<div class="card-body">
								<h1 class="text-center text-danger"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></h1>
								<p class="card-text font-weight-bold text-center text-danger">Rebuild Items</p>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-3 my-3">
					<div class="card bg-white">
						<a href="<?php $pages->get('template=build-items')->url; ?>">
							<div class="card-body">
								<h1 class="text-center text-danger"><i class="fa fa-users fa-2x" aria-hidden="true"></i></h1>
								<p class="card-text font-weight-bold text-center text-danger">User Admininstration</p>
							</div>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); // include footer markup ?>
