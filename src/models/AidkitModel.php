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

        static::saved(function($model)
        {
            return Actionlog::create('');
        });

        static::updating(function($model)
        {
            return $model->validate();
        });
    }

    public function validate()
    {
        // Replace all the @id places with the actual ID of the user
        $rules = static::$rules;

        foreach($rules as $key=>$value){
            $rules[$key] = str_replace("@id", $this->attributes['id'],$value);
        }
        
    	$validation = Validator::make($this->attributes,$rules);

    	if ($validation->passes()) return true;

    	$this->errors = $validation->messages();

    	return false;
    }

}