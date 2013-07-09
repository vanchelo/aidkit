<?php

function actionMessage($object){
	$str = 'You have ' . $object->action .' the ' . $object->object . ' with ID ' . $object->object_id;

	return $str;
}