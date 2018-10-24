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
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID", "LOCK");
			$session->createdorder = $ordn;
			$session->loc = "{$config->pages->orders}edit-order/?ordn=$ordn";
			break;
		case 'get-order-edit':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID", "LOCK");
			$session->loc = "{$config->pages->orders}edit-order/?ordn=$ordn";
			break;
		case 'quick-update-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$custID = SalesOrder::find_custid($ordn);
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$qty = $input->post->text('qty');
			$orderdetail->set('qty', $qty);
			$session->sql = $orderdetail->update();
			$data = array("DBNAME=$config->dplusdbname", "SALEDET", "ORDERNO=$ordn", "LINENO=$linenbr", "CUSTID=$custID");
			$session->loc = "{$config->pages->orders}edit-order/?ordn=$ordn";
			break;
		case 'add-to-order':
			$itemID = $input->$requestmethod->text('itemID');
			$qty = $input->$requestmethod->text('qty');
			$ordn = $input->$requestmethod->text('ordn');
			
			if (SalesOrder::does_exist($ordn)) {
				$custID = SalesOrder::find_custid($ordn);
				$data = array("DBNAME=$config->dplusdbname", "SALEDET", "ORDERNO=$ordn", "ITEMID=$itemID", "QTY=$qty", "CUSTID=$custID");
				$session->loc = "{$config->pages->orders}edit-order/?ordn=$ordn";
			} else {
				$session->loc = $input->$requestmethod->text('page');
			}
			break;
		case 'remove-line-get':
			$ordn = $input->get->text('ordn');
			$linenbr = $input->get->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$orderdetail->set('qty', '0');
			$session->sql = $orderdetail->update();
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "SALEDET", "ORDERNO=$ordn", "LINENO=$linenbr", "QTY=0", "CUSTID=$custID");
			$session->loc = $config->pages->orders.'edit-order/?ordn=' . $ordn;
			$session->editdetail = true;
			break;
		case 'unlock-order':
			$ordn = $input->get->text('ordn');
			$data = array("DBNAME=$config->dplusdbname", 'UNLOCK' => false, "ORDERNO=$ordn");
			$session->loc = $pages->get('/user/orders/order/')->url."?ordn=$ordn";
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
