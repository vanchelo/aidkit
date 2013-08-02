<?php namespace Codebryo\Aidkit\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Aidkit extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'aidkit'; }

}
