<?php

if ( !function_exists('renderNavigation') )
{
    function renderNavigation(array $array)
    {
        // The html Element that will be returned after parsing the array
        $html = '';

        foreach ( $array as $item=>$attributes)
        {

            if(array_get($attributes,'role')) 
            {
                if( ! Auth::user()->hasAccessTo($attributes['role']))
                {
                    continue;
                }
            }

            // Set the title of the navigation point
            $title = (isset($attributes['title']) ? $attributes['title'] : $item );

            // if a icon is passed to the array a icon tag will be created
            $icon = (isset($attributes['icon']) ? sprintf('<i class="%s"></i>',$attributes['icon']) : null );
            // pass together the whole anchor tag
            $anchor = sprintf('<a href="%s">%s%s</a>',$attributes['url'],$icon,$title);

            // Check if there is a submenu. If Yes, run that itself through this macro
            $submenu = (isset($attributes['sub-menu']) ? sprintf('<ul class="sub-menu">%s</ul>',renderNavigation($attributes['sub-menu'])) : null );

            // Check for the current URL if it matches any Anchors
            $class = '';
            if(strstr(Request::fullUrl(),$attributes['url']))
                $class = 'class="on"';

            // and wrap it into the listitem
            $html .= sprintf('<li %s>%s%s</li>',$class,$anchor,$submenu);

        }

        // Pass back the entire navigation list
        return $html;
    }
}


if ( !function_exists('renderRoleSelection') )
{
    function renderRoleSelection($roles,$currentRole)
    {
       $html = '';

       foreach($roles as $roleID => $attributes)
       {
            // Check if the currentRole is the same as the roleID
            $checked = ($currentRole == $roleID ? 'checked' : null);

            // Build the input
            $input = sprintf('<input type="radio" id="role[%s]" name="role" value="%s" %s>',$roleID,$roleID,$checked);
            // Wrap it together into the label and pass it to the html Element
            $html .= sprintf('<label for="role[%s]" class="pure-radio">%s</label>',$roleID,$input.ucfirst($attributes['title']));
       }

       return $html;
    }
}

if ( !function_exists('renderBaseTag') )
{
    function renderBaseTag()
    {
        $url =  url('/'.Config::get('aidkit::config.urlprefix'));

        return sprintf('<base href="%s">',$url);
    }
}


if ( !function_exists('renderErrors') )
{
    function renderErrors($errors)
    {
        $html = implode('', $errors->all('<li><i class="icon-remove"></i> :message</li>'));
        $html = sprintf('<ul class="errors animated pulse">%s</ul>',$html);

        return $html;
    }
}
