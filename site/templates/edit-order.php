<?php include('./_head.php'); ?>
<?php $editorderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn); ?>
<?php $ordn = $input->get->text('ordn'); ?>
<?php $order = get_orderhead(session_id(), $ordn, 'SalesOrder', false); ?>

<div class="container page">
    <div class="list-group mt-5">
        <div class="list-group-item list-group-item-action bg-secondary text-white font-weight-bold">
            <div class="row">
                <div class="col">Item / Description</div>
                <div class="col text-right">Qty</div>
                <div class="col text-right">Price</div>
                <div class="col text-right">Total</div>
                <div class="col text-right">Edit / Remove</div>
            </div>
        </div>
    </div>
    <?php $order_details = $editorderdisplay->get_orderdetails($order); ?>
    <?php foreach ($order_details as $detail) : ?>
    	<form action="<?= $config->pages->orders.'redir/'; ?>" method="post" class="form-group detail allow-enterkey-submit">
    		<input type="hidden" name="action" value="quick-update-line">
            <input type="hidden" name="ordn" value="<?= $ordn; ?>">
    		<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
            <div class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-12 col-sm">
                        <?= $detail->itemid; ?><br>
                        <small><?= $detail->desc1; ?></small>
                    </div>
                    <div class="col-6 col-sm text-right">
                        <div class="d-sm-none"><b>Price</b></div>
                        <br>
                        $ <?= $page->stringerbell->format_money($detail->price); ?>
                    </div>
                    <div class="col-6 col-sm text-right">
                        <div class="d-sm-none"><b>Qty</b></div>
                        <br>
                        <input class="form-control pull-right text-right qty" type="text" name="qty" size="4" value="<?= number_format($detail->qty, 0); ?>">
                    </div>
                    <div class="col-6 col-sm text-right">
                        <div class="d-sm-none"><b>Item Total</b></div>
                        <br>
                        $ <?= $page->stringerbell->format_money($detail->price * $detail->qty); ?>
                    </div>
                    <div class="col-12 col-sm text-right">
                        <br>
                        <button type="submit" class="btn btn-success save-button" title="Save Changes">
                            <span class="fa fa-floppy-o"></span> <span class="sr-only">Save Line</span>
                        </button>
                        <!-- $editorderdisplay->generate_deletedetaillink($order, $detail); -->
                    </div>
                </div>
            </div>
        </form>
    <?php endforeach; ?>
</div>

<?php include('./_foot.php'); ?>
