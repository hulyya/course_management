<?php
namespace src\app\model;

class User {
    private int $id;
    private bool $state;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $role;
    private Company $company;

    function __construct(int $id, bool $state, string $firstname, string $lastname, string $email, string $password, string $role, Company $company) {
        $this->id = $id;
        $this->state = $state;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->company = $company;
    }   

    public function toArray(): array {
        return [
            'id' => $this->id,
            'state' => $this->state,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'company' => $this->company->toArray()
        ];  
    }

    public function getId(): int {
        return $this->id;
    }
    public function getState(): bool {
        return $this->state;
    }
    public function getFirstname(): string {
        return $this->firstname;
    }
    public function getLastname(): string {
        return $this->lastname;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function getRole(): string {
        return $this->role;
    }
    public function getCompany(): Company {
        return $this->company;
    }
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setState(bool $state): void {
        $this->state = $state;
    }   
    public function setFirstname(string $firstname): void {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname): void {
        $this->lastname = $lastname;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setPassword(string $password): void {
        $this->password = $password;
    }   
    public function setRole(string $role): void {
        $this->role = $role;
    }
    public function setCompany(Company $company): void {
        $this->company = $company;
    }
    
}

?>