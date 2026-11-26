<?php
namespace src\app\controller;

use src\app\view\admin\AdminUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use src\app\model\User;
use src\app\repository\CompanyRepository;
use src\app\repository\UserRepository;

class UserController{
    
    /**
     * Summary of adminUserSite
     */
    public function adminUserSite():Response{
        $user = $this->listAllUsers();
        $view = new AdminUser();
        $view->setData($user);
        return new Response($view->render());
    }

    /**
     * Summary of trainerUserSite
     */
    public function trainerUserSite(){

    }


    /**
     * Summary of createUser
     * create a new user 
     */
    public function createUser(Request $request):array{
        $companyRepo = new CompanyRepository();
        $userRepo = new UserRepository();
        $companies = $companyRepo->getAllCompanies();
        $roles =$userRepo->getAllRoles();
        $formData = [
            'firstname'     => '',
            'lastname'      => '',
            'email'         => '',
            'password_hash' => '',
            'role'          => '',
            'company'       => 0,
            'roles'         => $roles,
            'companies'     => $companies
        ];

        if ($request->isMethod('POST')) {
            $firstname  =   trim($request->request->get('firstname'));
            $lastname   =   trim($request->request->get('lastname'));
            $email      =   trim($request->request->get('email'));
            $password   =   trim($request->request->get('password'));
            $role       =   $request->request->get('role');
            $companyId  =   $request->request->get('company');

            $formData['firstname']      = $firstname;
            $formData['lastname']       = $lastname;
            $formData['email']          = $email;
            $formData['password_hash']  = $password;
            $formData['role']           = $role;
            $formData['company']        = $companyId;

            if ($firstname !== '' && $lastname !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $password !== '') {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $companyObj   = $companyRepo->getCompanyById($companyId);

                $user = new User(0, true, $firstname, $lastname, $email, $passwordHash, $role, $companyObj);
                (new UserRepository())->save($user);
                return $formData;
            }
        }
        return $formData;
    }

    /**
     * Summary of editUser
     */
    public function editUser():array{ 
        $companyRepositoryObj= new CompanyRepository();
        $companies =$companyRepositoryObj->getAllCompanies();
        $userRepositoryObj = new UserRepository();
        $roles =$userRepositoryObj->getAllRoles();

        $formData =[
            'firstname'     => '',
            'lastname'      => '',
            'email'         => '',
            'password_hash' => '',
            'role'          => '',
            'company'       => 0,
            'roles'         => $roles,
            'companies'     => $companies
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id         =   (int) ($_POST['edit_id']??'');
            $firstname  =   trim($_POST['firstname']??'');
            $lastname   =   trim($_POST['lastname']??'');
            $email      =   trim($_POST['email']??'');
            $password   =   trim($_POST['password_hash']??'');
            $role       =   (int)   ($_POST['role']??'');
            $companyId  =   (int)   ($_POST['company']??0);

            $formData['firstname']      = $firstname;
            $formData['lastname']       = $lastname;
            $formData['email']          = $email;
            $formData['password_hash']  = $password;
            $formData['role']           = $role;
            $formData['company']        = $companyId;
            
            if ($firstname !== '' && $lastname !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $password !== '') {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $companyObj     = $companyRepositoryObj->getCompanyById($companyId);

                $user = new User($id, true, $firstname, $lastname, $email, $passwordHash, $role, $companyObj);
                (new UserRepository())->update($user);
                return $formData;
            }
        }
        return $formData;

    }



    /**
     * Summary of deleteUser
     * Users should not be deleted 
     * deleteUser function is only for testing
     */
    public function deleteUser(Request $request){
            return (new UserRepository())->delete((int) ($request->request->get('delete_id')));
    }

    /**
     * Summary of changeUserState
    */
    public function changeUserState(){


    }

    /**
     * Summary of listAllUsers
     */
    public function listAllUsers(){
        $userList = (new UserRepository())->load();
        return $userList;
    }








}


?>