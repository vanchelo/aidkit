<?php 

class AidkitModel extends Eloquent {

    /**
     *
     * Store Error Messages in here
     *
     * @var array
     *
     */
    public $errors;


    /**
     *
     * Optional to provide a name for the current Class Object used by the Actionlog
     *
     * @var string
     */
    public static $actionlogObjectName = null;


    /**
     *
     * What Column should be used for composing Actionlog messages
     *
     * @var string
     */
    public static $actionlogField = 'id';

    public $lockEvents = false;


    public static function boot()
    {
        parent::boot();

        // Setup event bindings...

        static::saving(function($model)
        {
            return $model->validate($model);    
        });

        static::created(function($model)
        {
            return $model::createActionlogEntry('created',$model);
        });

        static::updated(function($model)
        {
            return $model::createActionlogEntry('updated',$model);
        });

        static::deleted(function($model)
        {
            return $model::createActionlogEntry('deleted',$model);
        });

        static::restored(function($model)
        {
            return $model::createActionlogEntry('restored',$model);
        });
    }

    /**
     * Check if special Events on the Model should be exectured or not
     *
     * @return bool
     */
    public function eventsLocked()
    {
        return $this->lockEvents;
    }

    /**
     * Create a actionlog entry
     *
     * @return mixed
     */
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


    protected static function validate($model)
    {
        if($model->eventsLocked() == true) return true;

        // Replace all the @id places with the actual ID of the user
        $rules = $model::$rules;

        $attributes = $model->getAttributes();

        foreach($rules as $key=>$value){
            if(!isset($attributes['id']))
                $rules[$key] = str_replace(",@id",'',$value); // If there is no id set remove this placeholder from the validation
            else
                $rules[$key] = str_replace("@id", $attributes['id'],$value);
        }
        
        $validation = Validator::make($attributes,$rules);

        if ($validation->passes()) return true;

        $model->errors = $validation->messages();

        return false;
    }
}