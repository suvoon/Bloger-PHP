<?php

class Model_Editor extends Model
{

    public function isValidUser(){ //Принадлежит ли этот блог этому пользователю
        $link = $this->dbconnect();
        $user_login = $_SESSION['login'];
        $editor_link = $_SESSION['link'];
        $valid = false;

        $prepared = $link->prepare("SELECT blog_title FROM `blogs` WHERE blog_url = ? AND blog_userlogin = ?;");
        $prepared->bind_param('ss', $editor_link, $user_login);
        $prepared->execute();
        $result = $prepared->get_result();

        $editor_result = $result->fetch_assoc();
        if (!empty($editor_result)){
            $valid = true;
        }

        mysqli_close($link);
        return $valid;
    }

    public function getBlogText(){ //Содержание блога
        $link = $this->dbconnect();
        $editor_link = $_SESSION['link'];
        $blog_text = array();

        $prepared = $link->prepare("SELECT blog_title, blog_text FROM `blogs` WHERE blog_url = ?;");
        $prepared->bind_param('s', $editor_link);
        $prepared->execute();
        $result = $prepared->get_result();

        $editor_result = $result->fetch_assoc();
        $blog_text[] = $editor_result['blog_title'];
        $blog_text[] = $editor_result['blog_text'];

        mysqli_close($link);
        return $blog_text;
    }
	
    public function editBlog($title, $content){ //Проверка допустимости заголовка и обновление блога
        $link = $this->dbconnect();
        $edit_error = "";
        $blog_url = $_SESSION['link'];

        if ((str_replace(" ",'',$title) != "") && (mb_strlen($title, 'utf8') < 60)){

            $prepared = $link->prepare("UPDATE `blogs` SET blog_title = ?, blog_text = ? WHERE blog_url = ?");
            $prepared->bind_param('sss', $title, $content, $blog_url);
            $prepared->execute();

        }
        else{
            $edit_error = "Недопустимый заголовок";
        }

        mysqli_close($link);
        return $edit_error;
    }

}
