<?php
namespace src\app\model;

class Location {
    private int $id;
    private bool $state;
    private string $name;
    private string $street;
    private string $city;
    private string $room;
    private int $capacity;

    function __construct(int $id, bool $state, string $name, string $street, string $city, string $room, int $capacity) {
        $this->id = $id;
        $this->state = $state;
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->room = $room;
        $this->capacity = $capacity;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'state' => $this->state,
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'room' => $this->room,
            'capacity' => $this->capacity
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
    public function getStreet(): string {
        return $this->street;
    }
    public function getCity(): string {
        return $this->city;
    }
    public function getRoom(): string {
        return $this->room;
    }
    public function getCapacity(): int {
        return $this->capacity;
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
    public function setStreet(string $street): void {
        $this->street = $street;
    }
    public function setCity(string $city): void {
        $this->city = $city;
    }
    public function setRoom(string $room): void {
        $this->room = $room;
    }
    public function setCapacity(int $capacity): void {
        $this->capacity = $capacity;
    }

}

?>