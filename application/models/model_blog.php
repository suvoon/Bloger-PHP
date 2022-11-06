<?php

class Model_Blog extends Model
{
	public function getBlogData(){ //Возвращает разметку блога и вставляет изображения
        if(isset($_SESSION['link'])){
            $link = $this->dbconnect();
            $blog_link = $_SESSION['link'];
            $blog_arr = array();
    
            $prepared = $link->prepare("SELECT blog_url, blog_userlogin, blog_title, blog_text, user_name FROM `blogs` LEFT JOIN `users` ON blogs.blog_userlogin = users.user_login WHERE blog_url = ?;");
            $prepared->bind_param('s', $blog_link);
            $prepared->execute();
            $result = $prepared->get_result();
    
            $result = $result->fetch_assoc();

            $user_name = $result['user_name'];

            $blog_arr[] = $result['blog_title'];
            $blog_arr[] = $user_name;

            $i_prepared = $link->prepare("SELECT * FROM `images` WHERE image_blogurl = ?;");
            $i_prepared->bind_param('s', $result['blog_url']);
            $i_prepared->execute();
            $i_result = $i_prepared->get_result();
    
            $i = 1;
            $image_result = $i_result->fetch_assoc();
            $blog_content = str_replace('href="', 'href="http://www.', $result['blog_text']);
            while(!empty($image_result)){
                $image_substr = "%".$i."%";
                $pos = strpos($blog_content, $image_substr);
                if($pos){
                    $replace = '<img alt="Blog image" src="data:image/jpg;base64,' . $this->blobToImage($image_result['image_blob']) . '" />';
                    $blog_content = substr_replace($blog_content, $replace, $pos, 3);
                }
                $i++;
                $image_result = $i_result->fetch_assoc();
            }

            $blog_arr[] = $blog_content;
        }
        else{
            header("Location: /404");
            exit();
        }

        mysqli_close($link);
        return $blog_arr;
    }

}