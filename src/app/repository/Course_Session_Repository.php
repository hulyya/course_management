<?php
namespace src\app\repository;
use src\app\model\Course_Session;   
use src\config\DB;

class Course_Session_Repository {
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }

    /**
     * Summary of save
     * @param Course_Session $course_session    
     * saves a course session to the database
     * 
     * ????? insert location_id, course_id and trainer_id into the database
     */
    public function save(Course_Session $course_session){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "INSERT INTO course_sessions (course_id, date,start_time, end_time, location_id, trainer_id) 
                                 VALUES (:course_id, :date,:start_time, :end_time), :location_id, :trainer_id");
        return $stmt->execute ([
            ':course_id' => $course_session->getCourse(),
            ':date' => $course_session->getDate(),
            ':start_time' => $course_session->getStartTime(),
            ':end_time' => $course_session->getEndTime(),
            ':location_id' => $course_session->getLocation(),
            ':trainer_id' => $course_session->getTrainer()
        ]);
    }
    /**
     * Summary of load
     * @return array<Course_Session> returns an array of course sessions from the database
     */
    public function load(){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query(
                                "SELECT * FROM course_sessions"
                            );
        $course_sessions = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $course_sessions[] = new Course_Session($data['id'], $data['date'], $data['start_time'], $data['end_time'], $data['location_id'], $data['trainer_id'], $data['course_id'], $data['max_participants']);
        }
        return $course_sessions;
    }
    /**
     * Summary of update()
     * @param Course_Session $course_session
     * updates edits in course session in the database
     */
    public function update(Course_Session $course_session){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "UPDATE course_sessions 
                                 SET date = :date, start_time = :start_time, end_time = :end_time, location_id = :location_id, trainer_id = :trainer_id, course_id = :course_id
                                 WHERE id = :id"
                            );
        return $stmt->execute([
            ':id' => $course_session->getId(),
            ':date' => $course_session->getDate(),
            ':start_time' => $course_session->getStartTime(),
            ':end_time' => $course_session->getEndTime(),
            ':location_id' => $course_session->getLocation(),
            ':trainer_id' => $course_session->getTrainer(),
            ':course_id' => $course_session->getCourse()
        ]);
    }
    /**
     * Summary of delete
     * @param int $id
     * deletes a course session from the database by id
     */
    public function delete(int $id){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "DELETE FROM course_sessions 
                                 WHERE id = :id"
                            );
        return $stmt->execute([
            ':id' => $id
        ]);
    }
    /**
     * Summary of loadAllTrainerSessions
     * @param int $trainer_id
     * returns an array of course sessions from the database by trainer id
     */
    public function loadAllTrainerSessions(int $trainer_id){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare(
                                "SELECT * FROM course_sessions 
                                 WHERE trainer_id = :trainer_id"
                            );
        $stmt->execute([
            ':trainer_id' => $trainer_id
        ]);
        $course_sessions = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $course_sessions[] = new Course_Session($data['id'], $data['date'], $data['start_time'], $data['end_time'], $data['location_id'], $data['trainer_id'], $data['course_id'], $data['max_participants']);
        }
        return $course_sessions;
    }


}
?>