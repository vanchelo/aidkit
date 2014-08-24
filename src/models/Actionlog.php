<?php

class Actionlog extends Eloquent
{
	public $timestamps = false;

	protected $guarded = [];

	public function medic()
	{
		return $this->belongsTo('Medic');
	}

	public static function getRecentUserActions($medicId)
	{
		return self::where('medic_id', $medicId)
			->orderBy('created_at', 'desc')
			->with('medic')
			->take(10)->get();
	}
}
