<?php
    /**
    * CART REDIRECT
    *  @param string $action
    *
    */

    $custID = $shipID = '';

    if ($input->requestMethod('POST')) {
        $requestmethod = 'post';
    } else {
        $requestmethod = 'get';
    }
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
	*
	*
	*
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
        case 'remove-line':
			$linenbr = $input->post->text('linenbr');
            echo var_dump($linenbr);
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', '0');
			$session->sql = $cartdetail->update();
			$session->loc = $config->urls->root . 'cart/';
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'LINENO' => $linenbr, 'QTY' => '0');
			break;
	}
	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
