<?php

return array(

	'navigation' => array(

		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'route' => 'dashboard'
		),
		'users' => array(
			'icon' 	=> 'icon-user',
			'route'	=> 'admin.users.index',
			
			'sub-menu' => array(
				'create' => array(
					'icon' 	=> 'icon-plus',
					'route' 	=> 'admin.users.create'
				)	
			)
			
		),
		'logout' => array(
			'icon' 	=> 'icon-off',
			'url'	=> 'admin/logout'
		),

	)

);