<?php

return array(

	'navigation' => array(

		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'url' => route('dashboard'),
		),
		'users' => array(
			'icon' 	=> 'icon-user',
			'url'	=> route('admin.users.index'),
			
			'sub-menu' => array(
				'create' => array(
					'title' => 'New User',
					'url' 	=> route('admin.users.create')
				)	
			)
			
		),
		
	)

);