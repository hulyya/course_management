<?php
namespace src\app\model;
use DateTime;

class Registration {
    private int $id;
    private User $user;
    private DateTime $registration_date;
    private string $registration_state;
    private Course_Session $session;
    private String $cancellation_reason;

    function __construct(int $id, User $user, DateTime $registration_date, string $registration_state, Course_Session $session, String $cancellation_reason) {
        $this->id = $id;
        $this->user = $user;
        $this->registration_date = $registration_date;
        $this->registration_state = $registration_state;
        $this->session = $session;
        $this->cancellation_reason = $cancellation_reason;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'user' => $this->user->toArray(),
            'registration_date' => $this->registration_date->format('Y-m-d'),
            'registration_state' => $this->registration_state,
            'session' => $this->session->toArray(),
            'cancellation_reason' => $this->cancellation_reason
        ];
    }

    public function getId(): int {
        return $this->id;
    }
    public function getUser(): User {
        return $this->user;
    }
    public function getRegistrationDate(): DateTime {
        return $this->registration_date;
    }
    public function getRegistrationState(): string {
        return $this->registration_state;
    }
    public function getSession(): Course_Session {
        return $this->session;
    }
    public function getCancellationReason(): String {
        return $this->cancellation_reason;
    }
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setUser(User $user): void {
        $this->user = $user;
    }
    public function setRegistrationDate(DateTime $registration_date): void {
        $this->registration_date = $registration_date;
    }
    public function setRegistrationState(string $registration_state): void {
        $this->registration_state = $registration_state;
    }   
    public function setSession(Course_Session $session): void {
        $this->session = $session;
    }
    public function setCancellationReason(String $cancellation_reason): void {
        $this->cancellation_reason = $cancellation_reason;
    }

}

?>