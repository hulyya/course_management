<?php
namespace src\app\core;

use src\app\repository\User_Repository;

class Auth {
    /**
     * Summary of login
     * user login function
     */
    public static function login(){
        $userRepositoryObject = new User_Repository();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $userRepositoryObject->getUserByEmail($email);

            if($user && password_verify($password, $user->getPassword())){
                $_SESSION['user_id'] = $user->getId();

                session_regenerate_id(true);

                header('Location: index.php?action=index');
                return;
            } else {
                // ERROR
            }
        }
        
    }
    /**
     * Summary of logout 
     * user ends the session
     */
    public static function logout(){
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?action=login');
        exit(); /// ????? exit()
    }
}

?>