<?php 
    $q = $input->get->text('q');
    $page->title = "Searching for '$q'";
    $products = $pages->find("template=product, title|body~=$q");
?>
<?php include('./_head.php'); ?>
    <div class='container top-margin'>
        <div class="form-group">
            <h1 class="text-danger font-weight-bold border-bottom border-primary"><?= ucwords(strtolower($page->get('headline|title'))); ?></h1>
        </div>
    </div>
	<div class='container page top-margin'>
        <?php include $config->paths->content."products/product-search-results.php"; ?>
    </div>

<?php include('./_foot.php'); ?>
