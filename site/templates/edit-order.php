<?php include('./_head.php'); ?>
<?php $ordn = $input->get->text('ordn'); ?>
<?php $editorderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn); ?>
<?php $order = $editorderdisplay->get_order(); ?>
<?php $order_details = $editorderdisplay->get_orderdetails($order); ?>
<?php $page->title = "Review Order #".$ordn. " for ".Customer::get_customernamefromid($order->custid); ?>

<div class="container page top-margin">
    <div class="form-group">
        <h1 class="text-danger font-weight-bold border-bottom border-primary"><?= ucwords(strtolower($page->get('headline|title'))); ?></h1>
    </div>
    <div class="list-group">
        <div class="list-group-item list-group-item-action bg-secondary text-white font-weight-bold">
            <div class="row">
                <div class="col">Item / Description</div>
                <div class="col text-right">Qty</div>
                <div class="col text-right">Price</div>
                <div class="col text-right">Total</div>
                <div class="col text-right">Edit / Remove</div>
            </div>
        </div>

        <?php foreach ($order_details as $detail) : ?>

        	<form action="<?= $config->pages->orders.'redir/'; ?>" method="post" class="">
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
                            <?= $editorderdisplay->generate_deletedetaillink($order, $detail); ?>
                        </div>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
        <div class="list-group-item bg-light">
            <div class="row">
                <div class="col-12 col-sm"></div>
                <div class="col-6 col-sm text-right"></div>
                <div class="col-6 col-sm text-right"></div>
                <div class="col-6 col-sm text-right">
                    <div class="d-sm-none"><b>Order Total</b></div>
                    <br>
                    <strong>Order Total:&emsp;$ <?= $page->stringerbell->format_money($order->subtotal); ?></strong>
                </div>
                <div class="col-12 col-sm text-right"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <a href="" class="btn btn-block btn-success mt-3" data-type="order">
            		Send Order for Approval&nbsp;&nbsp;<i class="fa fa-arrow-circle-right text-white" aria-hidden="true"></i>
            	</a>
            </div>
        </div>
    </div>
</div>

<?php include('./_foot.php'); ?>
