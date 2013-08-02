Aidkit
======

The "Admin Interface Development Kit" for [Laravel](http://www.laravel.com)

You can find a full documentation on *Adikit* [here](http://codebryo.github.io/aidkit/index.html)

http://codebryo.github.io/aidkit/img/screen1.png

## New Features

- Missing Page - If you enter a wrong url or so you'll see a beautiful 404 Page [Preview](http://dribbble.com/shots/1180575-Aidkit-404-Page?list=following)

- Facade Support
	- **Compose:**
		- `Aidkit::composeActionMessage($actioon)` - Will return a well formatted string based on the Action provided
		- `Aidkit::composeReadableTime($timestamp)` - Will create easy to read times out of PHP or UNIX Timestamps (i.e. 2013-07-18 09:31:21 => Thursday at 9:31 am ) 
	- **Render:**
		- `Aidkit::renderBaseTag()` - Generates the HTML5 Base tag including the Value for the Backend defined in the Configfile
		- `Aidkit::renderErrors($errors)` - If there are any errors the will be nicely renderd as listitems in a unordered list
		- `Aidkit::renderNavigation($array)` - Will return a HTML rendered version of the navigation array. By default you may want to load the Navigation from the configfile like `Config::get('aidkit::navigation.navigation')`


Latest Stable:
- ... not yet

## Some Screens

![Screen 1](http://codebryo.github.io/aidkit/img/screen1.png)

![Screen 2](http://codebryo.github.io/aidkit/img/screen2.png)
