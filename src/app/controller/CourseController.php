<?php
namespace src\app\controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use src\app\repository\CourseRepository;
use src\app\model\Course;
use src\app\repository\CourseSessionRepository;
use src\app\model\CourseSession;
use src\app\repository\LocationRepository;
use src\app\repository\UserRepository;
use src\app\view\admin\AdminCourse;
use src\app\view\admin\AdminCourseSessionEdit;
use DateTime;

class CourseController {
    /**
     * Summary of adminListCourseSite
     * @return Response
     * Shows a page with all Courses and Sessions
     */
    public function adminListCourseSite():Response{
        $courses = $this->listAllCourses();
        $view = new AdminCourse();
        $view->setData($courses);
        return new Response($view->render());
    }

    /**
     * Summary of adminCourseSite
     * @return Response
     * Shows a page with editing choices for a Course
     */
    public function adminCourseSite($request, $id):Response{
        $course = $this->showCourse($id);
        $session = $this->listAllSessions($id);
        $view = new AdminCourseSessionEdit();
        $data = [
            "course" => $course,
            "session" => $session
        ];
        $view->setData($data); 
        return new Response($view->render());
    }
        
    
    /**
     * Summary of createCourse()
     * creates one course
     */
    public function createCourse(Request $request) {
        $title       = trim($request->request->get('title', ''));
        $description = trim($request->request->get('description', ''));

        $course = new Course(0, $title, $description, true, []);
        (new CourseRepository())->save($course);
        return new RedirectResponse('/course_management/public/index.php/admin');
    }

    /**
     * Summary of editCourse()
     * possibility to change Values in a Course
     */
    public function editCourse(Request $request){
            $id          = (int) ($request->request->get('edit_id'));
            $title       = trim($request->request->get('title'));
            $description = trim($request->request->get('description'));
            
            $course = new Course($id, $title, $description, true, []);
            (new CourseRepository())->update($course);
            return new RedirectResponse('/course_management/public/index.php/admin/course/{id}');
    }

    /**
     * Summary of deleteCourse()
     * deletes a course
     */
    public function deleteCourse(Request $request):Response{
            (new CourseRepository())->delete((int) ($request->request->get('delete_id')));
            return new RedirectResponse('/admin/course');
    }

    /**
     * Summary of listAllCourses
     * lists all Courses from the database
     */
    private function listAllCourses(){
        $courseList = (new CourseRepository())->load();
        foreach ($courseList as $course ){
            $sessionList = $this->listAllSessions($course->getId());
            $course->setCourseSessions($sessionList);
        }
        return $courseList;
    }

    /**
     * Summary of showCourse
     * shows a specific Course
     */
    public function showCourse(int $id){
        $courseRepositoryObject = (new CourseRepository())->getCourseById($id);
        return $courseRepositoryObject;
    }

    /**
     * Summary of createSession
     * @param Request $request
     * @return array{"end_time": string, location: int, locations: array, "start_time": string, trainer: int, trainers: array}
     */
    public function createSession(Request $request){
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
        if ($request->isMethod('POST')) {
            $start_time = trim($request->request->get('start_time'));
            $end_time   = trim($request->request->get('end_time'));
            $trainer    = $request->request->getInt('trainer');
            $location   = $request->request->getInt('location');
            $courseId   = $request->request->getInt('courseId');
            
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
    public function editSession(Request $request): array {
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

        if ($request->isMethod('POST') && $request->request->has('edit_id')) {
            $id         = (int) ($request->request->get('edit_id'));
            $start_time = trim($request->request->get('start_time'));
            $end_time   = trim($request->request->get('end_time'));
            $trainer    = $request->request->getInt('trainer');
            $location   = $request->request->getInt('location');
            $courseId   = $request->request->getInt('courseId');

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
    public function deleteSession(Request $request){
            return (new CourseSessionRepository())->delete((int) ($request->request->get('delete_id')));

    }

    /**
     * Summary of listAllSessions
     * @return array 
     */
    public function listAllSessions(int $courseId): array{
        $sessionList = (new CourseSessionRepository())->load($courseId);
        return $sessionList;
    }
    
    /**
     * Summary of listAllOldSessions
     */
    public function listAllOldSessions(){
    }
    
    /**
     * Summary of listAllTrainerSessions
     * shows all trainer sessions  /???????
     */
    public function listAllTrainerSessions(int $trainerId){
        $trainerSessionList = (new CourseSessionRepository())->loadAllTrainerSessions($trainerId);
        return $trainerSessionList;
    }
}
?>