<?php

Route::group(array('prefix'=>Config::get('aidkit::config.prefix')),function(){

	Route::get('/',function(){ return Redirect::route('dashboard'); });

	//Handle login stuff
	Route::controller('login','AidkitAuthController');

	// This is the Default admin/dashboard route
	// Route::get('dashboard',array('as'=>'dashboard','uses'=>'AidkitHomeController@showDashboard'));

});

