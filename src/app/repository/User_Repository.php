<?php
namespace src\app\repository;
use src\app\core\DB;
use src\app\model\User; 
use src\app\repository\Company_Repository;
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
                                        (id,
                                        state,
                                        firstname, 
                                        lastname, 
                                        email, 
                                        password_hash, 
                                        role_id, 
                                        company_id) 
                                 VALUES 
                                        (:id,
                                        :state,
                                        :firstname, 
                                        :lastname, 
                                        :email, 
                                        :password_hash, 
                                        :role_id, 
                                        :company_id)"
                            );
        return $stmt->execute ([
            ':id'=>$user->getId(),
            ':state'=>$user->getState(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':email' => $user->getEmail(),
            ':password_hash' => $user->getPassword(),
            ':role_id' => $user->getRole(),
            ':company_id' => $user->getCompany()->getId()
        ]);
    
    }


    /**
     * Summary of delete
     * @param int $id
     * deletes a user from the database 
     */
    public function delete(int $id){
        $pdo =$this->db->getConnection();
        $stmt =$pdo->prepare(
                                "DELETE FROM users
                                WHERE id=:id"
                            );
        return $stmt->execute([
            'id'=>$id
        ]);
    }




    /**
     * Summary of load
     * loads all users from the database
     * 
     * PROBLEMMMMMM PASSSWORD
     */
    public function load(){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT *
                                FROM users"
                            );
        $stmt->execute();
        $users = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new User(
                                    $data['id'], 
                                    $data['state'], 
                                    $data['firstname'], 
                                    $data['lastname'], 
                                    $data['email'], 
                                    '',
                                    $data['role_id'], 
                                    (new Company_Repository())->getCompanyById((int) $data['company_id'])
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
                                 SET    state = :state, 
                                        firstname = :firstname, 
                                        lastname = :lastname, 
                                        email = :email, 
                                        role_id = :role_id, 
                                        company_id = :company_id
                                 WHERE id = :id"
                            );
        return $stmt->execute([
            ':id' => $user->getId(),
            ':state' => $user->getState(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':email' => $user->getEmail(),
            ':role_id' => $user->getRole(),
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
                                "SELECT 
                                    users.id, 
                                    users.state, 
                                    users.firstname, 
                                    users.lastname, 
                                    users.email, 
                                    users.password_hash,
                                    users.company_id,
                                    roles.name AS role
                                FROM users
                                LEFT JOIN roles ON users.role_id = roles.id
                                WHERE users.id = :id"
                            );
        $stmt->execute([
            ':id' => $id
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($data){
            return new User(
                            (int) $data['id'], 
                            (bool) $data['state'], 
                            $data['firstname'], 
                            $data['lastname'], 
                            $data['email'], 
                            $data['password_hash'] ?? '', 
                            $data['role'] ?? 'Unbekannt', 
                            (new Company_Repository())->getCompanyById((int) $data['company_id'])
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
                                "SELECT id, 
                                state, 
                                firstname, 
                                lastname, 
                                email, 
                                password_hash, 
                                role_id, 
                                company_id 
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
                            $data['password_hash'],
                            $data['role_id'], 
                            $data['company_id'], 
                        );
        }
        return null;
    }



    /**
     * Summary of getAllTrainer
     * to get all trainer from users for dropdown form
     */
    public function getAllTrainer():array{
        $pdo = $this->db->getConnection();
        $stmt =$pdo ->prepare(
                                 "SELECT 
                                        users.id, 
                                        users.firstname, 
                                        users.lastname 
                                FROM users
                                LEFT JOIN roles ON users.role_id = roles.id
                                WHERE roles.name = 'trainer'
                            ");
    $stmt->execute();
    
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    /**
     * Summary of getAllRoles
     */
    public function getAllRoles():array{
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query("SELECT id, name FROM roles");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
?>