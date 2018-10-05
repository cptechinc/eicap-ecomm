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
	}
