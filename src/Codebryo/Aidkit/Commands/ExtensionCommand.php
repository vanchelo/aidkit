<?php namespace Codebryo\Aidkit\Commands;

use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ExtensionCommand
 *
 * For development help : http://net.tutsplus.com/tutorials/php/your-one-stop-guide-to-laravel-commands/
 *
 * @package Codebryo\Aidkit\Commands
 */
class ExtensionCommand extends Command
{
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
	protected $description = 'Install/Manage additional extensions into Aidkit';

	/**
	 * The Path where the extension core is installed.
	 *
	 * @var string
	 */
	protected static $extensionPath;

	/**
	 * The name of the extension
	 *
	 * @var string
	 */
	protected static $extensionName;

	/**
	 * The URL where the extension can be found.
	 *
	 * @var string
	 */
	protected static $extensionUrl;

	/**
	 * The extension folder should be something like Packagename-master.
	 *
	 * @var string
	 */
	protected static $extensionFolder;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		static::$extensionPath = __DIR__ . '/../../../../extensions';
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		static::$extensionName = $this->argument('name');
		$mode = $this->option('mode', 'install');

		$dependencyCheck = $this->dependencyCheck();
		$permissionCheck = $this->permissionCheck();
		$extensionLookup = $this->extensionCheck();

		if (true !== $dependencyCheck || true !== $permissionCheck || true !== $extensionLookup)
		{
			return $this->cancelInstallation();
		}

		if ( ! is_null($mode) && 'deploy' == $mode)
		{
			return $this->deployExtension();
		}

		if ($this->confirm("Are you sure you want to install Aidkit extension '" . static::$extensionName . "'? [yes|no]", true))
		{
			if (is_null($mode) || 'install' == $mode)
			{
				return $this->installExtension();
			}

			return $this->updateExtension();
		}

		return $this->cancelInstallation();
	}

	/**
	 * Install the extension.
	 *
	 * Run checks :
	 *      - Check if extension is already installed -> go to updateExtension()
	 *      - Check if the directory is writable      -> error
	 *
	 * Continue to getExtensionFromSource()
	 *
	 * @return void;
	 */
	protected function installExtension()
	{
		if (File::exists(static::$extensionPath . '/' . static::$extensionName))
		{
			if ($this->confirm("Extension '" . static::$extensionName . "' already exists, update instead? [yes|no]", true))
			{
				return $this->updateExtension(static::$extensionName);
			}

			return $this->cancelInstallation();
		}

		File::makeDirectory(static::$extensionPath . '/' . static::$extensionName);

		//get contents
		return $this->getExtensionFromSource();
	}

	/**
	 * Update extension
	 * Basically check if user want's to reinstall the extension.
	 *
	 * @return void;
	 */
	protected function updateExtension()
	{
		if ($this->confirm("Updating an extension will override your own changes. Proceed? [yes|no]", true))
		{
			$this->info('Deleting : ' . static::$extensionPath . '/' . static::$extensionName);
			// delete the folder within extension folder.
			$this->info(File::deleteDirectory(static::$extensionPath . '/' . static::$extensionName));

			// jump back to installation
			return $this->installExtension();
		}

		return $this->cancelInstallation();
	}

	/**
	 * Deploy an extension.
	 * Useful for developers.
	 *
	 * This method assumes that the extension is already installed in the appropriate folder. so it doe not download any
	 * code. This does the same as install/update without the checks.
	 *
	 * @return void;
	 */
	protected function deployExtension()
	{
		return $this->installExtensionFiles();
	}

	/**
	 * Message thrown at the end of the installation
	 *
	 * @return void;
	 */
	protected function finishInstallation()
	{
		$this->call('dump-autoload'); // Lets make Extension recognized by Laravel

		return $this->info('Installation of Aidkit extension: "' . static::$extensionName . '" has been completed successfully!');
	}

	/**
	 * Message thrown it installation get cancelled.
	 *
	 * @return void;
	 */
	protected function cancelInstallation()
	{
		return $this->info('Installation of Aidkit extension: "' . static::$extensionName . '" has been canceled!');
	}

	/**
	 * Try to fetch the package from the provided URL.
	 * Place the file in the extension folder. Unzip it and remove the zipfile
	 *
	 * @return void;
	 */
	protected function getExtensionFromSource()
	{
		$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';

		$path_zip = static::$extensionPath . '/' . static::$extensionName . '/';
		$file_zip = "extension.zip";

		$fp = fopen($path_zip . $file_zip, "w");

		// Curly curls!
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, static::$extensionUrl);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		$page = curl_exec($ch);

		if ( ! $page)
		{
			$this->error("cURL error number:" . curl_errno($ch));
			$this->error("cURL error:" . curl_error($ch));

			return $this->cancelInstallation();
		}

		// Close cURL and archive
		curl_close($ch);
		fclose($fp);

		$zip = new \ZipArchive;

		if (true !== ($err = $zip->open($path_zip . $file_zip)))
		{
			$this->error('Could not open ' . $path_zip . $file_zip);
			$this->error('Error #' . $err);
		}
		else
		{
			$this->info('File opened');
		}

		$this->info('StatusString: ' . $zip->getStatusString());

		if ( ! $zip->extractTo($path_zip))
		{
			return $this->error('Extraction error');
		}

		$this->info('StatusString: ' . $zip->getStatusString());

		if ( ! $zip->close())
		{
			return $this->error('Error on close');
		}

		$this->info('Unzipped file to: ' . $path_zip);

		File::delete($path_zip . $file_zip);

		return $this->installExtensionFiles();
	}

	/**
	 * All files should be in place. Installation process will start now.
	 * The files will be copied to their assigned folders.
	 *
	 * @return void;
	 */
	protected function installExtensionFiles()
	{
		$extensionFolder = static::$extensionPath . '/' . static::$extensionName . '/' . static::$extensionFolder;

		if (File::isDirectory($extensionFolder))
		{
			// move files to the directory
			if (File::isDirectory($extensionFolder . '/controllers'))
			{
				File::copyDirectory($extensionFolder . '/controllers', app_path() . '/Aidkit/controllers');
				$this->info('Controllers have been created');
			}

			if (File::isDirectory($extensionFolder . '/models'))
			{
				File::copyDirectory($extensionFolder . '/models', app_path() . '/Aidkit/models');
				$this->info('Models have been created');
			}

			if (File::isDirectory($extensionFolder . '/views'))
			{
				File::copyDirectory($extensionFolder . '/views', app_path() . '/Aidkit/views');
				$this->info('Views have been created');
			}

			if (File::isDirectory($extensionFolder . '/database'))
			{
				File::copyDirectory($extensionFolder . '/database', app_path() . '/database');
				$this->info('Database files have been created ( migrations/seeds )');
			}

			if (File::isDirectory($extensionFolder . '/public'))
			{
				File::copyDirectory($extensionFolder . '/public', public_path() . '/packages/aidkit/aidkit');
				$this->info('Published public files into "packages/aidkit/aidkit" ');
			}

			// run the commands from the installation file.
			return $this->finishInstallation();
		}

		return $this->cancelInstallation();
	}

	/**
	 * Check if all required PHP-extensions are installed on the server
	 *
	 * @return bool
	 */
	protected function dependencyCheck()
	{
		$pass = true;
		if ( ! extension_loaded('zip'))
		{
			$this->error('php zip extension needs to be install');
			$pass = false;
		}

		// ZipArchive not found
		if ( ! class_exists('ZipArchive'))
		{
			$this->error('Class "ZipArchive" not found');
			$pass = false;
		}

		return $pass;
	}

	/**
	 * Check if the extensions directory is accessible to Laravel
	 *
	 * @return bool
	 */
	protected function permissionCheck()
	{
		$pass = true;

		if ( ! File::isWritable(static::$extensionPath))
		{
			$this->error('Aidkit extensions path is not writable');
			$pass = false;
		}

		return $pass;
	}

	/**
	 * Find the extension in the repository and set related parameters
	 *
	 * @return bool
	 */
	protected function extensionCheck()
	{
		$extensions = require_once(static::$extensionPath . '/extensions.php');

		if ( ! array_key_exists(static::$extensionName, $extensions))
		{
			$this->error('There is no such extension available for Aidkit');

			return false;
		}

		static::$extensionUrl = $extensions[static::$extensionName]['location'];
		static::$extensionFolder = $extensions[static::$extensionName]['zipfolder'];

		return true;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			[
				'name', InputArgument::REQUIRED, 'Name of the desired extension'
			],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			[
				'mode', null, InputOption::VALUE_OPTIONAL, 'The mode the script needs to rum in, by default : install'
			]
		];
	}
}
