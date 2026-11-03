<?php
namespace src\app\model;

use DateTime;

class Course_Session {
    private int $id;
    private DateTime $date;
    private DateTime $start_time;
    private DateTime $end_time;
    private int $participants;
    private User $trainer;
    private Location $location;
    private Course $course;

    function __construct(int $id, DateTime $date, DateTime $start_time, DateTime $end_time, int $participants, User $trainer, Location $location, Course $course) {
        $this->id = $id;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->participants = $participants;
        $this->trainer = $trainer;
        $this->location = $location;
        $this->course = $course;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'start_time' => $this->start_time->format('H:i:s'),
            'end_time' => $this->end_time->format('H:i:s'),
            'participants' => $this->participants,
            'trainer' => $this->trainer->toArray(),
            'location' => $this->location->toArray(),
            'course' => $this->course->toArray()
        ];
    }

    public function getId(): int {
        return $this->id;
    }   
    public function getDate(): DateTime {
        return $this->date;
    }
    public function getStartTime(): DateTime {
        return $this->start_time;
    }
    public function getEndTime(): DateTime {
        return $this->end_time;
    }
    public function getParticipants(): int {
        return $this->participants;
    }
    public function getTrainer(): User {
        return $this->trainer;
    }
    public function getLocation(): Location {
        return $this->location;
    }
    public function getCourse(): Course {
        return $this->course;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }   
    public function setDate(DateTime $date): void {
        $this->date = $date;
    }
    public function setStartTime(DateTime $start_time): void {
        $this->start_time = $start_time;
    }
    public function setEndTime(DateTime $end_time): void {
        $this->end_time = $end_time;
    }
    public function setParticipants(int $participants): void {
        $this->participants = $participants;
    }
    public function setTrainer(User $trainer): void {
        $this->trainer = $trainer;
    }
    public function setLocation(Location $location): void {
        $this->location = $location;
    }
    public function setCourse(Course $course): void {
        $this->course = $course;
    }



}


?>