<?php

class Actionlog extends Eloquent {

	public $timestamps = false;

	protected $guarded = array();


    public static function readableActions()
    {
        return self::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->take(10)->get();
    }
}