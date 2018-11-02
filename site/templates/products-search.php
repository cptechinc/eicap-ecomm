<?php 
    $q = $input->get->text('q');
    $page->title = $input->get->q ? "Searching for '$q'" : "Search Products";
    $products = $pages->find("template=product|imitem, title|body*=$q");

    if ($config->ajax) {
        $page->body = $config->paths->content."products/search/results-ajax.php";
        if ($config->modal) {
            include('./_include-ajax-modal.php'); 
        }
    } else {
        $page->body = $config->paths->content."products/search/results.php";
        include('./_include-page.php'); 
    }
