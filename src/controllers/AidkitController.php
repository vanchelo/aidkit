<?php

class AidkitController extends Controller {

	/**
	 * The Basic Layout File. Can be overwritten by a configvalue
	 *
	 * @var string
	 */
	protected $layout = null;

	/**
	 * The Aidkit Controller can parse together your Layout similiar to the BaseController
	 * included in L4 by default. But it takes care of including the correct layout
	 *
	 * @return void
	 *
	 */
	protected function setupLayout()
	{

		// Provide the Layoutview depending on the Config Value
		$this->layout = View::make('admin::'.Config::get('aidkit::config.layout');

	}
}