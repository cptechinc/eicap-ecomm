<?php
    if ($config->COMPANYNBR == 2) {
        $bg = 'bg-dark';
    } else {
        $bg = 'bg-primary';
    }

    $children = $pages->get('/')->children('template!=cart|build-items|site-admin|user-page');

    echo $config->twig->render('nav.twig', ['bg' => $bg, 'pages' => $pages, 'site' => $site, 'children' => $children, 'user' => $user, 'config' => $config]);
