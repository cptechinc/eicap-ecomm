<?php
    $cartdisplay = new CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();
	
	if (!empty($cart->custid)) {
		$page->title = "Cart for ".get_customername($cart->custid);
	} else {
		$input->get->function = 'cart';
		$page->title = "Choose a Customer";
		
	}
	
	include('./_include-page.php');
?>
