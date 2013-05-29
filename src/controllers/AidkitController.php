<?php 

class AidkitController extends Controller {

	protected $layout = 'layout';

	protected function setupLayout()
	{
		if(Config::get('aidkit::config.layout'))
			$this->layout = View::make('admin::'.Config::get('aidkit::config.layout'));
		else
			$this->layout = View::make('aidkit::'.$this->layout);

		$this->layout->nest('navigation','aidkit::partials.navigation');
	}
}