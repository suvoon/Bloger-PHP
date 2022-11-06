<?php

class Model_Creator extends Model
{
	
    public function createBlog($title, $content, $images){ //Проверка допустимости заголовка и загрузка блога
        $link = $this->dbconnect();
        $create_error = "";

        if ((str_replace(" ",'',$title) != "") && (mb_strlen($title, 'utf8') < 60)){

            $prepared = $link->prepare("INSERT INTO `blogs` (`blog_userlogin`, `blog_title`, `blog_text`, `blog_date`) VALUES (?, ?, ?, CURDATE());");
            $prepared->bind_param('sss', $_SESSION['login'], $title, $content);
            $prepared->execute();

            $inserted_id = $link->insert_id;
            $url = urlencode(base64_encode($inserted_id));
            $prepared = $link->prepare("UPDATE `blogs` SET blog_url = ? WHERE blog_id = ?");
            $prepared->bind_param('ss', $url, $inserted_id);
            $prepared->execute();

            $i = 1;
            if (!empty($images)){
                foreach ($images as $image){
                    if ($image["error"] == UPLOAD_ERR_OK){
                        $ext = getimagesize($image['tmp_name'])['mime'];
                        $ext = explode('/', $ext)[0];
                        if ($ext == "image"){
                            $blob = $this->imageToBlob($image['tmp_name']);
        
                            $prepared = $link->prepare("INSERT INTO `images` (`image_blogurl`, `image_blob`, `image_n`) VALUES (?, ?, ?);");
                            $prepared->bind_param('sss', $url, $blob, $i);
                            $prepared->execute();
                        }
                        $i++;
                    }
                    else{
                        $create_error = "Слишком большой размер изображения(ий), файлы не были загружены";
                    }
                }
            }
        }
        else{
            $create_error = "Недопустимый заголовок";
        }

        mysqli_close($link);
        return $create_error;
    }

}
