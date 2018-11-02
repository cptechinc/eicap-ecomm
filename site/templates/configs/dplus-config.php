<?php 
	$config->user_roles = array(
		'default' => array(
			'dplus-code' => '',
			'label' => 'Default'
		),
		'sales-manager' => array(
			'dplus-code' => 'slsmgr',
			'label' => 'Sales Manager'
		),
		'sales-rep' => array(
			'dplus-code' => 'slsrep',
			'label' => 'Sales Rep'
		),
		'admin' => array(
			'dplus-code' => 'admin',
			'label' => 'Admin'
		),
	);
	
	$config->dplus_dplusoroles = array(
		'slsrep' => 'sales-rep',
		'slsmgr' => 'sales-manager',
		'whse'   => 'warehouse',
		'admin'  => 'admin'
	);
