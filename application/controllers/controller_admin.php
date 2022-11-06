<?php

class Controller_Admin extends Controller
{

	function __construct()
	{
		$this->model = new Model_Admin();
		$this->view = new View();
	}

	function action_index()
	{
		$data_arr = ["", ""]; //Результаты поиска пользователей и блогов
		if (isset($_POST['admin-usersubmit'])) {
			$users_query = $this->model->getUsersQuery($_POST['admin-usersearch']);
			$data_arr[0] = $users_query;
		}
		else if (isset($_POST['admin-blogsubmit'])) {
			$blogs_query = $this->model->getBlogsQuery($_POST['admin-blogsearch']);
			$data_arr[1] = $blogs_query;
		}
		else if (isset($_POST['delete-user'])){
			foreach( $_POST['delete-user'] as $key => $value){
				$this->model->deleteUser($key);
			}
		}
		else if (isset($_POST['delete-blog'])){
			foreach( $_POST['delete-blog'] as $key => $value){
				$this->model->deleteBlog($key);
			}
		}
		$this->view->generate('admin_view.php', 'template_view.php', $this->is_logged(), $data_arr);
	}
}