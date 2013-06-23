Laravel Aidkit
======

Laravel Admin Interface Development Kit

## Installation

For getting started using Laravel Aidkit
add following line to the `required` section in your composer.json file:

`
"codebryo/aidkit": "dev-master"
`

Install this Package calling `composer update` from your command-line.

After the Installation has finished add following line to your ServiceProviders listed in `app/config/app.php`

` 'Codebryo\Aidkit\AidkitServiceProvider' `

After that you have a new command available through artisan. Type `artisan aidkit:install` to get started right away.
This process will create some necessary Files, publish some basic assets and config Files. 

All Files will be available in your `/app` Folder. So feel free to edit them at will.