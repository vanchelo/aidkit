<?php

// Macros for generating Aidkit Elements

// Generate Navigation

HTML::macro('aidkitNavigation',function($array){

	// The html Element that will be returned after parsing the array
	$html = '';

	foreach ( $array as $item=>$attributes){
		
		// Set the title of the navigation point
		$title = (isset($attributes['title']) ? $attributes['title'] : $item );

		// if a icon is passed to the array a icon tag will be created
		$icon = (isset($attributes['icon']) ? sprintf('<i class="%s"></i>',$attributes['icon']) : null );
		// pass together the whole anchor tag
		$anchor = sprintf('<a href="%s">%s%s</a>',$attributes['url'],$icon,$title);
		
		// Check if there is a submenu. If Yes, run that itself through this macro
		$submenu = (isset($attributes['sub-menu']) ? sprintf('<ul class="sub-menu">%s</ul>',HTML::aidkitNavigation($attributes['sub-menu'])) : null );
		
		// Check for the current URL if it matches any Anchors
		$class = '';
		if(strstr(Request::fullUrl(),$attributes['url']))
			$class = 'class="on"';

		// and wrap it into the listitem
		$html .= sprintf('<li %s>%s%s</li>',$class,$anchor,$submenu);

	}

	// Pass back the entire navigation list
	return $html;
});

HTML::macro('aidkitErrors',function($errors){
	$html = '';
	if ($errors->any()):
		$html = implode('', $errors->all('<li><i class="icon-remove"></i> :message</li>'));
		$html = sprintf('<ul class="errors animated pulse">%s</ul>',$html);
	endif;
	return $html;
});

HTML::macro('aidkitBaseTag',function(){

	$url =  url('/'.Config::get('aidkit::config.urlprefix'));
	return sprintf('<base href="%s">',$url);

});

// Turn Timestamps or DateTimes to beautiful Readable Dates like: 10 Seconds ago, in 4 days, ...
HTML::macro('aidkitReadableTime',function($timestamp){
	if( is_numeric($timestamp) && (int)$timestamp == $timestamp )
		$timestamp = $timestamp;
	else
		$timestamp = strtotime($timestamp);

	
	// Get time difference and setup arrays
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years");
	$lengths = array("60","60","24","7","4.35","12");
 
	// Past or present
	if ($difference >= 0) 
	{
		$ending = "ago";
	}
	else
	{
		$difference = -$difference;
		$ending = "to go";
	}
 
	// Figure out difference by looping while less than array length
	// and difference is larger than lengths.
	$arr_len = count($lengths);
	for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)
	{
		$difference /= $lengths[$j];
	}
 
	// Round up		
	$difference = round($difference);
 
	// Make plural if needed
	if($difference != 1) 
	{
		$periods[$j].= "s";
	}
 
	// Default format
	$text = "$difference $periods[$j] $ending";
 
	// over 24 hours
	if($j > 2)
	{
		// future date over a day formate with year
		if($ending == "to go")
		{
			if($j == 3 && $difference == 1)
			{
				$text = "Tomorrow at ". date("g:i a", $timestamp);
			}
			else
			{
				$text = date("F j, Y \a\\t g:i a", $timestamp);
			}
			return $text;
		}
 
		if($j == 3 && $difference == 1) // Yesterday
		{
			$text = "Yesterday at ". date("g:i a", $timestamp);
		}
		else if($j == 3) // Less than a week display -- Monday at 5:28pm
		{
			$text = date("l \a\\t g:i a", $timestamp);
		}
		else if($j < 6 && !($j == 5 && $difference == 12)) // Less than a year display -- June 25 at 5:23am
		{
			$text = date("F j \a\\t g:i a", $timestamp);
		}
		else // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
		{
			$text = date("F j, Y \a\\t g:i a", $timestamp);
		}
	}
 
	return $text;
});