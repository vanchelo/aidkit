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

View::addNamespace('aidkit', app_path().'/Aidkit/views');


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

	Config::set('auth.model', Config::get('aidkit::auth.model'));
    Config::set('auth.table', Config::get('aidkit::auth.table'));

	if(File::exists(app_path().'/Aidkit/routes.php')) include app_path().'/Aidkit/routes.php';

});

/*
 *
 * Aidkit also provided a custom adminauth Filter to return you to the correct login Area by default.
 *
 */

Route::filter('aidkitauth', function()
{
	if (Auth::guest() || get_class(Auth::user()) != Config::get('aidkit::auth.model')) return Redirect::guest(Config::get('aidkit::config.urlprefix').'/login');
});

/*
 *
 * Catch the Not found error for Admin Routes
 *
 */

App::missing(function($exception)
{
	return View::make('aidkit::errors/missing');
});

/*
 *
 * Listen To certain Events throught Aidkit
 *
 */

Event::listen('aidkit.login', function($medic)
{
	$medic->lockEvents = true;

    $medic->last_login = $medic->freshTimestamp();

    $medic->save();

});

