<?php
namespace src\app\controller;

use src\app\model\User;
use src\app\repository\Company_Repository;
use src\app\repository\User_Repository;

class User_Controller{

    /**
     * Summary of createUser
     * creates a new user 
     */
    public function createUser():array{
        $companyRepo = new Company_Repository();
        $userRepo = new User_Repository();

        $companies = (new Company_Repository())->getAllCompanies();
        $roles =$userRepo->getAllRoles();

        $formData = [
            'firstname'=>'',
            'lastname'=>'',
            'email'=>'',
            'password_hash'=>'',
            'role'=>'',
            'company'=>0,
            'roles'=> $roles,
            'companies'=>$companies
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $firstname =trim($_POST['firstname']??'');
            $lastname =trim($_POST['lastname']??'');
            $email =trim($_POST['email']??'');
            $password =trim($_POST['password_hash']??'');
            $role =($_POST['role']??'');
            $companyId =(int)($_POST['company']??0);

            $formData['firstname']=$firstname;
            $formData['lastname']=$lastname;
            $formData['email']=$email;
            $formData['password_hash']=$password;
            $formData['role']=$role;
            $formData['company']=$companyId;
            
            if ($firstname !== '' && $lastname !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $password !== '') {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $companyObj   = $companyRepo->getCompanyById($companyId);

                $user = new User(0, true, $firstname, $lastname, $email, $passwordHash, $role, $companyObj);
                (new User_Repository())->save($user);
                return $formData;
            }
        }
        return $formData;
    }



    /**
     * Summary of editUser
     */
    public function editUser(){

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

    }








}


?>