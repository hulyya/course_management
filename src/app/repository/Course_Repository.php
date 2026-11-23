<?php
namespace src\app\repository;
use src\app\model\Course;
use src\app\core\DB;

class Course_Repository {
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }


    
    /**
     * Summary of save
     * @param Course $course
     * saves a course to the database
     */
    public function save(Course $course){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "INSERT INTO courses 
                                (title, 
                                description) 
                                VALUES 
                                (:title, 
                                :description)"
                                );


        return $stmt->execute ([
            ':title'        => $course->getTitle(),
            ':description'  => $course->getDescription()
        ]);
    }



    /**
     * Summary of load
     * @return array<Course> returns an array of courses from the database
     */
    public function load():array{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->query(
                                "SELECT * 
                                FROM courses"
                            );

        $courses = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $data['id'],  
                $data['title'], 
                $data['description'], 
                $data['state'], 
                []
            );
        }
        return $courses;
    }



    /**
     * Summary of delete
     * @param int $id
     * deletes a course from the database by id
     */
    public function delete(int $id):bool{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "DELETE FROM courses 
                                 WHERE id = :id"
                                );
        return $stmt->execute([
            ':id' => $id
        ]);
    }



    /**
     * Summary of update
     * @param Course $course    
     * updates a course in the database
     */
    public function update(Course $course):bool{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "UPDATE courses 
                                SET 
                                title = :title, 
                                description = :description 
                                WHERE id = :id"
                                );

        return $stmt->execute([
            ':id'           => $course->getId(),
            ':title'        => $course->getTitle(),
            ':description'  => $course->getDescription()
        ]);
    }



    /**
     * Summary of getCourseById
     * @param int $id
     * returns a course from the database by id
     */
    public function getCourseById(int $id){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT * 
                                FROM courses 
                                WHERE id = :id"
                                );

        $stmt->execute([
            ':id' => $id
        ]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new Course(
                $data['id'], 
                $data['title'], 
                $data['description'], 
                $data['state'], 
                []
            );
        }
        return null;
    }
}
?>