<?php

// Add a namespace for the views so they can get reached easy

View::addNamespace('admin', app_path().'/views_admin');


//TODO: put View share to extra files

View::share('title',Config::get('aidkit::config.title'));

// Route Grouping created
Route::group(array('prefix'=>Config::get('aidkit::config.urlprefix')),function(){

	if(File::exists(app_path().'/routes_admin.php')) include app_path().'/routes_admin.php';
	
});

Route::filter('adminauth', function()
{
	if (Auth::guest()) return Redirect::guest(Config::get('aidkit::config.urlprefix').'/login');
});