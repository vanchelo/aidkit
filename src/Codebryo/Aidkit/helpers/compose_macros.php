<?php

if ( ! function_exists('composeActionMessage'))
{
	function composeActionMessage($object)
	{
		if (is_object($object))
		{
			$model = ucfirst($object->object);

			if (class_exists($model))
			{
				$item = $model::withTrashed()->select($model::$actionlogField . ' AS name')->whereId($object->object_id)->first();

				$objectName = (is_null($model::$actionlogObjectName) ? $model : $model::$actionlogObjectName);

				if ( ! is_null($item))
				{
					return sprintf('<strong>%s</strong> with %s <strong>%s</strong>', $objectName, $model::$actionlogField, $item->name);
				}
			}
		}

		return '';
	}
}
