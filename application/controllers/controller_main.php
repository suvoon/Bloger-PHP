<?php

class Controller_Main extends Controller
{
	function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index()
	{	
		$blog_blocks = $this->model->getLatestBlogs(); //Последние 10 блогов
		$this->view->generate('main_view.php', 'template_view.php', $this->is_logged(), $blog_blocks);
	}
}