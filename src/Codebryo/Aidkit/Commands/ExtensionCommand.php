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
    protected static $extensionName;
    protected static $extensionUrl;
    protected static $extensionFolder;


    /**
     * Create a new command instance.
     *
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
        $dependencyCheck = $this->dependencyCheck();

        if( true !== $dependencyCheck )
        {
            return $this->cancelInstallation();
        }

        static::$extensionName = $this->argument('name');

        $extensionLookup = $this->extensionLookup();

        if( true !== $extensionLookup )
        {
            return $this->cancelInstallation();
        }


        $mode = $this->option('mode', 'install');

        if( !is_null($mode) && 'deploy' == $mode )
        {
            return $this->deployExtension();
        }

        if ( $this->confirm("Are you sure you want to install Aidkit extension '".static::$extensionName."'? [yes|no]", true))
        {
            if( is_null($mode) || 'install' == $mode )
            {
                return $this->installExtension();
            }

            return $this->updateExtension();
        }

        return $this->cancelInstallation();
    }


    protected function installExtension()
    {
        if( File::exists( static::$extensionPath.'/'.static::$extensionName) )
        {
            if ( $this->confirm("Extension '".static::$extensionName."' already exists, update instead? [yes|no]", true))
            {
                return $this->updateExtension( static::$extensionName );
            }

            return $this->cancelInstallation();
        }

        if( File::isWritable( static::$extensionPath ) ){
            //on success create directory
            File::makeDirectory( static::$extensionPath.'/'.static::$extensionName);

            //get contents
            return $this->getExtensionFromSource();
        }

        return $this->error( 'Aidkit extensions path is not writable');
    }


    protected function updateExtension()
    {
        if ( $this->confirm("Updating an extension will override your own changes. Proceed? [yes|no]", true) )
        {
            $this->info('Deleting : '.static::$extensionPath.'/'.static::$extensionName);
            // delete the folder within extension folder.
            $this->info( File::deleteDirectory( static::$extensionPath.'/'.static::$extensionName ) );

            // jump back to installation
            return $this->installExtension();
        }

        return $this->cancelInstallation();
    }


    protected function deployExtension()
    {
        return $this->installExtensionFiles();
    }


    protected function finishInstallation()
    {
        $this->call('dump-autoload'); // Lets make Extension recognized by Laravel

        return $this->info('Aidkit extension installation complete!');
    }


    protected function cancelInstallation()
    {
        return $this->info('Aidkit extension installation canceled!');
    }


    protected function getExtensionFromSource()
    {
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';

        $path_zip  = static::$extensionPath.'/'.static::$extensionName.'/';
        $file_zip  = "extension.zip";

        $fp = fopen($path_zip.$file_zip, "w");

        // Curly curls!
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL,static::$extensionUrl );
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FILE, $fp);

        $page = curl_exec($ch);

        if (!$page){
            $this->error("cURL error number:" .curl_errno($ch) );
            $this->error("cURL error:" . curl_error($ch) );

            return $this->cancelInstallation();
        }

        // Close cURL and archive
        curl_close($ch);
        fclose($fp);

        $zip = new \ZipArchive;

        if( true !== ( $err = $zip->open( $path_zip.$file_zip ) ) )
        {
            $this->error('Could not open ' . $path_zip.$file_zip );
            $this->error('Error #' . $err);
        }else
        {
            $this->info('File opened');
        }

        $this->info( 'StatusString: ' . $zip->getStatusString() );

        if( !$zip->extractTo( $path_zip ) )
        {
            return $this->error('Extraction error');
        }

        $this->info( 'StatusString: ' . $zip->getStatusString() );

        if(!$zip->close())
        {
            return $this->error('Error on close');
        }

        $this->info( 'Unzipped file to: ' . $path_zip );

        File::delete( $path_zip.$file_zip );

        return $this->installExtensionFiles();
    }



    protected function installExtensionFiles()
    {
        $extensionFolder  = static::$extensionPath.'/'.static::$extensionName.'/'.static::$extensionFolder;

        if( File::isDirectory( $extensionFolder ) )
        {
            // move files to the directory
            if( File::isDirectory( $extensionFolder.'/controllers' ) )
            {
                File::copyDirectory( $extensionFolder.'/controllers', app_path().'/controllers' );
                $this->info('Controllers have been created');
            }

            if( File::isDirectory( $extensionFolder.'/models' ) )
            {
                File::copyDirectory( $extensionFolder.'/models', app_path().'/models' );
                $this->info('Models have been created');
            }

            if( File::isDirectory( $extensionFolder.'/views' ) )
            {
                File::copyDirectory( $extensionFolder.'/views', app_path().'/views_admin' );
                $this->info('Views have been created');
            }

            if( File::isDirectory( $extensionFolder.'/database' ) )
            {
                File::copyDirectory( $extensionFolder.'/databases', app_path().'/database' );
                $this->info('Database files have been created ( migrations/seeds )');
            }

            if( File::isDirectory( $extensionFolder.'/public' ) )
            {
                File::copyDirectory( $extensionFolder.'/public', public_path().'/packages/codebryo/aidkit' );
                $this->info('Published public files into "packages/codebryo/aidkit" ');
            }


            // run the commands from the installation file.
            return $this->finishInstallation();
        }

        return $this->cancelInstallation();
    }


    protected function dependencyCheck()
    {
        $pass = true;
        if( !extension_loaded('zip') )
        {
            $this->error('php zip extension needs to be install');
            $pass = false;
        }

        // ZipArchive not found
        if( !class_exists('ZipArchive') )
        {
            $this->error('Class "ZipArchive" not found');
            $pass = false;
        }

        return $pass;
    }


    protected function extensionLookup()
    {
        $extensions = require_once( static::$extensionPath.'/extensions.php' );

        if( array_key_exists( static::$extensionName, $extensions ) )
        {
            static::$extensionUrl    = $extensions[ static::$extensionName ]['location'];
            static::$extensionFolder = $extensions[ static::$extensionName ]['zipfolder'];

            return true;
        }

        return false;
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