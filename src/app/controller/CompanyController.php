<?php
namespace src\app\controller;

use Symfony\Component\HttpFoundation\Request;
use src\app\model\Company;
use src\app\repository\CompanyRepository;

class CompanyController{
    
    /**
     * Summary of adminCompanySite
     */
    public function adminCompanySite(){

    }


    /**
     * Summary of createCompany
     * create a new Company
     */
    public function createCompany(Request $request){
            $name           =   trim($request->request->get('name'));
            $contact_person =   trim($request->request->get('contact_person'));
            $contact_email  =   trim($request->request->get('contact_email'));

            $company = new Company(0, true, $name, $contact_person, $contact_email);
            return (new CompanyRepository())->save($company);
    }

    /**
     * Summary of editCompany
     */
    public function editCompany(Request $request){
            $id             =   trim($request->request->get('id'));
            $name           =   trim($request->request->get('name'));
            $contact_person =   trim($request->request->get('contact_person'));
            $contact_email  =   trim($request->request->get('contact_email'));

            $company = new Company($id, true, $name, $contact_person, $contact_email);
            return (new CompanyRepository())->update($company);
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
        $companyRepositoryObj = (new CompanyRepository()->load());
        $array = [];
        foreach ($companyRepositoryObj as $data){
            $array [] = $data->toArray();
        }
        return $array;
    }
}
?>