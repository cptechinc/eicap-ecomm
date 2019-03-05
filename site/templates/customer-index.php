<?php
    use Dplus\Dpluso\Customer\CustomerIndex;
    use Dplus\Content\PaginatorBootstrap4;

    $page->title = "Choose a Customer";
	$q = $input->get->text('q');
    $customersearch = $pages->get('/customers/')->url;

    $pageurl = new Purl\Url($page->fullURL->getUrl());
    $pageurl->path = $config->pages->customer;

    $custindex = new CustomerIndex($pageurl, '#cust-index-search-form', '#cust-index-search-form');
    $custindex->set_pagenbr($input->pageNum);
    $resultscount = $custindex->count_searchcustindex($q);
    $paginator = new PaginatorBootstrap4($custindex->pagenbr, $resultscount, $custindex->pageurl, 'customers', $custindex->ajaxdata);

    $page->body = $config->twig->render('customer/search-form.twig', ['page' => $page, 'customersearch' => $customersearch, 'custindex' => $custindex, 'input' => $q, 'paginator' => $paginator]);

    if ($config->ajax) {
        echo $page->body;
    } else {
        include __DIR__ . "/basic-page.php";
    }
