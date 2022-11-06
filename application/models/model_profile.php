<?php

class Model_Profile extends Model
{
	public function getProfileInfo(){ //Получение изображения, имени пользователя, описания и блогов одного пользователя
        if(isset($_SESSION['link'])){
            $link = $this->dbconnect();
            $user_name = urldecode($_SESSION['link']);
            $blogs_arr = array();
    
            $u_prepared = $link->prepare("SELECT user_name, user_login, user_desc, user_image FROM `users` WHERE user_name = ?;");
            $u_prepared->bind_param('s', $user_name);
            $u_prepared->execute();
            $u_result = $u_prepared->get_result();
    
            $user_result = $u_result->fetch_assoc();
            if (!empty($user_result)){

                $user_image = "";
                if ($user_result['user_image']){
                    $user_image = '<img alt="Profile Picture" src="data:image/jpg;base64,' . $this->blobToImage($user_result['user_image']) . '" />';
                }
                else $user_image = '<img src="/images/no-image.jpg" />';

                $blogs_arr[] = $user_image;
                $blogs_arr[] = $user_result['user_name'];
                $blogs_arr[] = $user_result['user_desc'];

                $b_prepared = $link->prepare("SELECT * FROM `blogs` WHERE blog_userlogin = ?");
                $b_prepared->bind_param('s', $user_result['user_login']);
                $b_prepared->execute();
                $b_result = $b_prepared->get_result();
        
                $blog_result = $b_result->fetch_assoc();
                while(!empty($blog_result)){
        
                    $user_link = urlencode($user_result['user_name']);
                    $short_text = preg_replace("#<p>|</p>|%[1-5]%#i", " ", substr($blog_result['blog_text'], 0, 300));
                    $short_text = strip_tags($short_text);

                    $blog_html = "<div class='blog-mini'>
                                <div class='blog-mini__author'>
                                    <div class='author__image'>
                                        <a href='/profile/".$user_link."'>
                                            ".$user_image."
                                        </a>
                                    </div>
                                    <div class='author__name underline'>
                                        <a href='/profile/".$user_link."'>".$user_result['user_name']."</a>
                                    </div>
                                    <div class='blogdate'>".$blog_result['blog_date']."</div>
                                </div>
                                <div class='blog-mini__about'>
                                    <a href='/blog/".$blog_result['blog_url']."'>
                                        <div class='about__title underline'>
                                            ".$blog_result['blog_title']."
                                        </div>
                                    </a>
                                    <div class='about__desc'>
                                        ".$short_text."
                                    </div>
                                </div>
                            </div>";
                    $blogs_arr[] = $blog_html;
                    $blog_result = $b_result->fetch_assoc();
                }
            }
            else{
                mysqli_close($link);
                header("Location: /404");
                exit();
            }
        }
        else{
            header("Location: /404");
            exit();
        }
        
        
        

        mysqli_close($link);
        return $blogs_arr;
    }

}