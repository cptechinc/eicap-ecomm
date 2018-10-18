<!-- Modal -->
<div class="modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="ajax-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
    </div>
</div>
