<?php
namespace src\app\model;

class Course{
    private int $id;
    private string $title;
    private string $description;
    private array $course_sessions;

    function __construct(int $id, string $title, string $description, array $course_sessions) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->course_sessions = $course_sessions;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'course_sessions' => $this->course_sessions
        ];
    }   

    public function getId(): int {
        return $this->id;
    }
    public function getTitle(): string {
        return $this->title;
    }
    public function getDescription(): string {
        return $this->description;
    }    
    public function getCourseSessions(): array {
        return $this->course_sessions;
    }


    public function setId(int $id): void {
        $this->id = $id;
    }   
    public function setTitle(string $title): void {
        $this->title = $title;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }
    public function setCourseSessions(array $course_sessions): void {
        $this->course_sessions = $course_sessions;
    }



    


}

?>