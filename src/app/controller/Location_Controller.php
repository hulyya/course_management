<?php
namespace src\app\controller;

use src\app\model\Location;
use src\app\repository\Location_Repository;

class Location_Controller{
    /**
     * Summary of createLocation
     */
    public function createLocation(){
        $formData = [
            'name'      =>'',
            'street'    =>'',
            'city'      =>'',
            'room'      =>'',
            'capacity'  =>'',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name       =   trim($_POST['name']??'');
            $street     =   trim($_POST['street']??'');
            $city       =   trim($_POST['city']??'');
            $room       =   trim($_POST['room']??'');
            $capacity   =   trim($_POST['capacity']??'');

            $formData['name']       = $name;
            $formData['street']     = $street;
            $formData['city']       = $city;
            $formData['room']       = $room;
            $formData['capacity']   = $capacity;

            $location = new Location(0, true, $name, $street, $city, $room, $capacity);
            (new Location_Repository())->save($location);
            return $formData;
        }
        return $formData;
    }



    /**
     * Summary of editLocation
     */
    public function editLocation(){
        $formData = [
            'name'      =>'',
            'street'    =>'',
            'city'      =>'',
            'room'      =>'',
            'capacity'  =>'',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id         =   (int) ($_POST['edit_id']??'');
            $name       =   trim($_POST['name']??'');
            $street     =   trim($_POST['street']??'');
            $city       =   trim($_POST['city']??'');
            $room       =   trim($_POST['room']??'');
            $capacity   =   trim($_POST['capacity']??'');

            $formData['name']       = $name;
            $formData['street']     = $street;
            $formData['city']       = $city;
            $formData['room']       = $room;
            $formData['capacity']   = $capacity;

            $location = new Location($id, true, $name, $street, $city, $room, $capacity);
            (new Location_Repository())->update($location);
            return $formData;
        }
        return $formData;
    }



    /**
     * Summary of deleteLocation
     */
    public function deleteLocation(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
            return (new Location_Repository())->delete((int) $_POST['delete_id']);
        }
        return false;
    }




    /**
     * Summary of changeLocationState
     */
    public function changeLocationState(){

    }



    /**
     * Summary of listAllLocations
     */
    public function listAllLocations(){
        $locationRepositoryObj = (new Location_Repository())->load();
        $array = [];
        foreach ($locationRepositoryObj as $data){
            $array [] = $data->toArray();
        }
        return $array;
    }




}


?>