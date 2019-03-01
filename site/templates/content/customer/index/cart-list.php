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
	$input = $input->get->text('q');

	$config->twig->display('customer/cart-list.twig', ['page' => $page, 'resultscount' => $resultscount, 'custindex' => $custindex, 'input' => $input, 'paginator' => $paginator]);
?>
