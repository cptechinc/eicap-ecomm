<?php
/* =============================================================
    LOGIN FUNCTIONS
============================================================= */
    /**
     * Returns if User is logged in
     * @param  string $sessionID Session Identifier
     * @param  bool   $debug     Run in debug? If so, return SQL Query
     * @return bool              Is user logged in?
     */
    function is_userloggedin($sessionID, $debug = false) {
        $q = (new QueryBuilder())->table('logperm');
        $q->field($q->expr("IF(validlogin = 'Y', 1, 0)"));
        $q->where('sessionid', $sessionID);
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery();
        } else {
            $sql->execute($q->params);
            return $sql->fetchColumn();
        }
    }

    /**
	 * Returns Error Message for Session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            Error Message for Login / Session
	 */
	function get_loginerrormsg($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field('errormsg');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
