<?php

return array(

	/*
	*
	*	Defined Paramters for the Navigation Elements
	*	icon: Name of the Icon that should be used
	*	url:  Define the url that this link should call, the prefix will be attached by aidkit
	*	route: If you don't want to use url you can attach a route !NOTE: url will have priority to route
	*
	*/
	'navigationPoints' => array(
	'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'route' => 'dashboard'
		),
	'login' => array(
			'icon' 	=> 'icon-signin',
			'url'	=> 'admin/login'
		)
	)

	
);