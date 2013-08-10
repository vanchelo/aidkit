<?php

return array(

	// Give your Backend a Name
	'title' 		=> 'Aidkit',

	// What prefix shall be used for all the Generated urls
	'urlprefix' 	=> 'admin',

	// For constructing the Views a default layout file is provided
	'layout'		=> 'layout.master',

	// There is also a login View provided
	'login'			=> 'layout.login',

	// Feel free to add roles as you need throught the Application.
	// i.e. Create a role that only has access to a specific area of the website
	'roles'			=> array(
		1	=> array(
				'title' => 'superadmin',
				'desc' 	=> 'Should be able to access any part of the Application'
			),
		2	=> array(
				'title' => 'administrator',
				'desc'	=> 'Should only be able to access certain parts of the Application'
			)
	)
	
);