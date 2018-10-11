<?php
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
	*		break;
	*   case 'remove-line':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
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
            $session->loc = $pages->get('/cart/')->url;
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
			$linenbr = $input->$requestmethod->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', '0');
			$session->sql = $cartdetail->update();
			$data = array("DBNAME=$config->dplusdbname", "CARTDET", "LINENO=$linenbr", "QTY=0");
            $data[] = empty($cart->custid) ? "CUSTID=$config->defaultid" : "CUSTID=$cart->custid";
			if (!empty($cart->shipid)) {$data[] = "SHIPTOID=$cart->shipid"; }
            $session->loc = $pages->get('/cart/')->url;
			break;
	}
	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
