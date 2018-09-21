<footer class="bg-danger">
	<div class='container'>
        <div class="row pt-2">
            <div class="col-sm-6">
                <p class="text-white"><?= $site->company_name; ?></br>
                <?= $site->company_address; ?></br>
                Phone: <a class="text-white-50" href="tel:<?= $site->company_phone; ?>"><?= $site->company_phone; ?></a></br>
                Email: <a class="text-white-50" href="mailto:">email@email.com</a></p>
            </div>
            <div class="col-sm-6 text-white text-right mt-5">
				<a class="text-white-50" href="#"><i class="fa fa-facebook-official fa-lg"></i></a>
				<a class="text-white-50" href="#"><i class="fa fa-instagram fa-lg"></i></a>
				<a class="text-white-50" href="#"><i class="fa fa-twitter-square fa-lg"></i></a>
				<a class="text-white-50" href="#"><i class="fa fa-snapchat-square fa-lg"></i></a>
                <p class="text-white">Copyright &copy; <?= date('Y'); ?> <?= $site->company_name; ?></p>
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>

<?php foreach($config->scripts->unique() as $script) : ?>
	<script src="<?= $script; ?>"></script>
<?php endforeach; ?>

</body>
</html>
