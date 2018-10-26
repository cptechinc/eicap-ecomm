<?php
	$user->loggedin = is_userloggedin(session_id());
	
	$url = !empty($session->loc) ? $session->loc : $config->pages->index;
	$session->remove('loc');

	// Check if user was trying to log in, then handle redirect of login
	if ($session->loggingin) {
		$session->remove('loggingin');

		if (!$user->loggedin) {
			$url = $config->pages->login;
		} else {
			$url = !empty($session->redirecturl) ? $session->redirecturl : $config->pages->index;
		}
	}

	header("Location: $url");
	exit;
