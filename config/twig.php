<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author: Vad Skakov <vad.skakov@gmail.com>
 */
return [
	'environment' => [
		'debug' => FALSE,
		'trim_blocks' => FALSE,
		'charset' => 'UTF-8',
		'base_template_class' => 'Twig_Template',
		'cache' => APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'twig',
		'auto_reload' => TRUE,
		'strict_variables' => FALSE,
		'autoescape' => TRUE,
		'optimizations' => -1,
	],
	'extensions' => [
		// List extension class names
	],
	'templates_dir' => APPPATH . 'views',
	'suffix' => 'twig',
];
