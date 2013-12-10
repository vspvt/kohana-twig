<?php

/**
 * @author: Vad Skakov <vad.skakov@gmail.com>
 */
class Kohana_Twig
{
	/** @var Kohana_Twig */
	public static $instance;

	/** @var  Twig_Environment */
	public $twig;

	/** @var  Kohana_Config_Group */
	protected $config;

	/**
	 * @return Kohana_Twig
	 */
	public static function instance()
	{
		if (!static::$instance) {
			static::$instance = new self;

			// Load Twig configuration
			static::$instance->config = Kohana::$config->load('twig');

			// Array of template locations in cascading filesystem
			$templatesDir = static::$instance->config->templates_dir;
			$templatePaths = [APPPATH . $templatesDir];
			foreach (Kohana::modules() as $modulePath) {
				$tempPath = $modulePath . $templatesDir;
				if (is_dir($tempPath)) {
					$templatePaths[] = $tempPath;
				}
			}
			// Create the the loader
			$loader = new Twig_Loader_Filesystem($templatePaths);

			// Set up Twig
			static::$instance->twig = new Twig_Environment($loader, static::$instance->config->environment);

			foreach (static::config('extensions', []) as $extension) {
				// Load extensions
				static::$instance->twig->addExtension(new $extension);
			}
		}

		return static::$instance;
	}

	/**
	 * @param string $path
	 * @param null   $default
	 * @param null   $delimeter
	 *
	 * @return mixed
	 */
	public static function config($path, $default = NULL, $delimeter = NULL)
	{
		return Arr::path(static::instance()->config->as_array(), $path, $default, $delimeter);
	}

	final protected function __construct()
	{
		// This is a singleton class
	}

}
