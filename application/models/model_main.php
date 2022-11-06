<?php

class Model_Main extends Model
{
	public function getLatestBlogs(){ //Получить массив из последних 10 блогов
        $link = $this->dbconnect();
        $blogs_arr = array();

        $prepared = $link->prepare("SELECT blog_url, blog_userlogin, blog_text, blog_title, blog_date, user_name, user_image FROM `blogs` LEFT JOIN `users` ON blogs.blog_userlogin = users.user_login ORDER BY blog_id DESC LIMIT 10;");
        $prepared->execute();
        $result = $prepared->get_result();

        $blog_result = $result->fetch_assoc();
        while(!empty($blog_result)){

            $user_image = "";
            if ($blog_result['user_image']){
                $user_image = '<img alt="Profile Picture" src="data:image/jpg;base64,' . $this->blobToImage($blog_result['user_image']) . '" />';
            }
            else $user_image = '<img src="/images/no-image.jpg" />';

            $user_link = urlencode($blog_result['user_name']);
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
                                <a href='/profile/".$user_link."'>".$blog_result['user_name']."</a>
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
            $blog_result = $result->fetch_assoc();
        }

        mysqli_close($link);
        return $blogs_arr;
    }

}