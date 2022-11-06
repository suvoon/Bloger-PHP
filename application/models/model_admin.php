<?php

class Model_Admin extends Model
{

    public function getUsersQuery($query){ //Вывести пользователей по запросу
        $link = $this->dbconnect();
        $users_arr = array();
        $query = "%".$query."%";

        $prepared = $link->prepare("SELECT user_name, user_id FROM `users` WHERE user_name LIKE ? ORDER BY user_id;");
        $prepared->bind_param('s', $query);
        $prepared->execute();
        $result = $prepared->get_result();
        $user_result = $result->fetch_assoc();
        while (!empty($user_result)){
            $user_link = urlencode($user_result['user_name']);
            $user_html = "<div class='admin-query__info-block'>
                            <div class='info-block__name underline'><a href='/profile/".$user_link."'>
                                ".$user_result['user_name']."</a>
                            </div>
                            <div class='info-block__delete'>
                                <form action='' method='post'>
                                    <input type='submit' value='Удалить' name='delete-user[".$user_result['user_id']."]' class='info-block__button'>
                                </form>
                            </div>
                        </div>";
            $users_arr[] = $user_html;
            $user_result = $result->fetch_assoc();
        }

        if (empty($users_arr)) $users_arr[] = "Ничего не найдено";
        mysqli_close($link);
        return $users_arr;
    }

    public function getBlogsQuery($query){ //Вывести блоги по запросу (с указанным создателем)
        $link = $this->dbconnect();
        $blogs_arr = array();
        $query = "%".$query."%";

        $prepared = $link->prepare("SELECT blog_title, blog_url, blog_id, user_name FROM `blogs` LEFT JOIN `users` ON blogs.blog_userlogin = users.user_login WHERE blog_title LIKE ? OR user_name LIKE ? ORDER BY blog_id;");
        $prepared->bind_param('ss', $query, $query);
        $prepared->execute();
        $result = $prepared->get_result();
        $blog_result = $result->fetch_assoc();
        while (!empty($blog_result)){
            $user_link = urlencode($blog_result['user_name']);
            $blog_html = "<div class='admin-query__info-block'>
                            <div class='info-block__name'><a class='underline' href='/blog/".$blog_result['blog_url']."'>
                                ".$blog_result['blog_title']."</a>
                                От <a class='underline' href='/profile/".$user_link."'>".$blog_result['user_name']."</a>
                            </div>
                            <div class='info-block__delete'>
                                <form action='' method='post'>
                                    <input type='submit' value='Удалить' name='delete-blog[".$blog_result['blog_id']."]' class='info-block__button'>
                                </form>
                            </div>
                        </div>";
            $blogs_arr[] = $blog_html;
            $blog_result = $result->fetch_assoc();
        }

        if (empty($blogs_arr)) $blogs_arr[] = "Ничего не найдено";
        mysqli_close($link);
        return $blogs_arr;
    }

    public function deleteUser($user_id){ //Удалить пользователя
        $link = $this->dbconnect();

        $prepared = $link->prepare("DELETE FROM `users` where user_id = ?;");
        $prepared->bind_param('s', $user_id);
        $prepared->execute();

        mysqli_close($link);
    }

    public function deleteBlog($blog_id){ //Удалить блог
        $link = $this->dbconnect();

        $prepared = $link->prepare("DELETE FROM `blogs` where blog_id = ?;");
        $prepared->bind_param('s', $blog_id);
        $prepared->execute();

        mysqli_close($link);
    }

}
