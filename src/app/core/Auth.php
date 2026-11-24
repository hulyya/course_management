<?php
namespace src\app\core;

use src\app\repository\UserRepository;
use src\app\view\auth\Login;

class Auth {
    /**
     * Summary of login
     * user login function
     */
    public static function login(){
        $userRepositoryObject = new UserRepository();
        $view = new Login();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $userRepositoryObject->getUserByEmail($email);

            if($user && password_verify($password, $user->getPassword())){
                $_SESSION['user_id'] = $user->getId();
                
                session_regenerate_id(true);
                header('Location: /course_management/public/index.php/admin');
                exit;

            } else {
                // ERROR
            }
        }
        return $view->render();
    }
    /**
     * Summary of logout 
     * user ends the session
     */
    public static function logout(){
        $_SESSION = [];
        session_destroy();
        header('Location: index.php/login');
        exit(); /// ????? exit()
    }
}

?>