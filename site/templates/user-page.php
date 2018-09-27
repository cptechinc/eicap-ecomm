<?php include('./_head.php'); ?>

	<div class='container page'>
		<div class="row mt-5 mb-1">
			<div class="col-sm-12">
				<h1 class="font-weight-bold text-danger">Your Account</h1>
			</div>
		</div>
		<div class="row bg-primary rounded">
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="<?= $pages->get('/user/account/')->url; ?>">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-address-card fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text text-center text-danger">Profile</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="#">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-list-alt fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text text-center text-danger">Past Orders</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 mt-3">
				<div class="card bg-white">
					<a href="#">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text text-center text-danger">Addresses</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col-sm-4 mt-3 mb-3">
				<div class="card bg-white">
					<a href="#">
						<div class="card-body">
							<h1 class="text-center text-danger"><i class="fa fa-credit-card fa-2x" aria-hidden="true"></i></h1>
							<p class="card-text text-center text-danger">Payments</p>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end content -->

<?php include('./_foot.php'); ?>
