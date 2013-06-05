<?php

// Macros for gernerating Aidkit Elements

// Generate Navigation

HTML::macro('aidkitNavigation',function($array){

	// The html Element that will be returned after parsing the array
	$html = '';

	foreach ( $array as $item=>$attributes){

		// Check if there are semicolons in the string
		$item = explode(':',$item);
		// If there was no semicolon build a navigation Element
		if (sizeof($item) == 1):
			// if a icon is passed to the array a icon tag will be created
			$icon = (isset($attributes['icon']) ? sprintf('<i class="%s"></i>',$attributes['icon']) : null );
			// pass together the whole anchor tag
			$anchor = sprintf('<a href="%s">%s%s</a>',$attributes['url'],$icon,$item[0]);
			
			// Check if ther is a submenu. If Yes, run that itself through this macro
			$submenu = (isset($attributes['sub-menu']) ? sprintf('<ul class="sub-menu">%s</ul>',HTML::aidkitNavigation($attributes['sub-menu'])) : null );
			// and wrap it into the listitem
			$html .= sprintf('<li>%s%s</li>',$anchor,$submenu);
		else:
			if($item[0] == 'area'):
				$html .= sprintf('<li class="area %s">%s</li>',$attributes['class'],$item[1]);
			endif;
		endif;
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

