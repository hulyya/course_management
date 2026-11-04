<?php
namespace src\app\repository;
use src\core\DB;
use src\app\model\User; 
class User_Repository{
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }

    /**
     * Summary of save
     * @param User $user
     * saves a user to the database 
     */ 
    public function save(User $user){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "INSERT INTO users 
                                        (firstname, lastname, email, password_hash, role, company_id) 
                                 VALUES 
                                        (:firstname, :lastname, :email, :password_hash, :role, :company_id)"
                            );
        return $stmt->execute ([
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole(),
            ':company_id' => $user->getCompany()->getId()
        ]);
    
    }
    /**
     * Summary of load
     * loads all users from the database
     * 
     * PROBLEMMMMMM PASSSWORD
     */
    public function load(int $id){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT id, state, firstname, lastname, email, role, company_id 
                                FROM users"
                            );
        $users = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new User(
                                    $data['id'], 
                                    $data['state'], 
                                    $data['firstname'], 
                                    $data['lastname'], 
                                    $data['email'], 
                                    null,
                                    $data['role'], 
                                    $data['company_id'],
                                );
        }
        return $users;
    }
    /**
     * Summary of update
     * @param User $user
     * updates a user in the database
     */
    public function update(User $user){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "UPDATE users 
                                 SET state = :state, firstname = :firstname, lastname = :lastname, email = :email, role = :role, company_id = :company_id
                                 WHERE id = :id"
                            );
        return $stmt->execute([
            ':id' => $user->getId(),
            ':state' => $user->getState(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':email' => $user->getEmail(),
            ':role' => $user->getRole(),
            ':company_id' => $user->getCompany()->getId()
        ]);
    }
    /**
     * Summary of changeState
     * @param User $user
     * changes the state of a user in the database
     */
    public function changeState(User $user){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "UPDATE users 
                                 SET state = :state
                                 WHERE id = :id"
                            );
        return $stmt->execute([
            ':id' => $user->getId(),
            ':state' => $user->getState()
        ]);
    }
    /**
     * Summary of loadUserById
     * @param int $id   
     * loads a user from the database for session
     */
    public function loadUserById(int $id){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT id, state, firstname, lastname, email, role, company_id 
                                FROM users
                                WHERE id = :id"
                            );
        $stmt->execute([
            ':id' => $id
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($data){
            return new User(
                            $data['id'], 
                            $data['state'], 
                            $data['firstname'], 
                            $data['lastname'], 
                            $data['email'], 
                            null,
                            $data['role'], 
                            $data['company_id'], 
                        );
        }
        return null;
    }
    /**
     * Summary of loasdUserByEmail
     * @param string $email 
     * loads a user from the database by email for login
     */
    public function loadUserByEmail(string $email){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT id, state, firstname, lastname, email, password_hash, role, company_id 
                                FROM users
                                WHERE email = :email"
                            );
        $stmt->execute([
            ':email' => $email
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($data){
            return new User(
                            $data['id'], 
                            $data['state'], 
                            $data['firstname'], 
                            $data['lastname'], 
                            $data['email'], 
                            null,
                            $data['role'], 
                            $data['company_id'], 
                        );
        }
        return null;
    }

}
?>