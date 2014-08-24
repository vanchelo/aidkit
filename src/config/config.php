<?php

return [

	// Give your Backend a Name
	'title' => 'Aidkit',

	// What prefix shall be used for all the Generated urls
	'urlprefix' => 'aidkit',

	// For constructing the Views a default layout file is provided
	'layout' => 'layouts.master',

	// There is also a login View provided
	'login' => 'layouts.login',

	// Feel free to add roles as you need throught the Application.
	// i.e. Create a role that only has access to a specific area of the website
	'roles' => [
		1 => [
			'title' => 'Dr. House',
			'desc' => 'Should be able to access any part of the Application.'
		],
		2 => [
			'title' => 'Medic',
			'desc' => 'Should only be able to access certain parts of the Application'
		]
	]

];
