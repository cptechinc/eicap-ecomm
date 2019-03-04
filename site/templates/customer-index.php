<?php
    $page->title = "Choose a Customer";
    // $page->body = $config->paths->content."customer/index/search-form.php";
    $customersearch = $pages->get('/customers/')->url;
    $function = $input->get->function;

    $page->body = $config->twig->render('customer/search-form.twig', ['page_title' => $page->title, 'customersearch' => $customersearch, 'function' => $function]);

    if ($config->ajax) {
        include($page->body);
    } else {
        // include("./_include-page.php");
        include __DIR__ . "/basic-page.php";
    }
