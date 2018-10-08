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

/* =============================================================
    FAMILY FUNCTIONS
============================================================ */
    function get_families($debug = false) {
        $q = (new QueryBuilder())->table('family');
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'Family');
            return $sql->fetchAll();
        }
    }

    function get_family($famID, $debug = false) {
        $q = (new QueryBuilder())->table('family');
        $q->where('famID', $famID);
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'Family');
            return $sql->fetch();
        }
    }

/* =============================================================
    PRODUCT FUNCTIONS
============================================================ */
    function get_products($debug = false) {
        $q = (new QueryBuilder())->table('itemmaster');
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $sql->fetchAll();
        }
    }

    function get_product($itemid, $debug = false) {
        $q = (new QueryBuilder())->table('itemmaster');
        $q->where('itemid', $itemid);
        $sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

        if ($debug) {
            return $q->generate_sqlquery($q->params);
        } else {
            $sql->execute($q->params);
            $sql->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $sql->fetch();
        }
    }

/* =============================================================
    SALES ORDER FUNCTIONS
============================================================ */

    function count_userorders($sessionID, $filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$expression = $q->expr('IF (COUNT(*) = 1, 1, IF(COUNT(DISTINCT(custid)) > 1, COUNT(*), 0)) as count');
		if (!empty($filter)) {
			$expression = $q->expr('COUNT(*)');
			$q->generate_filters($filter, $filtertypes);
		}
		$q->field($expression);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_userordersorderdate($sessionID, $limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->field('ordrhed.*');
		$q->field($q->expr("STR_TO_DATE(orderdate, '%m/%d/%Y') as dateoforder"));
		$q->where('sessionid', $sessionID);
		$q->where('type', 'O');
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('dateoforder ' . $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_userordersorderby($sessionID, $limit = 10, $page = 1, $sortrule, $orderby, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->field('ordrhed.*');
		$q->where('sessionid', $sessionID);
		$q->where('type', 'O');
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order($orderby .' '. $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_userorders($sessionID, $limit = 10, $page = 1, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->where('sessionid', $sessionID);
		$q->where('type', 'O');
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

    function get_orderdetails($sessionID, $ordn, $useclass = false, $debug = false) {
        $q = (new QueryBuilder())->table('ordrdet');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}


    /* =============================================================
	EDIT ORDER FUNCTIONS
============================================================ */
	function can_editorder($sessionID, $ordn, $debug) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT editord FROM ordrhed WHERE sessionid = :sessionID AND orderno = :ordn LIMIT 1");
		$switching = array(':sessionID' => $sessionID, ':ordn' => $ordn); $withquotes = array(true, true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			$column = $sql->fetchColumn();
			if ($column != 'Y') { return false; } else { return true; }
		}
	}

	function get_orderhead($sessionID, $ordn, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetch();
			}
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
    }
