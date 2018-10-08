<?php
	class EditSalesOrdersDisplay extends SalesOrdersDisplay  {
		
		/* =============================================================
			Class Functions
		============================================================ */
		public function get_order($debug = false) {
			return get_orderhead($this->sessionID, $this->ordn, $debug);
		}

		/**
		 * Returns Sales Order Details
		 * @param  Order  $order SalesOrder
		 * @param  bool   $debug Whether to execute query and return Sales Order Details
		 * @return array        SalesOrderDetails Array | SQL Query
		 */
		public function get_orderdetails(Order $order, $debug = false) {
			return get_orderdetails($this->sessionID, $order->orderno, $debug);
		}

	}
