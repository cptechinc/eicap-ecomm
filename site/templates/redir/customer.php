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
			$data = array("DBNAME=$config->dplusdbname", "CARTCUST", "CUSTID=$custID");
            if (!empty($shipID)) {$data['SHIPID'] = $shipID; $session->shipID = $shipID; }
			if (!CartQuote::cart_exists(session_id())) {
				$session->sql = insert_cartheadcust(session_id(), $custID, $shipID);
			}
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} elseif ($input->get->page) {
				$session->loc = $input->get->text('page');
			} else {
				$session->loc = $config->pages->cart;
			}
			break;
	}
	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
