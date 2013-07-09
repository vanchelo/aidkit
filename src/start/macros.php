<?php

// Macros for gernerating Aidkit Elements

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
		
		// Check if ther is a submenu. If Yes, run that itself through this macro
		$submenu = (isset($attributes['sub-menu']) ? sprintf('<ul class="sub-menu">%s</ul>',HTML::aidkitNavigation($attributes['sub-menu'])) : null );
		
		// Check for the current URL if it matches any Anchors
		$class = '';
		if(strstr(Request::fullUrl(),$attributes['url']))
			$class = 'class="on"';

		// and wrap it into the listitem
		$html .= sprintf('<li %s>%s%s</li>',$class,$anchor,$submenu);

	}

	// Pass back the entire naviation list
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