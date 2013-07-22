<?php 

class AidkitModel extends Eloquent {

	/*
	 *
	 * Store Error Messages in here
	 *
	 */
	public $errors;

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
            return Actionlog::create(array( 'user_id' => Auth::user()->id, 'action' => 'created','object' => get_class($model),'object_id' => $model->getKey(), 'created_at' => date('Y-m-d H:i:s') ));
        });

        static::updated(function($model)
        {
            return Actionlog::create(array( 'user_id' => Auth::user()->id, 'action' => 'updated','object' => get_class($model),'object_id' => $model->getKey(), 'created_at' => date('Y-m-d H:i:s') ));
        });

        static::deleted(function($model)
        {
            return Actionlog::create(array( 'user_id' => Auth::user()->id, 'action' => 'deleted','object' => get_class($model),'object_id' => $model->getKey(), 'created_at' => date('Y-m-d H:i:s') ));
        });

    }

    public function validate()
    {
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