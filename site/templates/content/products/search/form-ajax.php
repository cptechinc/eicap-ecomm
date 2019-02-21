<!-- USING SEARCH.TWIG WITH AJAX IF STATEMENT IN PRODUCTS-SEARCH FILE -->
<form action="<?= $pages->get('template=products-search')->url; ?>" method="GET" id="item-search">
	<?php if ($input->get->ordn) : ?>
		<input type="hidden" name="ordn" value="<?= $input->get->ordn; ?>">
	<?php endif; ?>
	<div class="input-group">
		<input type="text" class="form-control cust-index-search" name="q" placeholder="ItemID, Description">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default not-round"> <span class="fa fa-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
		</span>
	</div>
</form>
