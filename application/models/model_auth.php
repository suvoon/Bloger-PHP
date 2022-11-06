<?php
class Model_Auth extends Model
{

    public function generateSalt(){ //Генерация соли для пароля и куки
        $salt = '';
        $saltLength = 5;
        for ($i = 0; $i < $saltLength; $i++){
            $salt .= chr(mt_rand(33,126));
        }
        return $salt;
    }

    public function authenticate($login, $password, $remember){ //Проверка полей и авторизация пользователя
        $link = $this->dbconnect();
        $auth_error = "";

        $prepared = $link->prepare("SELECT user_login, user_password, user_salt, user_name FROM `users` WHERE user_login = ?");
        $prepared->bind_param('s', $login);
        $prepared->execute();
        $result = $prepared->get_result();

        $user = $result->fetch_assoc();
        if (!empty($user)){
            $salt = $user['user_salt'];
            $saltPassword = md5($password.$salt);
            if($user['user_password'] == $saltPassword){
                session_start();
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $user['user_login'];
                $_SESSION['username'] = $user['user_name'];
                if(!empty($remember) && ($remember == "on")){
                    $key = $this->generateSalt();
                    setcookie('login', $user['user_login'], time()+2592000);
                    setcookie('key', $key, time()+2592000);

                    $prepared = $link->prepare("UPDATE `users` SET user_cookie = ? WHERE user_login = ?");
                    $prepared->bind_param('ss', $key, $login);
                    $prepared->execute();
                }
                mysqli_close($link);
                header("Location: /main");
                exit();
            }
            else $auth_error = "Неправильный пароль";
        }
        else $auth_error = "Неправильный логин";

        mysqli_close($link);
        return $auth_error;
    }

    public function register($login, $password, $confirm, $username){ //Проверка полей и регистрация пользователя
        $link = $this->dbconnect();
        $login_error = "";

        if ($password == $confirm){
            if(mb_strlen($password, 'utf8') < 30){
                $prepared = $link->prepare("SELECT user_id FROM `users` WHERE user_login = ?");
                $prepared->bind_param('s', $login);
                $prepared->execute();
                $result = $prepared->get_result();
    
                $isLoginOccupied = $result->fetch_assoc();
                if ((empty($isLoginOccupied)) && (str_replace(" ",'',$login) != "") && (mb_strlen($login, 'utf8') < 30)){
                    $prepared = $link->prepare("SELECT user_id FROM `users` WHERE user_name = ?");
                    $prepared->bind_param('s', $username);
                    $prepared->execute();
                    $result = $prepared->get_result();
    
                    $isUsernameOccupied = $result->fetch_assoc();
                    if (empty($isUsernameOccupied)){
                        if  (mb_strlen($username, 'utf8') < 30){
                            if ((str_replace(" ",'',$username) != "") && (!strpos($username, "/")) && (!strpos($username, "?"))){
                                $salt = $this->generateSalt();
                                $saltedPassword = md5($password.$salt);
            
                                $prepared = $link->prepare("INSERT INTO `users` (`user_name`, `user_login`, `user_password`, `user_salt`) VALUES (?, ?, ?, ?);");
                                $prepared->bind_param('ssss', $username, $login, $saltedPassword, $salt);
                                $prepared->execute();
            
                                session_start();
                                $_SESSION['auth'] = true;
                                $_SESSION['login'] = $login;
                                $_SESSION['username'] = $username;
        
                                mysqli_close($link);
                                header("Location: /main");
                                exit();
                            }
                            else{
                                $login_error = "Имя пользователя содержит недопустимые символы";
                            }
                        } 
                        else{
                            $login_error = "Имя пользователя слишком длинное";
                        }
                    } 
                    else{
                        $login_error = "Имя пользователя уже занято";
                    }
                }
                else{
                    $login_error = "Логин уже занят/недоступен";
                }
            }
            else{
                $login_error = "Слишком длинный пароль";
            }
        }
        else{
            $login_error = "Пароли не совпадают";
        }

        mysqli_close($link);
        return $login_error;
    }

}
