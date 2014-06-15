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
	 * @param null $directorySuffix
	 *
	 * @return Twig_Loader_Filesystem
	 * @throws Kohana_Exception
	 */
	public function getLoader($directorySuffix = NULL)
	{
		// Array of template locations in cascading filesystem
		$templatesDir = static::$instance->config->templates_dir;
		$basePath = APPPATH . $templatesDir;
		NULL === $directorySuffix or $basePath .= DIRECTORY_SEPARATOR . $directorySuffix;

		$templatePaths = [$basePath];
		foreach (Kohana::modules() as $modulePath) {
			$tempPath = $modulePath . $templatesDir;
			if (is_dir($tempPath)) {
				$templatePaths[] = $tempPath;
			}
		}

		return new Twig_Loader_Filesystem($templatePaths);
	}

	/**
	 * @param null $directorySuffix
	 *
	 * @throws Kohana_Exception
	 * @return Kohana_Twig
	 */
	public static function instance($directorySuffix = NULL)
	{
		if (!static::$instance) {
			static::$instance = new self;

			// Load Twig configuration
			static::$instance->config = Kohana::$config->load('twig');

			// Create the the loader
			$loader = static::$instance->getLoader($directorySuffix);

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
