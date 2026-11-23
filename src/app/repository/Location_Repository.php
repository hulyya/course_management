<?php
namespace src\app\repository;
use src\app\model\Location;
use src\app\core\DB;
class Location_Repository {
    private DB $db;
    function __construct() {
        $this->db = new DB();
    }



    /**
     * Summary of save
     * @param mixed $location
     * saves a location to the database
     */
    public function save(Location $location){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "INSERT INTO locations  
                                (name, 
                                street, 
                                city, 
                                room, 
                                capacity) 
                                VALUES 
                                :name, 
                                :street, 
                                :city, 
                                :room, 
                                :capacity)"
                                );

        return $stmt->execute([
            ':name'     => $location->getName(),
            ':street'   => $location->getStreet(),
            ':city'     => $location->getCity(),
            ':room'     => $location->getRoom(),
            ':capacity' => $location->getCapacity()
        ]);
    }



    /**
     * Summary of load
     * loads all locations from the database
     * returns an array of Location objects
     */
    public function load(): array {
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT 
                                id,     
                                name, 
                                street, 
                                city, 
                                room, 
                                capacity 
                                FROM locations"
                                );

        $stmt->execute();
        $locations = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $locations[] = new Location(
                $data['id'], 
                $data['state'],
                $data['name'], 
                $data['street'], 
                $data['city'], 
                $data['room'], 
                $data['capacity']
            );
        }
        return $locations;
    }



    /**
     * Summary of delete()
     * deletes a location from the database
     * @param int $id
     */
    public function delete(int $id): bool {
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "DELETE FROM locations 
                                WHERE id = :id"
                                );
        return $stmt->execute([
            ':id' => $id
        ]);
    }



    /**
     * Summary of update()
     * updates a location in the database
     * @param Location $location
     *
     */
    public function update(Location $location): bool {
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "UPDATE locations 
                                SET 
                                name = :name, 
                                street = :street, 
                                city = :city, 
                                room = :room, 
                                capacity = :capacity 
                                WHERE id = :id"
                                );

        return $stmt->execute([
            ':id'       => $location->getId(),
            ':name'     => $location->getName(),
            ':street'   => $location->getStreet(),
            ':city'     => $location->getCity(),
            ':room'     => $location->getRoom(),
            ':capacity' => $location->getCapacity()
        ]);
    }



    /**
     * Summary of changeState()
     * changes the state of a location in the database
     * @param Location $location
     */
    public function changeState(Location $location): bool {
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "UPDATE locations 
                                SET state = :state 
                                WHERE id = :id"
                                );
        return $stmt->execute([
            ':id'       => $location->getId(),
            ':state'    => $location->getState()
        ]);
    }



    /**
     * Summary of getAllLocations
     * 
     */
    public function getAllLocations():array{
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT 
                                locations.id,
                                locations.name,
                                locations.room,
                                locations.street,
                                locations.city,
                                locations.capacity
                                FROM locations"
                                );

        $stmt ->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    
    /***
     * Summary of getLocationbyId
     * gets the location by id
     */
    public function getLocationById(int $id){
        $pdo    = $this->db->getConnection();
        $stmt   = $pdo->prepare(
                                "SELECT 
                                id, 
                                state, 
                                name, 
                                street, 
                                city, 
                                room, 
                                capacity
                                FROM locations
                                WHERE id = :id"
                                );

        $stmt -> execute([
            ':id'=>$id
        ]);
        $data = $stmt ->fetch(\PDO::FETCH_ASSOC);
        if($data){
            return new Location(
                $data['id'],
                $data['state'],
                $data['name'],
                $data['street'],
                $data['city'],
                $data['room'],
                $data['capacity']
            );
        }
        return null;
    }
}
?>