<?php

class Controller_Editor extends Controller
{

	function __construct()
	{
		$this->model = new Model_Editor();
		$this->view = new View();
	}

	function action_index()
	{	
        $valid_check = $this->model->isValidUser();
        $editor_error = ""; //Ошибка в данных при редактировании
        if ($valid_check){
            if (isset($_POST['edit-submit'])){
               $editor_error = $this->model->editBlog($_POST['editor-title'],$_POST['editor-content']);
            }
            $blog_text = $this->model->getBlogText();
            $this->view->generate('editor_view.php', 'template_view.php', $this->is_logged(), [$blog_text, $editor_error]);    
        }
        else {
            header("Location: /404");
        }			
	}
}