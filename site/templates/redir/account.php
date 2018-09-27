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
		case 'login':
			$username = $input->$requestmethod->text('username');
			$password = $input->$requestmethod->text('password');
			$data = array("DBNAME=$config->dplusdbname", 'LOGPERM', "LOGINID=$username", "PSWD=$password");
			$session->loggingin = true;
			$session->loc = $config->pages->index.'redir/';
			break;
		case 'logout':
			$data = array('DBNAME' => $config->dplusdbname, 'LOGOUT' => false);
			$session->loc = $config->pages->login;
			$session->remove('shipID');
			$session->remove('custID');
			$session->remove('locked-ordernumber');
			break;
	}
    echo var_dump($data);
	write_dplusfile($data, $filename);
	curl_get("127.0.0.1/cgi-bin/$config->cgi?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
