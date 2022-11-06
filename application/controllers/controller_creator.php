<?php

class Controller_Creator extends Controller
{

	function __construct()
	{
		$this->model = new Model_Creator();
		$this->view = new View();
	}

	function action_index()
	{	
		if(isset($_POST['create-submit'])){
			//Ошибка при создании
			if ($_FILES) $creator_error = $this->model->createBlog($_POST['constructor-title'], $_POST['constructor-content'], $_FILES);
			else $creator_error = $this->model->createBlog($_POST['constructor-title'], $_POST['constructor-content'], "");
			$this->view->generate('creator_view.php', 'template_view.php', $this->is_logged(), $creator_error);
		}
		else $this->view->generate('creator_view.php', 'template_view.php', $this->is_logged());
	}
}