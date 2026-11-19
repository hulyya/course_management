<?php
namespace src\app\controller;

use src\app\model\Company;
use src\app\repository\Company_Repository;

class Company_Controller{
    /**
     * Summary of createCompany
     * create a new Company
     */
    public function createCompany(){

        $formData = [
            'name' =>'',
            'contact_person'=>'',
            'contact_email'=>''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name           =   trim($_POST['name']??'');
            $contact_person =   trim($_POST['contact_person']??'');
            $contact_email  =   trim($_POST['contact_email']??'');

            $formData['name']           =   $name;
            $formData['contact_person'] =   $contact_person;
            $formData['contact_email']  =   $contact_email;

            $company = new Company(0, true, $name, $contact_person, $contact_email);
            (new Company_Repository())->save($company);
            return $formData;
        }
        return $formData;
    }



    /**
     * Summary of editCompany
     */
    public function editCompany(){
         $formData = [
            'name' =>'',
            'contact_person'=>'',
            'contact_email'=>''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id             =   trim($_POST['id']??'');
            $name           =   trim($_POST['name']??'');
            $contact_person =   trim($_POST['contact_person']??'');
            $contact_email  =   trim($_POST['contact_email']??'');

            $formData['name']           =   $name;
            $formData['contact_person'] =   $contact_person;
            $formData['contact_email']  =   $contact_email;

            $company = new Company($id, true, $name, $contact_person, $contact_email);
            (new Company_Repository())->update($company);
            return $formData;
        }
        return $formData;
    }



    /**
     * Summary of changeCompanyState
     */
    public function changeCompanyState(){

    }



    /**
     * Summary of listAllCompanies
     */
    public function listAllCompanies(){
        $companyRepositoryObj = (new Company_Repository()->load());
        $array  = [];

        foreach ($companyRepositoryObj as $data){
            $array []   = $data->toArray();
        }
        return $array;

    }


}
?>