<?php namespace Codebryo\Aidkit;

class Aidkit {

	public function __construct() // or any other method
    {
        include 'helpers/readable_time.php'; // provides new function
        include 'helpers/html_macros.php'; // provides new functions
    }

	/**
	 * Generate a Readable Actionlog Message
	 *
	 * @param  object  $object
	 * @return string
	 */
	public function composeActionMessage($object)
	{
		return 'Readable Action Message!';
	}

	/**
	 * Generate a Readable Time Message
	 *
	 * @param  srring  $timestamp
	 * @return string
	 */
	public function composeReadableTime($timestamp)
	{
		return readableTime($timestamp); // function available in helpers/readable_time.php
	}

	/**
	 * Render the Basetag for the Backend
	 *
	 * @param  array  $navigation
	 * @return string
	 */
	public function renderBaseTag()
	{
		return renderBaseTag();
	}


	/**
	 * Render provided Errors if there are any
	 *
	 * @param  array  $errors
	 * @return string
	 */
	public function renderErrors($errors)
	{
		if($errors->any())
			return renderErrors($errors);
		else
			return '';
	}

	/**
	 * Render the Navigation for the Backend
	 *
	 * @param  array  $navigation
	 * @return string
	 */
	public function renderNavigation(array $navigation)
	{
		return renderNavigation($navigation);
	}


	

}