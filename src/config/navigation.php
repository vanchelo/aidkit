<?php

return array(

	'navigation' => array(

		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'url' => route('dashboard'),
		),
		'medics' => array(
			'icon' 	=> 'icon-user',
			'url'	=> route(Config::get('aidkit::config.urlprefix').'.medics.index'),
			'role'	=> 1,
			
			'sub-menu' => array(
				'create' => array(
					'title' => 'New Medic',
					'url' 	=> route(Config::get('aidkit::config.urlprefix').'.medics.create')
				)	
			)
			
		),
		
	)

);