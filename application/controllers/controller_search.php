<?php

class Controller_Search extends Controller
{
	function __construct()
	{
		$this->model = new Model_Search();
		$this->view = new View();
	}

	function action_index()
	{	
        $query = urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]); //Получение запроса из ссылки
		$blog_blocks = $this->model->getSearchResult($query); //Блоги - результаты запроса
		$this->view->generate('search_view.php', 'template_view.php', $this->is_logged(), $blog_blocks);
	}
}