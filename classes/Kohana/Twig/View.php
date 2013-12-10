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

	/**
	 * @return Twig_Environment
	 */
	public static function twig()
	{
		return Kohana_Twig::instance()->twig;
	}

	/**
	 * @param       $filename
	 * @param array $data
	 *
	 * @return string
	 */
	protected static function capture($filename, array $data = [])
	{
		return self::twig()
			->loadTemplate($filename)
			->render(array_merge($data, static::$_global_data));
	}

	/**
	 * @return string|null
	 */
	public static function suffix()
	{
		return Kohana_Twig::config('suffix');
	}

	/**
	 * @param string $file
	 *
	 * @return $this
	 */
	public function set_filename($file)
	{
		$ext = self::suffix();

		if ($ext === NULL) {
			$this->_file = $file;
		} else {
			$this->_file = $file . '.' . $ext;
		}

		return $this;
	}

	/**
	 * @param null $file
	 *
	 * @return string
	 * @throws Kohana_View_Exception
	 */
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

}
