<?php $details = get_cartdetails(session_id()); ?>

<div class="list-group">
    <div class="list-group-item list-group-item-action bg-secondary text-white font-weight-bold">
        <div class="row">
            <div class="col">ItemID</div>
            <div class="col text-right">Price</div>
            <div class="col text-right">Qty</div>
            <div class="col text-right">Total</div>
            <div class="col text-right">Edit / Remove</div>
        </div>
    </div>
    <?php foreach ($details as $detail) : ?>
        <form class="" action="<?= $config->pages->root.'cart/redir/'; ?>" method="post">
            <input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
            <input type="hidden" name="action" value="quick-update-line">
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
                        <a href="<?= $cartdisplay->generate_detaildeleteurl($cart, $detail); ?>" class="btn btn-danger detail-line-icon" title="Delete Item">
                            <i class="fa fa-trash text-white" aria-hidden="true"></i><span class="sr-only">Delete Line</span>
                        </a>
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
                    <div class="d-sm-none"><b>Cart Total</b></div>
                    <br>
                    <strong>Cart Total:&emsp;$ <?= $page->stringerbell->format_money($cart->subtotal); ?></strong>
                </div>
                <div class="col-12 col-sm text-right"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <a href="<?= $config->pages->cart."redir/?action=create-sales-order"; ?>" class="btn btn-block btn-primary mt-3" data-type="order">
            		Create Order &nbsp;&nbsp;<i class="fa fa-arrow-circle-right text-white" aria-hidden="true"></i>
            	</a>
            </div>
        </div>

</div>
