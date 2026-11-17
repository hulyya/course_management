<?php
namespace src\app\repository;
use src\app\model\Registration;
use src\app\core\DB;

class Registration_Repository{
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }
    /**
     * Summary of save
     * @param Registration $registration
     * saves a registration to the database
     */
    public function save(Registration $registration){
        $pdo = $this->db->getConnection();
        $stmt =$pdo->prepare(
                        "INSERT INTO registrations (user_id, session_id, rehistration_state) 
                        VALUES (:user_id, :session_id, :registration_state)"
                    );
        return $stmt->execute([
            ':user_id' => $registration->getUser()->getId(),
            ':session_id' => $registration->getSession()->getId(),
            ':registration_state' => $registration->getRegistrationState(),
        ]);
    }
    /**
     * Summary of load
     * loads all registrations from the database
     * returns an array of Registration objects
     */
    public function load(): array {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT id, user_id, session_id, registration_state, cancelled_at, cancellation_reason
                                FROM registrations"
                            );
        $stmt->execute();
        $registrations = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $registrations[] = new Registration(
                                                    $data['id'], 
                                                    $data['user_id'],
                                                    $data['registration_state'],
                                                    $data['session_id'], 
                                                    $data['cancelled_at'],
                                                    $data['cancellation_reason']
                                                );
        }
        return $registrations;
    }
    /**
     * Summary of upodate
     * updates a registration in the database
     * @param Registration $registration
     */
    public function update(Registration $registration){
        $pdo = $this->db->getConnection();
        $stmt =$pdo->prepare(
                        "UPDATE registrations 
                        SET user_id = :user_id, session_id = :session_id, registration_state = :registration_state, cancelled_at = :cancelled_at, cancellation_reason = :cancellation_reason
                        WHERE id = :id"
                    );
        return $stmt->execute([
            ':id' => $registration->getId(),
            ':user_id' => $registration->getUser()->getId(),
            ':session_id' => $registration->getSession()->getId(),
            ':registration_state' => $registration->getRegistrationState(),
            ':cancelled_at' => $registration->getCancelledAt()->format('Y-m-d'),
            ':cancellation_reason' => $registration->getCancellationReason()
        ]);
    }



}
?>