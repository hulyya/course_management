<?php
namespace src\app\controller;
use DateTime;
use src\app\repository\CourseSessionRepository;
use src\app\repository\CourseRepository;
use src\app\model\CourseSession;
use src\app\repository\LocationRepository;
use src\app\repository\UserRepository;

class CourseSessionController {

    /**
     * Summary of createSession
     * creates a session within a chosen course
     */
    public function createSession(){
        $trainers = (new UserRepository())->getAllTrainer();
        $locations = (new LocationRepository())->getAllLocations();
        
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
            $end_time   = trim($_POST['end_time']??'');
            $trainer    = ($_POST['trainer']??0);
            $location   = ($_POST['location']??0);
            $courseId   = ($_POST['courseId']??0);
            
            $formData['start_time'] = $start_time;
            $formData['end_time']   = $end_time;
            $formData['trainer']    = $trainer;
            $formData['location']   = $location;

            $id          = 0;
            $startObj    = new \DateTime($start_time);
            $endObj      = new \DateTime($end_time);
            $trainerObj  = (new UserRepository())->getUserById($trainer);
            $locationObj = (new LocationRepository())->getLocationById($location);
            $courseObj   = (new CourseRepository())->getCourseById($courseId);

            $session = new CourseSession($id, $startObj, $endObj, $trainerObj, $locationObj, $courseObj);
            (new CourseSessionRepository())->save($session);
        }
        return $formData;
    }



    /**
     * Summmary of editSession
     */
    public function editSession(): array {
        $trainers  = (new UserRepository())->getAllTrainer();
        $locations = (new LocationRepository())->getAllLocations();

        $formData = [
            'id'         => 0,
            'start_time' => '',
            'end_time'   => '',
            'trainer'    => 0,
            'location'   => 0,
            'courseId'   => 0,
            'trainers'   => $trainers,
            'locations'  => $locations,
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
            $trainerObj  = (new UserRepository())->getUserById($trainer);
            $locationObj = (new LocationRepository())->getLocationById($location);
            $courseObj   = (new CourseRepository())->getCourseById($courseId);

            $session = new CourseSession($id, $startObj, $endObj, $trainerObj, $locationObj, $courseObj);
            (new CourseSessionRepository())->update($session);
        }
        return $formData;
    }



    /**
     * Summary of deleteSession
     */
    public function deleteSession(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            return (new CourseSessionRepository())->delete((int) $_POST['delete_id']);
        }
        return false;
    }



    /**
     * Summary of listAllSessions
     */
    public function listAllSessions(int $courseId): array{
        $sessionRepositoryObjekt = (new CourseSessionRepository())->load($courseId);
        $array = [];
        foreach ($sessionRepositoryObjekt as $data){
            $array [] = $data->toArray();    
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
    public function listAllTrainerSessions(int $trainerId){
        $sessionRepositoryObj = (new CourseSessionRepository())->loadAllTrainerSessions($trainerId);
        $array = [];
        foreach ($sessionRepositoryObj as $data){
            $array [] = $data->toArray();
        }
        return $array;
    }


    
    /**
     * Summary showTrainerSessions
     */
    public function showTrainerSessions(){

    }
    






}



?>