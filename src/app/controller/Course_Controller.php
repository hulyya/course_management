<?php
namespace src\app\controller;
use src\app\repository\Course_Repository;
use src\app\model\Course;

class Course_Controller {
    /**
     * Summary of createCourse()
     * creates one course
     */
    public function createCourse() {
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title          = trim($_POST['title']??'');
            $description    = trim($_POST['description']??'');

            $formData = [
                'title'         => $title,
                'description'   => $description
            ];      

            $course = new Course(0, $title, $description, true, []);
            return (new Course_Repository())->save($course);
        }
        return $formData;
    }


    /**
     * Summary of editCourse()
     * posibility to change Values in a Course
     */
    public function editCourse():bool{
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
            $id          = (int) $_POST['edit_id'];
            $title       = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $course = new Course($id, $title, $description, true, []);
            return (new Course_Repository())->update($course);
        }
        return false;
    }



    /**
     * Summary of deleteCourse()
     * deletes a course
     */
    public function deleteCourse():bool{
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            return (new Course_Repository())->delete((int) $_POST['delete_id']);
        }
        return false;
    }



    /**
     * Summary of listAllCourses
     * lists all Courses from the database
     */
    public function listAllCourses(){
        $courseRepositoryObject = (new Course_Repository())->load();
        $array = [];
        foreach ($courseRepositoryObject as $data ){
            $array [] = $data->toArray();
        }
        return $array;
    }



    /**
     * Summary of showCourse
     * shows a specific Course
     */
    public function showCourse(int $id){
        $courseRepositoryObject = (new Course_Repository())->getCourseById($id);
        $courseArray = $courseRepositoryObject->toArray();
        return $courseArray;
    }
}
?>