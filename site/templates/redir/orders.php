<?php
    $requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
    $filename = $input->$requestmethod->sessionID ? $input->$requestmethod->text('sessionID') : session_id();
    $action = $input->$requestmethod->text('action');

    /**
	* ACCOUNT REDIRECT
	*
	*
	*
	*
	* switch ($action) {
    *	case 'load-cust-orders':
	*		DBNAME=$config->dplusdbname
	*		ORDRHED
	*		CUSTID=$custID
	*		TYPE=O  ** OPEN ORDERS
	*		break;
	*	case 'get-order-details':
	*		DBNAME=$config->DBNAME
	*		ORDERDET=$ordn
	*		break;
	* }
	*
	**/

    switch ($action) {
        case 'load-cust-orders':
			$custID = $input->get->text('custID');
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRHED' => false, 'CUSTID' => $custID, 'TYPE' => 'O');
			$session->{'orders-loaded-for'} = $custID;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			$session->loc = $config->pages->root.'user/orders/';
			break;
        case 'get-order-details':
			$ordn = $input->$requestmethod->text('ordn');
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn");
            $session->loc = $pages->get('/user/orders/order/')->url."?ordn=$ordn";
            break;
	}

	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
