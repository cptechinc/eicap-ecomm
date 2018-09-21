<?php include('./_head.php'); // include header markup ?>

<div class="container-fluid page">
    <div class="row">
        <video class="mx-auto mt-5" poster="https://www.eicap.org/wp-content/uploads/EICAP.Video_.Poster.png" preload="none" controls="controls" width="720" height="406">
            <source src="https://www.eicap.org/wp-content/uploads/About-EICAP.mp4" type="video/mp4">Your browser does not support the video tag.
        </video>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 mx-auto">
            <?= $page->body; ?>
        </div>
    </div>
    <hr>
    <div class="row mt-3 mb-5">
        <div class="col-sm-6 mx-auto">
            <h1 class="text-danger font-weight-bold text-center my-3">Our Services</h1>
            <div class="row">
                <?php $children = $page->children(); ?>
                <?php foreach ($children as $child) : ?>
                    <div class="col-sm-3">
                        <h5 class="text-primary font-weight-bold border-bottom border-primary"><?= $child->title; ?></h5>
                        <?= $child->body; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include('./_foot.php'); // include footer markup ?>
