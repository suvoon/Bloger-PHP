<?php

class Model_Settings extends Model
{

    public function getProfileBlogs(){ //Получение массива из дат, ссылок и заголовков блогов пользователя
        $link = $this->dbconnect();
        $blogs_arr = array();
        $user_login = $_SESSION['login'];

        $prepared = $link->prepare("SELECT blog_title, blog_url, blog_date FROM `blogs` WHERE blog_userlogin = ? ORDER BY blog_id;");
        $prepared->bind_param('s', $user_login);
        $prepared->execute();
        $result = $prepared->get_result();

        $i = 1;
        $blog_result = $result->fetch_assoc();
        while (!empty($blog_result)){

            $blog_html = "<div class='your-blogs__line'>
                            <span class='line__title underline'>
                                <a href='/blog/".$blog_result['blog_url']."'>".$blog_result['blog_title']."</a> 
                            </span>
                            <span class='line__date'>
                                ".$blog_result['blog_date']."
                            </span>
                            <div class='line__buttons'>
                                <form action='' method='post'>
                                    <input type='submit' value='Удалить' name='submit[".$i."]' class='line__button'>
                                    <input type='submit' value='Редактировать' name='submit[".$blog_result['blog_url']."]' class='line__button'>
                                </form>
                            </div>
                        </div>";
            $blogs_arr[] = $blog_html;
            $i++;
            $blog_result = $result->fetch_assoc();
        }

        mysqli_close($link);
        return $blogs_arr;
    }
	
    public function changeUname($new_uname){ //Проверка на корректность и изменение имени пользователя
        $link = $this->dbconnect();
        $uname_error = "";

        $prepared = $link->prepare("SELECT user_id FROM `users` WHERE user_name = ?");
        $prepared->bind_param('s', $new_uname);
        $prepared->execute();
        $result = $prepared->get_result(); 

        $isUsernameOccupied = $result->fetch_assoc();
        if (empty($isUsernameOccupied)){
            if (mb_strlen($new_uname, 'utf8') < 30){
                if ((str_replace(" ",'',$new_uname) != "") && (!strpos($new_uname, "/")) && (!strpos($new_uname, "?"))){
                    $prepared = $link->prepare("UPDATE `users` SET user_name = ? WHERE user_login = ?");
                    $prepared->bind_param('ss', $new_uname, $_SESSION['login']);
                    $prepared->execute();
            
                    $_SESSION['username'] = $new_uname;
                }
                else{
                    $uname_error = "Имя пользователя содержит недопустимые символы";
                }
            } 
            else{
                $uname_error = "Имя пользователя слишком длинное";
            }
        } 
        else{
            $uname_error = "Имя пользователя уже занято";
        }
        mysqli_close($link);
        return $uname_error;
    }

    public function changePfp($profilepic){ //Проверка на корректность файла и изменение изображения профиля
        $pfp_error = "";
        $ext = getimagesize($profilepic)['mime'];
        $ext = explode('/', $ext)[0];
        if ($ext == "image"){
            $blob = $this->imageToBlob($profilepic);
            $link = $this->dbconnect();

            $prepared = $link->prepare("UPDATE `users` SET user_image = ? WHERE user_login = ?");
            $prepared->bind_param('ss', $blob, $_SESSION['login']);
            $prepared->execute();

            mysqli_close($link);
        }
        else $pfp_error = "Некорректный формат изображения";
        return $pfp_error;
    }
    
    public function changeDesc($new_desc){ //Проверка на длину и изменение описания профиля
        $link = $this->dbconnect();
        $desc_error = "";

        if (mb_strlen($new_desc, 'utf8') < 150){
            $new_desc = strip_tags($new_desc);
            $prepared = $link->prepare("UPDATE `users` SET user_desc = ? WHERE user_login = ?");
            $prepared->bind_param('ss', $new_desc, $_SESSION['login']);
            $prepared->execute();
        }
        else{
            $desc_error = "Описание длиннее 150 символов";
        }

        mysqli_close($link);
        return $desc_error;
    }

	public function getDesc() //Получение текущего описания профиля
	{	
		$desc = "";
        if((isset($_SESSION['auth'])) && ($_SESSION['auth'] == true)){
            $link = $this->dbconnect();

            $prepared = $link->prepare("SELECT user_desc FROM `users` WHERE user_login = ?");
            $prepared->bind_param('s', $_SESSION['login']);
            $prepared->execute();
            $result = $prepared->get_result();

            $desc_result = $result->fetch_assoc();
            if(!empty($desc_result)){
                $desc = $desc_result['user_desc'];
            }

            mysqli_close($link);
        }
        return $desc;
	}

    public function deleteBlog($blog_n){ //Удаление блога
        $link = $this->dbconnect();
        $user_login = $_SESSION['login'];

        $prepared = $link->prepare("SELECT MAX(blog_id) as id from (SELECT blog_id from `blogs` WHERE blog_userlogin = ? ORDER BY blog_id LIMIT ?) as b1;");
        $prepared->bind_param('ss', $user_login, $blog_n);
        $prepared->execute();
        $result = $prepared->get_result();

        $id_result = $result->fetch_assoc();
        if(!empty($id_result)){
            $id = $id_result['id'];
            $prepared = $link->prepare("DELETE FROM `blogs` where blog_id = ?");
            $prepared->bind_param('s', $id);
            $prepared->execute();
        }

        mysqli_close($link);
    }

    public function editBlog($blog_url){ //Переход на страницу редактирования блога
        echo "AAA";
        header("Location: /editor/".$blog_url);
    }

}
