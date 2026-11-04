<?php
namespace src\app\model;
use DateTime;

class Registration {
    private int $id;
    private User $user;
    private string $registration_state;
    private Course_Session $session;
    private  DateTime $cancelled_at;
    private String $cancellation_reason;

    function __construct(int $id, User $user, string $registration_state, Course_Session $session, DateTime $cancelled_at, String $cancellation_reason) {
        $this->id = $id;
        $this->user = $user;
        $this->registration_state = $registration_state;
        $this->session = $session;
        $this->cancelled_at = $cancelled_at;
        $this->cancellation_reason = $cancellation_reason;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'user' => $this->user->toArray(),
            'registration_state' => $this->registration_state,
            'session' => $this->session->toArray(),
            'cancelled_at' => $this->cancelled_at->format('Y-m-d'),
            'cancellation_reason' => $this->cancellation_reason
        ];
    }

    public function getId(): int {
        return $this->id;
    }
    public function getUser(): User {
        return $this->user;
    }
    public function getRegistrationState(): string {
        return $this->registration_state;
    }
    public function getSession(): Course_Session {
        return $this->session;
    }
    public function getCancelledAt(): DateTime {
        return $this->cancelled_at;
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
    public function setRegistrationState(string $registration_state): void {
        $this->registration_state = $registration_state;
    }   
    public function setSession(Course_Session $session): void {
        $this->session = $session;
    }
    public function setCancelledAt(DateTime $cancelled_at): void {
        $this->cancelled_at = $cancelled_at;
    }
    public function setCancellationReason(String $cancellation_reason): void {
        $this->cancellation_reason = $cancellation_reason;
    }

}

?>