<?php

class Controller_Blog extends Controller
{

	function __construct()
	{
		$this->model = new Model_Blog();
		$this->view = new View();
	}

	function action_index()
	{
		$blog_data = $this->model->getBlogData(); //Текст блога
		$this->view->generate('blog_view.php', 'template_view.php', $this->is_logged(), $blog_data);
	}
}