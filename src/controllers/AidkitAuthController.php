<?php

class AidkitAuthController extends AidkitController {

	// Show the Login Mask
	public function getIndex()
	{
		return View::make('aidkit::login');
	}

	public function postIndex()
	{
		return 'Login attempt';
	}
}