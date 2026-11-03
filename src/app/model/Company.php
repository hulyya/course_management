<?php
namespace src\app\model;

class Company {
    private int $id;
    private bool $state;
    private string $name;
    private string $contact_person;
    private string $contact_email;

    function __construct(int $id, bool $state, string $name, string $contact_person, string $contact_email){
        $this->id = $id;
        $this->state = $state;
        $this->name = $name;
        $this->contact_person = $contact_person;
        $this->contact_email = $contact_email;
    }

    public function toArray(): array {
        return[
            'id' => $this->id,
            'state' => $this->state,
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'contact_email' => $this->contact_email
        ];
    }

    public function getId(): int {
        return $this->id;
    }
    public function getState(): bool {
        return $this->state;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getContactPerson(): string {
        return $this->contact_person;
    }
    public function getContactEmail(): string {
        return $this->contact_email;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setState(bool $state): void {
        $this->state = $state;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function setContactPerson(string $contact_person): void {
        $this->contact_person = $contact_person;
    }
    public function setContactEmail(string $contact_email): void {
        $this->contact_email = $contact_email;
    }

}
?>