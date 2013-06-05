<?php

Route::group(array('prefix'=>Config::get('aidkit::config.prefix')),function(){

	Route::get('/',function(){ return Redirect::route('dashboard'); });

	//Handle login stuff
	Route::controller('login','AidkitAuthController');

	Route::get('logout','AidkitAuthController@logout');

});

