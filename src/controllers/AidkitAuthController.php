<?php

class AidkitAuthController extends AidkitController {

	// Show the Login Mask
	public function getIndex()
	{
		return View::make('aidkit::login');
	}

	public function postIndex()
	{
		if(Auth::attempt(array('username' => Input::get('username'),'password'=>Input::get('password')))) return Redirect::route('dashboard');

		return View::make('aidkit::login')->with('status','failed');
	}

	public function logout()
	{
		
		Auth::logout(); 
		Session::flush();

		return Redirect::to('/');

	}
}