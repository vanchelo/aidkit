<?php

/*
 *
 * The Global Start File for Aidkit to set some Basic Instructions I don't think I could place somewhere better
 * @author: Romane Kuba
 *
 */

/*
 * ------------------------------------------------------
 * View related Settings
 * ------------------------------------------------------
 */


/*
 *
 * Aidkit provides a new Namespace for all the views that are stored in the /views_admin Folder
 * This will help you keep a clean sepearation of frontend and backend views.
 * This views may be called like so
 *
 * View::make('admin::dashboard'); 
 *
 * This will load the /app/views_admin/dashboard.blade.php File
 * 
 */

View::addNamespace('admin', app_path().'/views_admin');


/*
 *
 * Share some values through every view without loading it everytime
 *
 */

View::share('title',Config::get('aidkit::config.title')); // $title will return the value provided in the configuration File


/*
 * ------------------------------------------------------
 * Routes related Settings
 * ------------------------------------------------------
 */

/*
 *
 * Aidkit also sperates your backend routes from the rest of the route files.
 * All available routes should be placed in routes_admin.php and are automaticaly prefixed 
 * with the urlprefix Value stored in the configuration File
 */

Route::group(array('prefix'=>Config::get('aidkit::config.urlprefix')),function(){

	if(File::exists(app_path().'/routes_admin.php')) include app_path().'/routes_admin.php';
	
});

/*
 *
 * Aidkit also provided a custom adminauth Filter to return you to the correct login Area by default.
 *
 */

Route::filter('adminauth', function()
{
	if (Auth::guest()) return Redirect::guest(Config::get('aidkit::config.urlprefix').'/login');
});
