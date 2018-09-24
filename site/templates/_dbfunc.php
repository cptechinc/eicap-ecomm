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

    /**
	 * Returns record for the session's Login
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Login Record
	 */
	function get_loginrecord($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field($q->expr("IF(restrictcustomers = 'Y', 1, 0) as restrictcustomers"));
		$q->field($q->expr("logperm.*"));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

/* =============================================================
    LOGM FUNCTIONS
============================================================ */
    function get_logmuser($loginID, $debug = false) {
        $q = (new QueryBuilder())->table('logm');
        $q->where('loginid', $loginID);
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'LogmUser');
            return $sql->fetch();
        }
    }

    function get_logmuserlist($debug = false) {
        $q = (new QueryBuilder())->table('logm');
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'LogmUser');
            return $sql->fetchAll();
        }
    }
