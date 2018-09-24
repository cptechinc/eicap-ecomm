<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">
        <a class="text-white font-weight-bold navbar-brand" href="<?= $pages->get('/')->url; ?>"><?= $site->company_name; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php $homepage = $pages->get('/'); ?>
        		<?php $children = $homepage->children(); ?>
                <?php foreach ($children as $child) : ?>
                    <?php if ($child->template != 'user-page') : ?>
                        <li class="nav-item">
                            <a class="text-white nav-link" href="<?= $child->url; ?>"><?= $child->title; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right hidden-sm">
                <?php //if($page->editable()) echo "<li class='edit'><a href='$page->editUrl'>Edit</a></li>"; ?>
                <?php if ($user->loggedin) : ?>
                    <li class="nav-item"><a href="<?= $pages->get('/user/')->url; ?>" class="text-white nav-link"><i class="fa fa-user text-white" aria-hidden="true"></i> User : <?= $user->fullname; ?></a></li>
                    <li>
                    	<a href="<?php echo $config->pages->account; ?>redir/?action=logout" class="btn btn-light logout">Logout</a>
                    </li>
                <?php else : ?>

                <?php endif; ?>
          	</ul>
        </div>

    </div>
</nav>
