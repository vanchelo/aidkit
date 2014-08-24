<?php namespace Codebryo\Aidkit;

class Aidkit
{
	public function __construct() // or any other method
	{
		include 'helpers/readable_time.php'; // provides new function
		include 'helpers/html_macros.php'; // provides new functions
		include 'helpers/compose_macros.php'; // provides new functions
	}

	/**
	 * Generate a Readable Actionlog Message
	 *
	 * @param object $object
	 * @return string
	 */
	public function composeActionMessage($object)
	{
		return composeActionMessage($object);
	}

	/**
	 * Generate a Readable Time Message
	 *
	 * @param  string $timestamp
	 * @return string
	 */
	public function composeReadableTime($timestamp)
	{
		return readableTime($timestamp); // function available in helpers/readable_time.php
	}

	/**
	 * Render the Basetag for the Backend
	 *
	 * @return string
	 */
	public function renderBaseTag()
	{
		return renderBaseTag();
	}

	/**
	 * Render provided Errors if there are any
	 *
	 * @param  array $errors
	 * @return string
	 */
	public function renderErrors($errors)
	{
		if ($errors->any())
		{
			return renderErrors($errors);
		}

		return '';
	}

	/**
	 * Render the Navigation for the Backend
	 *
	 * @param  array $navigation
	 * @return string
	 */
	public function renderNavigation(array $navigation)
	{
		return renderNavigation($navigation);
	}

	/**
	 * Render Radiobuttons for configured roles
	 *
	 * @param  array $roles
	 * @param  int $currentRole
	 * @return string
	 */
	public function renderRoleSelection(array $roles, $currentRole = 0)
	{
		return renderRoleSelection($roles, $currentRole);
	}
}
