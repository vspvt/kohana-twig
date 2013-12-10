<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author: Vad Skakov <vad.skakov@gmail.com>
 */
class Kohana_Twig_View extends View
{
	/**
	 * @param null  $file
	 * @param array $data
	 *
	 * @return Twig_View
	 */
	public static function factory($file = NULL, array $data = NULL)
	{
		return new Twig_View($file, $data);
	}

	protected static function capture($filename, array $data = [])
	{
		return Kohana_Twig::instance()
			->twig
			->loadTemplate($filename)
			->render(array_merge($data, View::$_global_data));
	}

	public function set_filename($file)
	{
		$ext = Kohana_Twig::config('suffix');

		if ($ext === NULL) {
			$this->_file = $file;
		} else {
			$this->_file = $file . '.' . $ext;
		}

		return $this;
	}

	public function render($file = NULL)
	{
		if ($file !== NULL) {
			$this->set_filename($file);
		}

		if (empty($this->_file)) {
			throw new Kohana_View_Exception('You must set the file to use within your view before rendering');
		}

		// Combine local and global data and capture the output
		return self::capture($this->_file, $this->_data);
	}

	/**
	 * @return Twig_Environment
	 */
	public static function twig()
	{
		return Kohana_Twig::instance()->twig;
	}

}
