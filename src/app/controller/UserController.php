<?php
namespace src\app\controller;

use src\app\model\User;
use src\app\repository\CompanyRepository;
use src\app\repository\UserRepository;

class UserController{

    /**
     * Summary of createUser
     * create a new user 
     */
    public function createUser():array{
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $firstname  =   trim($_POST['firstname']??'');
            $lastname   =   trim($_POST['lastname']??'');
            $email      =   trim($_POST['email']??'');
            $password   =   trim($_POST['password_hash']??'');
            $role       =   ($_POST['role']??'');
            $companyId  =   (int)($_POST['company']??0);

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
    public function deleteUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            return (new UserRepository())->delete((int) $_POST['delete_id']);
        }
        return false;
    }



    /**
     * Summary of changeUserState
    */
    public function changeUserState(){


    }



    /**
     * Summary of listAllUsers
     */
    public function listAllUsers():array{
        $userRepositoryObj = (new UserRepository())->load();
        $array = [];
        foreach ($userRepositoryObj as $data){
            $array [] = $data->toArray();
        }
        return $array;
    }








}


?>