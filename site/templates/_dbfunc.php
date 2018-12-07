<?php
	use Dplus\Base\QueryBuilder;
	use Dplus\ProcessWire\DplusWire;

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
	LOGMPERM FUNCTIONS
============================================================ */
	/**
	 * Returns the Order Number / Quote Number created
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? IF so return SQL Query
	 * @return string            Dplus (Order / Quote) Number
	 */
	function get_createdordn($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field('ordernbr');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

/* =============================================================
	PERMISSION FUNCTIONS
============================================================ */
	/**
	 * Returns if User has permission to function / menu / page
	 * // NOTE This is based by login ID
	 * @param  string $loginID       User Login ID
	 * @param  string $dplusfunction Dplus Function / Menu code
	 * @param  bool   $debug         Run in debug? IF so return SQL Query
	 * @return bool                  User has menu / function access ?
	 */
	function has_dpluspermission($loginID, $dplusfunction, $debug = false) {
		$q = (new QueryBuilder())->table('funcperm');
		$q->field($q->expr("IF(permission = 'Y', 1, 0)"));
		$q->where('loginid', $loginID);
		$q->where('function', $dplusfunction);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
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
	ITEM GROUP FUNCTIONS
============================================================ */
		function get_itemgroups($debug = false) {
			$q = (new QueryBuilder())->table('itemgroups');
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				$sql->setFetchMode(PDO::FETCH_CLASS, 'ItemGroup');
				return $sql->fetchAll();
			}
		}

		function get_itemgroup($itemgroup, $debug = false) {
			$q = (new QueryBuilder())->table('itemgroups');
			$q->where('code', $itemgroup);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				$sql->setFetchMode(PDO::FETCH_CLASS, 'ItemGroup');
				return $sql->fetch();
			}
		}
/* =============================================================
	PRODUCT FUNCTIONS
============================================================ */
	function get_products($debug = false) {
		$q = (new QueryBuilder())->table('im');
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
		$q = (new QueryBuilder())->table('im');
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

	function get_items($debug = false) {
		$q = (new QueryBuilder())->table('itemmaster');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'ItemMasterItem');
			return $sql->fetchAll();
		}
	}

	function get_item($itemid, $debug = false) {
		$q = (new QueryBuilder())->table('itemmaster');
		$q->where('itemid', $itemid);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'ItemMasterItem');
			return $sql->fetch();
		}
	}

/* =============================================================
	SALES ORDER FUNCTIONS
============================================================ */
	/**
	 * Counts the Number of Sales Orders in oe_head that match the filter criteria
	 * @param  bool   $filter      Array of filters and the values to filter for
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so, return SQL query
	 * @return int                 Number of Sales Orders that match the filter criteria
	 */
	function count_salesorders($filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('COUNT(*)'));

		if (isset($filter['salesperson'])) {
			$salespeople = $filter['salesperson'];
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}

			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns an array of SalesOrder that match the filter criteria
	 * @param  int    $limit       Number of Records to Return
	 * @param  int    $page        Page Number
	 * @param  string $sortrule    Sort (ASC)ENDING | (DESC)ENDING
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $useclass    Return records as SalesOrder class?
	 * @param  bool   $debug       Run in Debug? If so, return SQL Query
	 * @return array               Sales Orders that match the filter criteria
	 */
	function get_salesorders($limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');

		if (isset($filter['salesperson'])) {
			$salespeople = $filter['salesperson'];
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('order_date' . $sortrule);
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

	/**
	 * Returns an array of SalesOrder that match the filter criteria
	 * @param  int    $limit       Number of Records to Return
	 * @param  int    $page        Page Number
	 * @param  string $sortrule    Sort (ASC)ENDING | (DESC)ENDING
	 * @param  string $orderby     Column / Property to sort on
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $useclass    Return records as SalesOrder class?
	 * @param  bool   $debug       Run in Debug? If so, return SQL Query
	 * @return array               Sales Orders that match the filter criteria
	 */
	function get_salesorders_orderby($limit = 10, $page = 1, $sortrule, $orderby, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');

		if (isset($filter['salesperson'])) {
			$salespeople = $filter['salesperson'];
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');

			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

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
			return $sql->fetchAll();
		}
	}

	/**
	 * Returns if Sales Order exists in the oe_head table
	 * @param  string $ordn   Sales Order Number
	 * @param  bool   $debug  Run in debug? If so, will return SQL Query
	 * @return bool           Does Sales Order exist?
	 */
	function does_salesorderexist($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr("IF(COUNT(*) > 0, 1, 0)"));
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return boolval($sql->fetchColumn());
		}
	}

	/**
	 * Returns the Sales Order from the oe_head table
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, will return SQL Query
	 * @return SalesOrder        Sales Order
	 */
	function get_salesorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
			return $sql->fetch();
		}
	}

	/**
	 * Returns SalesOrderEdit object for Editable Sales Order
	 * @param  string $sessionID Session ID
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return SalesOrderEdit    Editable Sales Order
	 */
	function get_salesorderforedit($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->where('orderno', $ordn);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderEdit');
			return $sql->fetch();
		}
	}

	/**
	 * Returns an array of SalesOrderDetail for an Order
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $useclass  Use Class? Or return as array
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return array             Sales Order Details
	 */
	function get_orderdetails($sessionID, $ordn, $useclass = false, $debug) {
		$q = (new QueryBuilder())->table('ordrdet');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderDetail');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns the Customer ID from a specific Sales Order
	 * @param  string $ordn  Sales Order Number
	 * @param  bool   $debug Run in debug? If so, return SQL Query
	 * @return string        Customer ID
	 */
	function get_custidfromsalesorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field('custid');
		$q->where('ordernumber', "$ordn");
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Min Order Date for Sales Orders that meets the filter criteria
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto ID
	 * @param  string $field       Which Sales Order Date Property
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return string              Min Sales Order Date
	 */
	function get_minsalesorderdate($field, $custID = false, $shipID = false, $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr("MIN($field)"));

		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$salespeople = $filter['salesperson'];
			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Max Order Total for Sales Orders that
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto Id
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return float               Max Sales Order Total
	 */
	function get_maxsalesordertotal($custID = '', $shipID = '', $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('MAX(total_order)'));

		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$salespeople = $filter['salesperson'];

			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Min Order Total for Sales Orders that
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto ID
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return float               Min Sales Order Total
	 */
	function get_minsalesordertotal($custID = '', $shipID = '', $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('MIN(total_order)'));

		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$salespeople = $filter['salesperson'];

			if (!empty($salespeople)) {
				$ordersquery->where(
					$ordersquery
					->orExpr()
					->where('salesperson_1', $salespeople)
					->where('salesperson_2', $salespeople)
					->where('salesperson_3', $salespeople)
				);
			}
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}


	/* =============================================================
		EDIT ORDER FUNCTIONS
	============================================================ */



	function get_orderhead($sessionID, $ordn, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
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

	function get_orderdetail($sessionID, $ordn, $linenbr, $debug = false) {
		$q = (new QueryBuilder())->table('ordrdet');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$q->where('linenbr', $linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderDetail');
			return $sql->fetch();
		}
	}

	function update_orderdetail($sessionID, $detail, $debug = false) {
		$originaldetail = SalesOrderDetail::load($sessionID, $detail->orderno, $detail->linenbr);
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('ordrdet');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($detail->$property != $originaldetail->$property) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('orderno', $detail->orderno);
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
		$q->field($q->expr("IF(COUNT(*) > 0, 1, 0)"));
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
	 * @param  string    $sessionID Session Identifier
	 * @param  CartQuote $cart      Cart Header
	 * @param  bool      $debug     Run in debug? IF so, return SQL Query
	 * @return bool                 Was Record Inserted?
	 */
	function insert_carthead($sessionID, CartQuote $cart, $debug = false) {
		$properties = array_keys($cart->_toArray());
		$q = (new QueryBuilder())->table('carthed');
		$q->mode('insert');
		$cart->set('date', date('Ymd'));
		$cart->set('time', date('His'));
		foreach ($properties as $property) {
			if (!empty($cart->$property)) {
				$q->set($property, $cart->$property);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return DplusWire::wire('dplusdatabase')->lastInsertId() > 0 ? true : false;
		}
	}

	/**
	 * Updates carthead record
	 * @param  string    $sessionID Session Identifier
	 * @param  CartQuote $cart      Cart Header
	 * @param  bool      $debug     Run in debug? If so, return SQL Query
	 * @return int                  Was Record Updated?
	 */
	function update_carthead($sessionID, CartQuote $cart, $debug = false) {
		$originalcart = CartQuote::load($sessionID);
		$properties = array_keys($cart->_toArray());
		$q = (new QueryBuilder())->table('carthed');
		$q->mode('update');
		$cart->set('date', date('Ymd'));
		$cart->set('time', date('His'));
		foreach ($properties as $property) {
			if ($cart->$property != $originalcart->$property) {
				$q->set($property, $cart->$property);
			}
		}
		$q->where('sessionid', $cart->sessionid);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return boolval($sql->rowCount());
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
		$search = QueryBuilder::generate_searchkeyword($query);

		$q = (new QueryBuilder())->table('custindex');
		$q->field($q->expr('COUNT(*)'));

		// CHECK if Users has restrictions by Application Config, then User permissions
		if ($user->is_salesrep() || $user->is_salesmanager()) {
			$customertypes = get_customertypesforuser($loginID);
			$customertypes = array_map('strtoupper', $customertypes);

			if (!empty($customertypes)) {
				$custpermquery = (new QueryBuilder())->table('custindex')->field('custid, shiptoid')->where('typecode', $customertypes);
				$q->where('(custid, shiptoid)','in', $custpermquery);
			}
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

		if ($user->is_salesrep() || $user->is_salesmanager()) {
			$customertypes = get_customertypesforuser($loginID);
			$customertypes = array_map('strtoupper', $customertypes);

			if (!empty($customertypes)) {
				$custpermquery = (new QueryBuilder())->table('custindex')->field('custid, shiptoid')->where('typecode', $customertypes);
				$q->where('(custid, shiptoid)','in', $custpermquery);
			}
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

	function get_customer($custID, $shiptoID = false, $contactID = '', $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->where('custid', $custID);

		if ($shiptoID) {
			$q->where('shiptoid', $shiptoID);
			//$q->where('source', Contact::$types['customer-shipto']);
		} else {
			//$q->where('source', Contact::$types['customer']);
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
	/* =============================================================
		SALES HISTORY FUNCTIONS
	============================================================ */
		/**
		 * Returns if Sales Order is Sales History
		 * @param  string $ordn  Sales Order Number
		 * @param  bool   $debug Run in debug? IF so, return SQL query
		 * @return bool          Is Sales Order in Sales History?
		 */
		function is_ordersaleshistory($ordn, $debug = false) {
			$q = (new QueryBuilder())->table('saleshist');
			$q->field('COUNT(*)');
			$q->where('ordernumber', $ordn);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return $sql->fetchColumn();
			}
		}

		/**
		 * Returns the Customer ID from a Sales History Order
		 * @param  string $ordn  Sales Order Number
		 * @param  bool   $debug Run in debug? IF so, return SQL query
		 * @return string        Sales History Order Customer ID
		 */
		function get_custidfromsaleshistory($ordn, $debug = false) {
			$q = (new QueryBuilder())->table('saleshist');
			$q->field('custid');
			$q->where('ordernumber', $ordn);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return $sql->fetchColumn();
			}
		}

		function get_typecodescustomers($typecodes, $debug = false) {
			$q = (new QueryBuilder())->table('custindex');
			$q->where('typecode', $typecodes);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return $sql->fetchAll();
			}
		}

	/* =============================================================
		USER FUNCTIONS
	============================================================ */

		function does_userhavecustomer($loginID, $custID, $debug = false) {
			$q = (new QueryBuilder())->table('dpluso1.usercustomers'); //TODO: would only work when dpluso1 was added
			$q->field('COUNT(*)');
			$q->where('salesrep', $loginID);
			$q->where('custid', $custID);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return boolval($sql->fetchColumn());
			}
		}

		function add_usercustomer($loginID, $custID, $debug = false) {
			$q = (new QueryBuilder())->table('dpluso1.usercustomers'); //TODO: would only work when dpluso1 was added
			$q->mode('insert');
			$q->set('salesrep', $loginID);
			$q->set('custid', $custID);
			$q->set('date', date('Ymd'));
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return DplusWire::wire('dplusdatabase')->prepare($q->render());
			}
		}

		function remove_usercustomer($loginID, $custID, $debug = false) {
			$q = (new QueryBuilder())->table('dpluso1.usercustomers'); //TODO: would only work when dpluso1 was added
			$q->mode('delete');
			$q->where('salesrep', $loginID);
			$q->where('custid', $custID);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return DplusWire::wire('dplusdatabase')->prepare($q->render());
			}
		}
