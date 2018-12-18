<?php
	use Dplus\Dpluso\Customer\CustomerIndex;
	use Dplus\Content\PaginatorBootstrap4;

	$pageurl = new Purl\Url($page->fullURL->getUrl());
	$pageurl->path = $config->pages->customer;
	$pageurl->query->set('function', 'cart');

	$custindex = new CustomerIndex($pageurl, '#cust-index-search-form', '#cust-index-search-form');
	$custindex->set_pagenbr($input->pageNum);
	$resultscount = $custindex->count_searchcustindex($input->get->text('q'));
	$paginator = new PaginatorBootstrap4($custindex->pagenbr, $resultscount, $custindex->pageurl, 'customers', $custindex->ajaxdata);
?>

<div id="cust-results">
	<table id="cust-index" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="100">CustID</th> <th>Customer Name</th> <th>Ship-To</th> <th>Location</th><th width="100">Phone</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($resultscount > 0) : ?>
				<?php $customers = $custindex->search_custindexpaged($input->get->text('q'), $input->pageNum); ?>
				<?php foreach ($customers as $cust) : ?>
					<tr>
						<td>
							<a href="<?= $cust->generate_setcartcustomerurl(); ?>">
								<?= $page->htmlwriter->highlight($cust->custid, $input->get->text('q'));?>
							</a> &nbsp; <span class="glyphicon glyphicon-share"></span>
						</td>
						<td><?= $page->htmlwriter->highlight($cust->name, $input->get->q); ?></td>
						<td><?= $page->htmlwriter->highlight($cust->shiptoid, $input->get->q); ?></td>
						<td><?= $page->htmlwriter->highlight($cust->generate_address(), $input->get->q); ?></td>
						<td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->htmlwriter->highlight($cust->phone, $input->get->q); ?></a></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<td colspan="5">
					<h4 class="list-group-item-heading">No Customer Matches your query.</h4>
				</td>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="d-flex flex-column">
		<div class="align-self-center">
			<?= $paginator; ?>
		</div>
	</div>
</div>
