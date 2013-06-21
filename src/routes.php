<?php

Route::group(array('prefix'=>Config::get('aidkit::config.prefix')),function(){

	include app_path().'/routes_aidkit.php';
});

