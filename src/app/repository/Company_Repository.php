<?php
namespace src\app\model;
use src\core\DB;

class Company_Repository {
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }

    /**
     * Summary of save
     * @param Company $company    
     * saves a company to the database
     */
    public function save(Company $company){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "INSERT INTO companies (name, contact_person, contact_email) 
                                 VALUES (:name, :contact_person,:contact_email)"
                            );
        return $stmt->execute ([
            ':name' => $company->getName(),
            ':contact_person' => $company->getContactPerson(),
            ':contact_email' => $company->getContactEmail()
        ]);
    }
    /**
     * Summary of load
     * loads all companies from the database
     */
    public function load(){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT * FROM companies"
                            );
        $stmt->execute();
        $companies = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $companies[] = new Company($data['id'], $data['state'], $data['name'], $data['contact_person'], $data['contact_email']);
        }
        return $companies;
    }
    /**
     * Summary of update
     * @param Company $company
     * updates a company in the database
     */
    public function update(Company $company){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "UPDATE companies 
                                 SET name = :name, contact_person = :contact_person, contact_email = :contact_email
                                 WHERE id = :id"
                            );
        return $stmt->execute ([
            ':id' => $company->getId(),
            ':name' => $company->getName(),
            ':contact_person' => $company->getContactPerson(),
            ':contact_email' => $company->getContactEmail()
        ]);
    }
    /**
     * Summary of changeState
     * @param Company $company
     * changes the state of a company in the database
     */
    public function changeState(Company $company){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "UPDATE companies 
                                 SET state = :state
                                 WHERE id = :id"
                            );
        return $stmt->execute ([
            ':id' => $company->getId(),
            ':state' => $company->getState()
        ]);
    }
    

}
?>