<?php 
    $q = $input->get->text('q');
    $page->title = "Searching for '$q'";
    $products = $pages->find("template=product, title|body~=$q");

    if ($config->ajax) {
        $page->body = $config->paths->content."products/search/results-ajax.php";
        if ($config->modal) {
            include('./_include-ajax-modal.php'); 
        }
    } else {
        $page->body = $config->paths->content."products/search/results.php";
        include('./_include-page.php'); 
    }
