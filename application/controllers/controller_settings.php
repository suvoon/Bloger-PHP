<?php

class Controller_Settings extends Controller
{
	function __construct()
	{
		$this->model = new Model_Settings();
		$this->view = new View();
	}

	function action_index()
	{
		$description = $this->model->getDesc(); //Описание профиля
		//Описание, ошибка загрузки аватара, ошибка изменения имени профиля, ошибка изменения описания
		$data_arr = [$description, "", "", ""]; 
		$data_arr[4] = $this->model->getProfileBlogs(); //Блоги пользователя

		if ((isset($_POST['pfp-change-submit'])) && ($_FILES)){ //Если картинка загружена
			if ($_FILES["profile-picture"]["error"]== UPLOAD_ERR_OK){
				$pfp_change_error = $this->model->changePfp($_FILES['profile-picture']['tmp_name']);
			}
			else{
				$pfp_change_error = "Размер изображения превышает 2МБ";
			}
			$data_arr[1] = $pfp_change_error;
		}
		else if (isset($_POST['uname-change-submit'])) {
			$uname_change_error = $this->model->changeUname($_POST['username']);
			$data_arr[2] = $uname_change_error;
		}
		else if (isset($_POST['desc-change-submit'])){
			$desc_change_error = $this->model->changeDesc($_POST['description']);
			$description = $this->model->getDesc();
			$data_arr[3] = $desc_change_error;
		}
		else if (isset($_POST['submit'])){
			foreach( $_POST['submit'] as $key => $value){
				if (($_POST['submit'][$key] == "Удалить") && (is_int($key))){
					$this->model->deleteBlog($key);
					$data_arr[4] = $this->model->getProfileBlogs();
				}
				else if ($_POST['submit'][$key] == "Редактировать"){
					$this->model->editBlog($key);
				}
			}
		}
		$this->view->generate('settings_view.php', 'template_view.php', $this->is_logged(), $data_arr);
		
	}
}
