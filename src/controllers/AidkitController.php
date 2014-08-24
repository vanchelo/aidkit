<?php

class AidkitController extends Controller
{
	/**
	 * The Basic Layout File. Can be overwritten by a configvalue
	 *
	 * @var string
	 */
	protected $layout = null;

	/**
	 * The Aidkit Controller can parse together your Layout similar to the BaseController
	 * included in L4 by default. But it takes care of including the correct layout
	 *
	 * @return void
	 *
	 */
	protected function setupLayout()
	{
		// Provide the Layoutview depending on the Config Value
		$this->layout = View::make('aidkit::' . Config::get('aidkit::config.layout'));
	}

	/**
	 * restore an soft-deleted item.
	 *
	 * @param $model
	 * @param $id
	 *
	 * @return URL Redirect
	 */
	public function restore($model, $id)
	{
		$model = ucfirst($model);

		$item = $model::onlyTrashed()->findOrFail($id);

		if (null != $item)
		{
			$item->restore();
		}

		return Redirect::to(URL::previous());
	}

	/**
	 * Deletes an item from it's table.
	 *
	 * @param $model
	 * @param $id
	 *
	 * @return URL Redirect
	 */
	public function delete($model, $id)
	{
		$model = ucfirst($model);

		if (strtoupper(Input::get('delete')) == 'DELETE')
		{
			$user = $model::findOrFail($id);
			$user->delete();
		}

		return Redirect::to(URL::previous());
	}
}
