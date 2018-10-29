<?php
    use Dplus\ProcessWire\DplusWire;
    /**
    * CART REDIRECT
    *  @param string $action
    *
    */

    $custID = $shipID = '';

    $requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
    $action = $input->$requestmethod->text('action');

    $custID = $input->$requestmethod->text('custID');
    $shipID = $input->$requestmethod->text('shipID');

    if ($input->$requestmethod->sessionID) {
        $filename = $input->$requestmethod->text('sessionID');
        $sessionID = $input->$requestmethod->text('sessionID');
    } else {
        $filename = session_id();
        $sessionID = session_id();
    }

    /**
	* CART REDIRECT
	*
	*   case 'add-to-cart':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=$itemID
	*		QTY=$qty
	*		break;
    *   case 'add-multiple-items':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=$itemID
	*		QTY=$qty
	*		break;
	*	case 'quick-update-line':
	*	    DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*   case 'remove-line':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		break;
	*
	**/

    switch ($action) {
        case 'add-to-cart':
            $cart = CartQuote::load(session_id());
            $itemID = $input->$requestmethod->text('itemID');
            $qty = $input->$requestmethod->text('qty');
            $data = array("DBNAME=$config->dplusdbname", "CARTDET", "ITEMID=$itemID", "QTY=$qty");
            $data[] = empty($cart->custid) ? "CUSTID=$config->defaultid" : "CUSTID=$cart->custid";
			if (!empty($cart->shipid)) {$data[] = "SHIPTOID=$cart->shipid"; }
            $session->data = $data;
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemID . ' to your cart';
            $session->loc = $config->pages->cart;
            break;
        case 'add-multiple-items':
            $cart = CartQuote::load(session_id());
            $itemids = $input->post->itemID;
            $qtys = $input->post->qty;
            $data = array("DBNAME=$config->dplusdbname", "CARTADDMULTIPLE", "CUSTID=$custID");
            $data[] = empty($cart->custid) ? "CUSTID=$config->defaultid" : "CUSTID=$cart->custid";
            if (!empty($cart->shipid)) {$data[] = "SHIPTOID=$cart->shipid"; }
            for ($i = 0; $i < sizeof($itemids); $i++) {
        		$itemID = str_pad(DplusWire::wire('sanitizer')->text($itemids[$i]), 30, ' ');
        		$qty = DplusWire::wire('sanitizer')->text($qtys[$i]);

        		if (empty($qty)) {$qty = "0"; }
        		$data[] = "ITEMID=".$itemID."QTY=".$qty;
        	}
            $session->addtocart = sizeof($itemIDs);
            $session->loc = $config->pages->cart;
            break;
        case 'quick-update-line':
            $cart = CartQuote::load(session_id());
			$linenbr = $input->$requestmethod->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', $input->$requestmethod->text('qty'));
			$session->sql = $cartdetail->update();
			$data = array("DBNAME=$config->dplusdbname", "CARTDET", "LINENO=$linenbr");
            $data[] = empty($cart->custid) ? "CUSTID=$config->defaultid" : "CUSTID=$cart->custid";
			if (!empty($cart->shipid)) {$data[] = "SHIPTOID=$cart->shipid"; }
			$session->loc = $pages->get('/cart/')->url;
			break;
        case 'remove-line':
            $cart = CartQuote::load(session_id());
			$linenbr = $input->$requestmethod->int('line');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', '0');
			$session->sql = $cartdetail->update();
			$data = array("DBNAME=$config->dplusdbname", "CARTDET", "LINENO=$linenbr", "QTY=0");
            $data[] = empty($cart->custid) ? "CUSTID=$config->defaultid" : "CUSTID=$cart->custid";
			if (!empty($cart->shipid)) {$data[] = "SHIPTOID=$cart->shipid"; }
            $session->loc = $pages->get('/cart/')->url;
			break;
        case 'create-sales-order':
			$data = array("DBNAME=$config->dplusdbname", "CREATESO");
           	$session->loc = $config->pages->orders . "redir/?action=edit-new-order";
            break;
	}
	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
