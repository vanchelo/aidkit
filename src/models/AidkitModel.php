<?php 

class AidkitModel extends Eloquent {

	/*
	 *
	 * Store Error Messages in here
	 *
	 */
	public $errors;


    /**
     *
     * Public Handler
     *
     *
     */
    public static $actionlogObjectName = null;


    /**
     *
     * Public Handler
     *
     *
     */
    public static $actionlogField = 'id';

    public $lockEvents = false;


    public static function boot()
    {
        parent::boot();

        // Setup event bindings...

        // Listen to the Saving Event
        static::saving(function($model)
    	{
    		return $model->validate();	
    	});

        static::created(function($model)
        {
            return static::createActionlogEntry('created',$model);
        });

        static::updated(function($model)
        {
            return static::createActionlogEntry('updated',$model);
        });

        static::deleted(function($model)
        {
            return static::createActionlogEntry('deleted',$model);
        });

        static::restored(function($model)
        {
            return static::createActionlogEntry('restored',$model);
        });
    }

    public function eventsLocked()
    {
        return $this->lockEvents;
    }

    
    protected static function createActionlogEntry($action, $model)
    {
        if($model->eventsLocked() == true) return false;

        $actionlog = new Actionlog;

        $actionlog->medic_id = Auth::user()->id;
        $actionlog->action = $action;
        $actionlog->object = get_class($model);
        $actionlog->object_id = $model->getKey();
        $actionlog->created_at = $model->freshTimestamp();

        return $actionlog->save();
    }


    protected function validate()
    {
        if($this->eventsLocked() == true) return true;

        // Replace all the @id places with the actual ID of the user
        $rules = static::$rules;

        foreach($rules as $key=>$value){
            if(!isset($this->attributes['id']))
                $rules[$key] = str_replace(",@id",'',$value); // If there is no id set remove this placeholder from the validation
            else
                $rules[$key] = str_replace("@id", $this->attributes['id'],$value);
        }
        
    	$validation = Validator::make($this->attributes,$rules);

    	if ($validation->passes()) return true;

    	$this->errors = $validation->messages();

    	return false;
    }
}