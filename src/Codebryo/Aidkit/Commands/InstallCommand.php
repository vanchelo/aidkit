<?php namespace Codebryo\Aidkit\Commands;

use Illuminate\Console\Command;
use \File;

class InstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aidkit:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get started using Aidkit';

    protected static $templatePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        static::$templatePath = __DIR__.'/../../../../templates';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if(File::exists(app_path().'/Aidkit/views'))
            return $this->error('Aidkit seems to be installed already! Delete the app/Aidkit/views Folder to enable the Installation.');

        // To prevent Errors create necessary Folders first
        $this->createFolders();
            $this->info('Basic Folder Structure has been created');

        // Next calls are logically ordered ( at least in my logic :P )

        $this->createControllers();
            $this->info('Basic Controllers have been created');

        $this->createModels();
            $this->info('Basic Models have been created');

        $this->createViews();
            $this->info('Basic Views have been created');
        
        $this->createRoutes();
            $this->info('New Administrative Routes have been created');

        $this->createSeed();
            $this->info('UserTableSeeder created');

        // Call some other Functions
        $this->call('config:publish',array('package'=>'codebryo/aidkit'));
        $this->call('asset:publish',array('package'=>'codebryo/aidkit'));

        $this->call('dump-autoload'); // Lets make Aidkit recognized by Laravel

        return $this->info('Aidkit Installation complete!');
    }

    /**
     * Create the basic folter Structure.
     *
     * @return void
     */
    protected function createFolders()
    {
        // Define all the Folders that should be created relative to the app_path();
        $folders = array(
            'Aidkit',
            'Aidkit/controllers',
            'Aidkit/models',
            'Aidkit/routes',
            'Aidkit/views',
            'Aidkit/views/errors',
            'Aidkit/views/js-views',
            'Aidkit/views/layouts',
            'Aidkit/views/layouts/partials',
            'Aidkit/views/resources',
            'Aidkit/views/resources/medics',
        );

        foreach($folders as $folder)
        {
            echo $folder;
            File::makeDirectory(app_path().'/'.$folder);
        }
    }

    /**
     * Create a some Controllers.
     *
     * @return void
     */
    protected function createControllers()
    {
        $templatePath = static::$templatePath;

        $controllers = array(
            'AuthController',
            'HomeController',
            'MedicsController',
        );

        foreach($controllers as $controller)
        {
            File::put(app_path().'/Aidkit/controllers/Aidkit'.$controller.'.php',File::get($templatePath.'/controllers/'.$controller.'.txt'));
        }

    }

     /**
     * Create a some Models.
     *
     * @return void
     */
    protected function createModels()
    {
        $templatePath = static::$templatePath;

        $models = array(
            'Medic'
        );

        foreach($models as $model)
        {
            File::put(app_path().'/Aidkit/models/'.$model.'.php',File::get($templatePath.'/models/'.$model.'.txt'));
        }

    }

    /**
     * Create the provided views.
     *
     * @return void
     */
    protected function createViews()
    {
        $templatePath = static::$templatePath;

        $views = array(
            'layouts/master',
            'layouts/login',              
            'layouts/partials/navigation',
            'dashboard',
            'errors/missing',
            'js-views/delete',    
            'resources/medics/index',
            'resources/medics/show',
            'resources/medics/edit',
            'resources/medics/create',
        );

        foreach($views as $view)
        {
            File::put(app_path().'/Aidkit/views/'.$view.'.blade.php',File::get($templatePath.'/views/'.$view.'.txt'));
        }
    }

    /**
     * Create the routes_admin.php File for clean Route structure.
     *
     * @return void
     */
    protected function createRoutes()
    {
        $templatePath = static::$templatePath;

        File::put(app_path().'/Aidkit/routes.php',File::get($templatePath.'/routes.txt'));

    }

    /**
     * Create a basic Seed File for the Admin User.
     *
     * @return void
     */
    protected function createSeed()
    {
        $templatePath = static::$templatePath;
        $str_to_insert = '$this->call(\'MedicsTableSeeder\');';
        $seeder = File::get(app_path().'/database/seeds/DatabaseSeeder.php');
        $pos = strpos($seeder,'}');
        $newSeeder = substr($seeder, 0, $pos) . PHP_EOL . $str_to_insert . PHP_EOL . substr($seeder, $pos);
        File::put(app_path().'/database/seeds/DatabaseSeeder.php',$newSeeder);
        File::put(app_path().'/database/seeds/MedicsTableSeeder.php',File::get($templatePath.'/seed.txt'));
    }
}