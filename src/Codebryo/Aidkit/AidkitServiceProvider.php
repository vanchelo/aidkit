<?php namespace Codebryo\Aidkit;

use Illuminate\Support\ServiceProvider;

class AidkitServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('codebryo/aidkit');

		include __DIR__.'/../../start/global.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		 $this->app['aidkit.install'] = $this->app->share(function($app)
        {
            return new Commands\InstallCommand();
        });
        
        $this->commands('aidkit.install');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}