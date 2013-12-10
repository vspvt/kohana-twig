<?php

/**
 * @author: Vad Skakov <vad.skakov@gmail.com>
 */
abstract class Kohana_Controller_Twig_Template extends Controller_Template
{
	/**
	 * @var boolean  Auto-render template after controller method returns
	 */
	public $auto_render = TRUE;

	/**
	 * @var Twig_View  Kohana twig template
	 */
	public $template = NULL;

	public function before()
	{
		if ($this->auto_render)
		{
			// Auto-generate template filename ('index' method called on Controller_Admin_Users looks for 'admin/users/index')
			if ($this->template === NULL)
			{
				$this->template = $this->request->controller(). DIRECTORY_SEPARATOR . $this->request->action();

				if ($this->request->directory())
				{
					// Preprend directory if needed
					$this->template = $this->request->directory() . DIRECTORY_SEPARATOR . $this->template;
				}
			}

			$this->template = Twig_View::factory($this->template);
		}
	}

	public function after()
	{
		if ($this->auto_render)
		{
			// Auto-render the template
			$this->response->body($this->template->render());
		}
	}
}
