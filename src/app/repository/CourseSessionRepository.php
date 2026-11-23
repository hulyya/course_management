<?php
namespace src\app\repository;
use src\app\model\CourseSession;   
use src\app\core\DB;

class CourseSessionRepository {
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }



    /**
     * Summary of save
     * @param CourseSession $courseSession    
     * saves a course session to the database
     * 
     */
    public function save(CourseSession $courseSession){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "INSERT INTO course_sessions 
                                (course_id, 
                                start_time, 
                                end_time, 
                                location_id, 
                                trainer_id) 
                                 VALUES 
                                (:course_id, 
                                :start_time, 
                                :end_time, 
                                :location_id, 
                                :trainer_id)"
                                );

        return $stmt->execute ([
            ':course_id'    => $courseSession->getCourse()->getId(),
            ':start_time'   => $courseSession->getStartTime()->format('H:i:s'),
            ':end_time'     => $courseSession->getEndTime()->format('H:i:s'),
            ':location_id'  => $courseSession->getLocation()->getId(),
            ':trainer_id'   => $courseSession->getTrainer()->getId()
        ]);
    }



    /**
     * Summary of load
     * @return array<CourseSession> returns an array of course sessions from the database
     * by course id!
     */
    public function load(int $courseId):array{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT * 
                                FROM course_sessions 
                                WHERE course_id = :course_id"
                                );

        $stmt->execute([
            ':course_id' => $courseId
        ]);

        $course_sessions = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $course_sessions[] = new CourseSession(
                (int) $data['id'],
                new \DateTime($data['start_time']),
                new \DateTime($data['end_time']),
                (new UserRepository())->getUserbyId((int) $data['trainer_id']),
                (new LocationRepository())->getLocationById((int) $data['location_id']),
                (new CourseRepository())->getCourseById((int) $data['course_id'])
            );
        }
        return $course_sessions;
    }



    /**
     * Summary of delete
     * @param int $id
     * deletes a course session from the database by id
     */
    public function delete(int $id):bool{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "DELETE FROM course_sessions 
                                WHERE id = :id"
                                );
        return $stmt->execute([
            ':id' => $id
        ]);
    }



    /**
     * Summary of update()
     * @param CourseSession $courseSession
     * updates edits in course session in the database
     */
    public function update(CourseSession $courseSession):bool{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "UPDATE course_sessions 
                                 SET 
                                 start_time = :start_time, 
                                 end_time = :end_time, 
                                 location_id = :location_id, 
                                 trainer_id = :trainer_id, 
                                 course_id = :course_id
                                 WHERE id = :id"
                                );

        return $stmt->execute([
            ':id'           => $courseSession->getId(),
            ':start_time'   => $courseSession->getStartTime(),
            ':end_time'     => $courseSession->getEndTime(),
            ':location_id'  => $courseSession->getLocation(),
            ':trainer_id'   => $courseSession->getTrainer(),
            ':course_id'    => $courseSession->getCourse()
        ]);
    }



    /**
     * Summary of loadAllTrainerSessions
     * @param int $trainer_id
     * returns an array of course sessions from the database by trainer id
     */
    public function loadAllTrainerSessions(int $trainer_id):array{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT * 
                                FROM course_sessions 
                                WHERE trainer_id = :trainer_id"
                                );

        $stmt->execute([
            ':trainer_id' => $trainer_id
        ]);
        $course_sessions = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $course_sessions[] = new CourseSession(
                $data['id'], 
                $data['start_time'], 
                $data['end_time'], 
                $data['trainer_id'], 
                $data['location_id'],  
                $data['course_id']);
        }
        return $course_sessions;
    }



    /**
     * Summary of getCourseSessionById
     * 
     */
    public function getCourseSessionById(int $id){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT *
                                FROM course_sessions
                                WHERE id = :id"
                                );

        $stmt->execute([
            'id' => $id
        ]);
        $data =$stmt->fetch(\PDO::FETCH_ASSOC);
        if($data){
            return new CourseSession(
                $data['id'],
                $data['start_time'], 
                $data['end_time'], 
                $data['trainer_id'], 
                $data['location_id'],  
                $data['course_id']
                
            );
        }
        return null;

    }


}
?>