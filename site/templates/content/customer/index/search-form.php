<h1 class="text-danger font-weight-bold border-bottom border-primary mb-4"><?= $page->title; ?></h1>
<form action="<?= $pages->get('/customers/')->url; ?>" method="get">
    <div class="form-group">
        <?php if ($input->get->function) : ?>
            <input type="hidden" name="function" class="function" value="<?= $input->get->text('function'); ?>">
        <?php endif; ?>
        <div class="input-group">
            <input type="text" class="form-control cust-index-search" name="q" placeholder="Type customer phone, name, ID, contact">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default not-round"> <span class="fa fa-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
            </span>
        </div>
    </div>
    <div>
        <?php
            //if (!empty($input->get->q) || !empty($input->get->function)) {
                switch ($input->get->text('function')) {
                    case 'cart':
                        include($config->paths->content."customer/index/cart-list.php");
                        break;
                    default:
                        include($config->paths->content."customer/index/cart-list.php");
                        break;
                }
            //}
        ?>
    </div>
</form>
