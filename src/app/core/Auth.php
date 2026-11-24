<?php
namespace src\app\core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use src\app\repository\UserRepository;
use src\app\view\auth\Login;

class Auth {
    public static function login(Request $request): Response{
        $userRepositoryObject = new UserRepository();
        $view = new Login();
        $error = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email', '');
            $password = $request->request->get('password', '');

            $user = $userRepositoryObject->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $session = $request->getSession();
                $session->migrate(true);
                $session->set('user_id', $user->getId());
                
                return new RedirectResponse('/course_management/public/index.php/admin');
            }
            $error = 'E-Mail oder Passwort ist falsch.';
        }
        return new Response($view->render(['error' => $error]), Response::HTTP_OK);
    }
   
    public static function logout(Request $request): RedirectResponse{
        $request->getSession()->invalidate();

        return new RedirectResponse('/course_management/public/index.php/login');
    }
    /**
     *  check which user is logged in
     */
}

?>