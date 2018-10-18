<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="ajax-modal-label"><?= $page->title; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php include($page->body); ?>
    </div>
</div>
