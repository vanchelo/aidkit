<?php

// Add a namespace for the views so they can get reachted easy

View::addNamespace('admin', app_path().'/views_admin');


//TODO: put View share to extra files

View::share('title',Config::get('aidkit::config.title'));


include 'macros.php';
include 'functions.php';