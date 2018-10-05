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
	*	case 'login':
	*		DBNAME=$config->DBNAME
	*		LOGPERM
	*		LOGINID=$username
	*		PSWD=$password
	*		break;
	*	case 'logout':
	*		DBNAME=$config->DBNAME
	*		LOGOUT
	*		break;
	* }
	*
	**/

    switch ($action) {
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
