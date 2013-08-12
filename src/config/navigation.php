<?php

return array(

	'navigation' => array(

		'dashboard' => array(
			'icon' 	=> 'icon-dashboard',
			'url' => route('dashboard'),
		),
		'medics' => array(
			'icon' 	=> 'icon-user',
			'url'	=> route('aidkit.medics.index'),
			'role'	=> 1,
			
			'sub-menu' => array(
				'create' => array(
					'title' => 'New Medic',
					'url' 	=> route('aidkit.medics.create')
				)	
			)
			
		),
		
	)

);