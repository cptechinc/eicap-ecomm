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
	*	case 'get-order-details':
	*		DBNAME=$config->DBNAME
	*		ORDERDET=$ordn
	*		break;
    * 	case 'edit-new-order':
	*		DBNAME=$config->dplusdbname
	*		ORDRDET=$ordn
	*		CUSTID=$custID
	*		LOCK
	* 		break;
	* }
	*
	**/

    switch ($action) {
        case 'get-order-details':
			$ordn = $input->$requestmethod->text('ordn');
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn");
            $session->loc = $pages->get('/user/orders/order/')->url."?ordn=$ordn";
            break;
        case 'edit-new-order':
			$ordn = get_createdordn(session_id());
			$custID = get_custidfromorder(session_id(), $ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID", "LOCK");
			$session->createdorder = $ordn;
			$session->loc = $config->pages->orders.'edit-order/?ordn=' . $ordn;
			break;
        case 'quick-update-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$custID = get_custidfromorder(session_id(), $ordn);
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			// $orderdetail->set('whse', $input->post->text('whse'));
			$qty = $input->post->text('qty');
			$orderdetail->set('qty', $qty);
			$session->sql = $orderdetail->update();
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr, 'CUSTID' => $custID);
			$session->loc = $config->pages->edit."order/?ordn=$ordn"; // TODO correct page name
			$session->editdetail = true;
			break;
	}

	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
