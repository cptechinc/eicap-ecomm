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

    /* =============================================================
        CART FUNCTIONS
    ============================================================ */
    /**
	 * Returns if Session has a carthead record
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug?
	 * @return bool              If there's a carthead record will return 1 / true
	 */
	function has_carthead($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->field($q->expr("IF(COUNT(*) > 1, 1, 0)"));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
    
    /**
	 * Inserts new carthead record
	 * @param  string $sessionID Session Identifier
	 * @param  string $custID    Customer ID
	 * @param  string $shipID    Customer Shipto ID
	 * @param  bool   $debug     Run in debug?
	 * @return string            SQL Query
	 */
	function insert_cartheadcust($sessionID, $custID, $shipID = '', $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->mode('insert');
		$q->set('sessionid', $sessionID);
		$q->set('custid', $custID);
		$q->set('shiptoid', $shipID);
		$q->set('date', date('Ymd'));
		$q->set('time', date('His'));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery($q->params);
		}
	}
    
    /**
	 * Returns the carthead record for this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so returns SQL Query
	 * @return CartQuote            CartQuote
	 */
	function get_carthead($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'CartQuote'); // CAN BE SalesOrder|SalesOrderEdit
			return $sql->fetch();
		}
	}

    /**
	 * Returns the number of Cart Items for this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return int               Number of Cart Items for this session
	 */
	function count_cartdetails($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->field('COUNT(*)');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

    /**
	 * Return the CartDetail for this session and Line Number
	 * @param  string     $sessionID Session Identifier
	 * @param  int        $linenbr   Detail Line Number
	 * @param  bool       $debug     Run in debug?
	 * @return CartDetail            Cart Detail Line
	 */
	function get_cartdetail($sessionID, $linenbr, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->where('sessionid', $sessionID);
		$q->where('linenbr', $linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'CartDetail');
			return $sql->fetch();
		}
	}

    /**
	 * Returns an array of CartDetails
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $useclass  Use CartDetail Class?
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return array             CartDetails
	 */
	function get_cartdetails($sessionID, $useclass = true, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'CartDetail'); // CAN BE SalesOrder|SalesOrderEdit
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

    /**
	 * Updates the CartDetail record (cartdet) in the database
	 * @param  string     $sessionID Session Identifier
	 * @param  CartDetail $detail    CartDetail Object with changes, will use CartDetail properties to load original
	 * @param  bool       $debug     Run in debug?
	 * @return string                SQL Query
	 */
	function update_cartdetail($sessionID, CartDetail $detail, $debug = false) {
		$originaldetail = CartDetail::load($sessionID, $detail->linenbr);
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('cartdet');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($detail->$property != $originaldetail->$property) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('sessionid', $detail->sessionid);
		$q->where('linenbr', $detail->linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($detail->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

/* =============================================================
	CUSTOMER INDEX FUNCTIONS
============================================================ */
    /**
	 * Returns the Number of custindex records that match the search
	 * and filters it by user permissions
	 * @param  string $query   Search Query
	 * @param  string $loginID User Login ID, if blank, will use current User
	 * @param  bool   $debug   Run in debug? If so, Return SQL Query
	 * @return int             Number of custindex records that match the search | SQL Query
	 */
	function count_searchcustindex($query, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$search = QueryBuilder::generate_searchkeyword($query);
		$groupedcustindexquery = (new QueryBuilder())->table('custindex')->group('custid, shiptoid');

		$q = new QueryBuilder();
		$q->field($q->expr('COUNT(*)'));

		// CHECK if Users has restrictions by Application Config, then User permissions
		if ($user->get_dplusrole() == DplusWire::wire('config')->user_roles['sales-rep']['dplus-code'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custpermquery = (new QueryBuilder())->table('custperm')->field('custid, shiptoid')->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->table($groupedcustindexquery, 'custgrouped');
			$q->where('(custid, shiptoid)','in', $custpermquery);
		} else {
			$q->table($groupedcustindexquery, 'custgrouped');
		}
        
		$fieldstring = implode(", ' ', ", array_keys(Contact::generate_classarray()));

		$q->where($q->expr("UCASE(REPLACE(CONCAT($fieldstring), '-', '')) LIKE UCASE([])", [$search]));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
    
    /**
	 * Returns Customer Index records that match the Query
	 * @param  string $keyword Query String to match
	 * @param  int    $limit   Number of records to return
	 * @param  int    $page    Page to start from
	 * @param  string $orderby Order By string
	 * @param  string $loginID User Login ID, if blank, will use current user
	 * @param  bool   $debug   Run in debug? If so, will return SQL Query
	 * @return array           Customer Index records that match the Query
	 */
	function search_custindexpaged($keyword, $limit = 10, $page = 1, $orderby, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		$search = '%'.str_replace(' ', '%', str_replace('-', '', addslashes($keyword))).'%';
		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->user_roles['sales-rep']['dplus-code'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$permquery = (new QueryBuilder())->table('custperm');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		}
		$fieldstring = implode(", ' ', ", array_keys(Contact::generate_classarray()));

		$q->where($q->expr("UCASE(REPLACE(CONCAT($fieldstring), '-', '')) LIKE UCASE([])", [$search]));
		$q->limit($limit, $q->generate_offset($page, $limit));

		if (!empty($orderbystring)) {
			$q->order($q->generate_orderby($orderbystring));
		} else {
			$q->order($q->expr('custid <> []', [$search]));
		}
		$q->group('custid, shiptoid');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetchAll();
		}
	}
    
    function get_customer($custID, $shiptoID = false, $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->where('custid', $custID);

		if ($shiptoID) {
			$q->where('shiptoid', $shiptoID);
			$q->where('source', Contact::$types['customer-shipto']);
		} else {
			$q->where('source', Contact::$types['customer']);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetch();
		}
	}
