<?php include('./_head.php'); // include header markup ?>

<div class="container page">
    <h2 class="font-weight-bold text-center my-4"><?= $page->headline; ?></h2>
	<div class="row">
		<div class="col-md-3">
			<h5 class="font-weight-bold"><i class="fa fa-home" aria-hidden="true"></i>&ensp;Address</h5>
				<p><?= $site->company_address; ?></p>
				</br>
			<h5 class="font-weight-bold"><i class="fa fa-phone" aria-hidden="true"></i>&ensp;Phone</h5>
				<p><a href="tel:+<?= $site->company_phone; ?>"><?= $site->company_phone; ?></a></p>
				</br>
            <h5 class="font-weight-bold"><i class="fa fa-envelope-o" aria-hidden="true"></i>&ensp;Email</h5>
				<p><a href="mailto:<?= $site->company_email; ?>"><?= $site->company_email; ?></a></p>
				</br>
		</div>
		<div class="col-md-3">
			<h5 class="font-weight-bold"><i class="fa fa-clock-o" aria-hidden="true"></i>&ensp;Hours</h5>
				<p><?= $site->company_hours; ?></p>
				</br>
		</div>
		<div class="col-md-6">
			<form action="" method="">
                <p><?= $page->body; ?></p>
				<div class="form-group">
					<!-- <label for="name">Name</label> -->
					<input type="text" class="form-control" id="name" placeholder="Name">
				</div>
				<div class="form-group">
					<!-- <label for="email">Email</label> -->
					<input type="email" class="form-control" id="email" placeholder="Email">
				</div>
				<div class="form-group">
					<!-- <label for="commentgl">Comment</label> -->
					<textarea class="form-control" rows="3" id="comment" placeholder="Type your question or comment here..."></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Submit</button>
			</form>
		</div>
	</div>
	<div class="row">
        <div class="col-sm-12">
            <iframe class="mt-5" src="<?= $site->google_map_code; ?>" width="100%" height="250" frameborder="0" style="border:0"></iframe>
        </div>
	</div>
</div>

<?php include('./_foot.php'); // include footer markup ?>
