<?php

class Actionlog extends Eloquent {

	public $timestamps = false;

	protected $guarded = array();

	protected $actions  = array(
		'c' => 'created',
		'd' => 'deleted',
		'u' => 'updated'
	);

}