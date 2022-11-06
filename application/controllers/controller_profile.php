<?php

class Controller_Profile extends Controller
{

	function __construct()
	{
		$this->model = new Model_Profile();
		$this->view = new View();
	}

	function action_index()
	{
		$profile_data = $this->model->getProfileInfo(); //Аватар, имя пользователя, описание
		$this->view->generate('profile_view.php', 'template_view.php', $this->is_logged(), $profile_data);
	}
}
