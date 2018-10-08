<?php
	class SalesOrdersDisplay extends SalesOrderPanel  {

        public function __construct($sessionID, \Purl\Url $pageurl, $modal, $loadinto, $ajax) {
			parent::__construct($sessionID, $pageurl, $modal, $loadinto, $ajax);
			$this->pageurl = new Purl\Url($pageurl->getUrl());
			$this->setup_pageurl();
		}

        /* =============================================================
			OrderPanelInterface Functions
			LINKS ARE HTML LINKS, AND URLS ARE THE URLS THAT THE HREF VALUE
		============================================================ */
		public function setup_pageurl() {
			$this->pageurl->query->remove('display');
		}

		public function generate_loaddetailsurl(Order $order) {
			$url = new \Purl\Url(DplusWire::wire('pages')->get('/user/orders/redir/')->url);
			$url->query->set('action', 'get-order-details');
			$url->query->set('ordn', $order->orderno);
			return $url->getUrl();
		}


		/* =============================================================
			Class Functions
		============================================================ */
		public function get_order($debug = false) {
			return get_orderhead($this->sessionID, $this->ordn, $debug);
		}

		public function get_orders($debug = false) {
			$useclass = true;
			$this->tablesorter->sortrule = 'DESC';
			$orders = get_userordersorderdate($this->sessionID, DplusWire::wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->filters, $this->filterable, $useclass, $debug);
			return $debug ? $orders : $this->orders = $orders;
		}

		public function get_ordercount($debug = false) {
			$count = count_userorders($this->sessionID, $this->filters, $this->filterable, $debug);
			return $debug ? $count : $this->count = $count;
		}
	}
