<?php
    /**
    * CUSTOMER REDIRECT
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
	*   case 'shop-as-customer':
	*		DBNAME=$config->dplusdbname
	*		CARTCUST
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		break;
	*
	**/

    switch ($action) {
        case 'shop-as-customer':
            $data = array();
            $cart = CartQuote::load(session_id());
            if (empty($cart)) {
                $cart = new CartQuote();
                $cart->set('sessionid', session_id());
            }
            $cart->set('custid', $custID);
            $cart->set('shiptoid', $shipID);
            $session->sql = $cart->save(true);
            $cart->save();

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} elseif ($input->get->page) {
				$session->loc = $input->get->text('page');
			} else {
				$session->loc = $config->pages->cart;
			}
			break;
	}

    if (!empty($data)) {
        write_dplusfile($data, $filename);
        curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
    }

	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
