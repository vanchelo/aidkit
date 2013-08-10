<?php

return array(

	'navigation' => array(

		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'url' => route('dashboard'),
		),
		'admins' => array(
			'icon' 	=> 'icon-user',
			'url'	=> route('admin.admins.index'),
			'role'	=> 1,
			
			'sub-menu' => array(
				'create' => array(
					'title' => 'New Admin',
					'url' 	=> route('admin.admins.create')
				)	
			)
			
		),
		
	)

);