<?php

return array(

	/*
	*
	*	Defined Paramters for the Navigation Elements
	*	icon: Name of the Icon that should be used
	*	url:  Define the url that this link should call
	*
	*/
	'navigation' => array(

		'area:sections' => array(
			'class' => 'yellow'
		),
		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'url' => URL::route('dashboard')
		),
		'users' => array(
			'icon' 	=> 'icon-user',
			'url'	=> URL::route('admin.users.index'),
			'sub-menu' => array(
				'create' => array(
					'icon' 	=> 'icon-plus',
					'url' 	=> URL::route('admin.users.create')
				)	
			)
		),
		'area:logout' => array(
			'class' => 'red logout'
		),
		'logout' => array(
			'icon' 	=> 'icon-off',
			'url'	=> URL::to('admin/logout')
		),

	)

	
);