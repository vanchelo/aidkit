<?php

class Actionlog extends Eloquent {

	public $timestamps = false;

	protected $guarded = array();

	public function admin()
	{
		return $this->belongsTo('Admin');
	}

    public static function getRecentUserActions($adminID)
    {
        return self::where('admin_id',$adminID)->orderBy('created_at','desc')->with('admin')->take(10)->get();
    }
}