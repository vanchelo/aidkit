<?php namespace Codebryo\Aidkit\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


use \File;

/**
 * Class ExtensionCommand
 *
 * For reference : http://net.tutsplus.com/tutorials/php/your-one-stop-guide-to-laravel-commands/
 *
 * @package Codebryo\Aidkit\Commands
 */
class ExtensionCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aidkit:extension';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add additional features to Aidkit';

    protected static $extensionPath;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        static::$extensionPath = __DIR__.'/../../../../extensions';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $name = $this->argument('name');

        if ( $this->confirm("Are you sure you want to install Aidkit extension '".$name."'? [yes|no]", true))
        {
            $mode = $this->option('mode', 'install');

            if( is_null($mode) || 'install' == $mode )
            {
                return $this->installExtension( $name );
            }
            else
            {
                return $this->updateExtension( $name );
            }
        }

        return $this->info('Aidkit extension installation canceled!');
    }


    public function installExtension( $name )
    {
        if( File::exists( static::$extensionPath.'/'.$name) )
        {
            if ( $this->confirm("Extension '".$name."' already exists, update instead? [yes|no]", true))
            {
                return $this->updateExtension( $name );
            }
        }

        if( File::isWritable( static::$extensionPath ) ){
            //get contents

            //on success create directory
            File::makeDirectory( static::$extensionPath.'/'.$name);

            //move files to the directory

            // run the commands from the installation file.

            return $this->info( 'Aidkit installation in development');
        }else{
            return $this->info( 'Aidkit extensions path is not writable');
        }
    }


    public function updateExtension( $name )
    {
        if ( $this->confirm("Updating an extension will override your own changes. Proceed? [yes|no]", true))
        {
            // delete the folder within extension folder.
            File::delete( static::$extensionPath.'/'.$name );

            // jump back to installation
            return $this->installExtension( $name );
        }
    }


    public function finishInstallation()
    {
        $this->call('dump-autoload'); // Lets make Extension recognized by Laravel

        return $this->info('Aidkit extension installation complete!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the desired extension'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('mode', null, InputOption::VALUE_OPTIONAL, 'The mode the script needs to rum in, by default : install')
        );
    }
}