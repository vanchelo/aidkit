<?php 

class AidkitController extends Controller {

	/**
	 * The Basic Layout File. Can be overwritten by a configvalue
	 *
	 * @var string
	 */
	protected $layout = 'layout';

	/**
	 * The Aidkit Controller can parse together your Layout similiar to the BaseController
	 * included in L4 by default. But it takes care of including the correct layout
	 *
	 * @return void
	 *
	 */
	protected function setupLayout()
	{
		if(Config::get('aidkit::config.layout'))
			$this->layout = View::make('admin::'.Config::get('aidkit::config.layout'));
		else
			$this->layout = View::make('aidkit::'.$this->layout);

		$this->layout->nest('navigation','aidkit::partials.navigation');
	}
}