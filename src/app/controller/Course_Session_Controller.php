<?php
namespace src\app\controller;
use DateTime;
use src\app\repository\Course_Session_Repository;
use src\app\repository\Course_Repository;
use src\app\model\Course_Session;
use src\app\repository\Location_Repository;
use src\app\repository\User_Repository;

class Course_Session_Controller {
    /**
     * Summary of createSession
     * creates a session within a chosen course
     */
    public function createSession(){
        $trainers = (new User_Repository())->getAllTrainer();
        $locations = (new Location_Repository())->getAllLocations();
        
         $formData = [
            'start_time' => '',
            'end_time'   => '',
            'trainer'    => 0,
            'location'   => 0,
            'trainers'   => $trainers,
            'locations'  => $locations
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $start_time = trim($_POST['start_time']??'');
            $end_time = trim($_POST['end_time']??'');
            $trainer = ($_POST['trainer']??0);
            $location= ($_POST['location']??0);
            $courseId = ($_POST['courseId']??0);
            
            $formData['start_time'] =$start_time;
            $formData['end_time'] =$end_time;
            $formData['trainer'] = $trainer;
            $formData['location'] = $location;

 
            $id          = 0;
            $startObj    = new \DateTime($start_time);
            $endObj      = new \DateTime($end_time);
            $trainerObj  = (new User_Repository())->loadUserById($trainer);
            $locationObj = (new Location_Repository())->getLocationById($location);
            $courseObj   = (new Course_Repository())->getCourseById($courseId);

            $session = new Course_Session($id, $startObj, $endObj, $trainerObj, $locationObj, $courseObj);
            (new Course_Session_Repository())->save($session);
        }
        return $formData;
    }



    /**
     * Summmary of editSession
     */
    public function editSession(): array {
    $trainers  = (new User_Repository())->getAllTrainer();
    $locations = (new Location_Repository())->getAllLocations();

    $formData = [
        'id'         => 0,
        'start_time' => '',
        'end_time'   => '',
        'trainer'    => 0,
        'location'   => 0,
        'courseId'   => 0,
        'trainers'   => $trainers,
        'locations'  => $locations,
        'success'    => false
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
        $id         = (int) $_POST['edit_id'];
        $start_time = trim($_POST['start_time'] ?? '');
        $end_time   = trim($_POST['end_time'] ?? '');
        $trainer    = (int) ($_POST['trainer'] ?? 0);
        $location   = (int) ($_POST['location'] ?? 0);
        $courseId   = (int) ($_POST['courseId'] ?? 0);

        $formData['id']         = $id;
        $formData['start_time'] = $start_time;
        $formData['end_time']   = $end_time;
        $formData['trainer']    = $trainer;
        $formData['location']   = $location;
        $formData['courseId']   = $courseId;

        $startObj    = new \DateTime($start_time);
        $endObj      = new \DateTime($end_time);
        $trainerObj  = (new User_Repository())->loadUserById($trainer);
        $locationObj = (new Location_Repository())->getLocationById($location);
        $courseObj   = (new Course_Repository())->getCourseById($courseId);

        $session = new Course_Session($id, $startObj, $endObj, $trainerObj, $locationObj, $courseObj);
        $formData['success'] = (new Course_Session_Repository())->update($session);
    }
    return $formData;
    }



    /**
     * Summary of deleteSession
     */
    public function deleteSession(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            return (new Course_Session_Repository())->delete((int) $_POST['delete_id']);
        }
        return false;
    }



    /**
     * Summary of listAllSessions
     */
    public function listAllSessions(int $courseId): array{
        $sessionRepositoryObjekt = (new Course_Session_Repository())->load($courseId);
        $array =[];
        foreach ($sessionRepositoryObjekt as $data){
            $array [] =$data->toArray();    
        }
        return $array;
    }


    
    /**
     * Summary of listAllOldSessions
     */
    public function listAllOldSessions(){
        $currentTime = new DateTime('today');
    }
    


    /**
     * Summary of listAllTrainerSessions
     * shows all sessions from on trainer
     */
    public function listAllTrainerSessions(){

    }


    
    /**
     * Summary showTrainerSessions
     */
    public function showTrainerSessions(){

    }
    






}



?>