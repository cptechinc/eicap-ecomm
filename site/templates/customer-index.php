<?php 
    $page->title = "Choose a Customer";
    $page->body = $config->paths->content."customer/index/search-form.php";
    
    if ($config->ajax) {
        include($page->body);
    } else {
        include("./_include-page.php");
    }
