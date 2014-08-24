<?php

return [

	'navigation' => [

		'dashboard' => [
			'icon' => 'icon-dashboard',
			'url' => route('dashboard'),
		],

		'medics' => [
			'icon' => 'icon-user',
			'url' => route(Config::get('aidkit::config.urlprefix') . '.medics.index'),
			'role' => 1,

			'sub-menu' => [
				'create' => [
					'title' => 'New Medic',
					'url' => route(Config::get('aidkit::config.urlprefix') . '.medics.create')
				]
			]
		],

	]

];
