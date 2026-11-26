<?php
namespace src\app\controller;

use Symfony\Component\HttpFoundation\Request;
use src\app\model\Location;
use src\app\repository\LocationRepository;

class LocationController{

    /**
     * Summary of adminLocationSite
     */
    public function adminLocatonSite(){

    }


    /**
     * Summary of createLocation
     */
    public function createLocation(Request $request){
            $name       =   trim($request->request->get('name'));
            $street     =   trim($request->request->get('street'));
            $city       =   trim($request->request->get('city'));
            $room       =   trim($request->request->get('room'));
            $capacity   =   trim($request->request->get('capacity'));

            $location = new Location(0, true, $name, $street, $city, $room, $capacity);
            return (new LocationRepository())->save($location);
    }

    /**
     * Summary of editLocation
     */
    public function editLocation(Request $request){
            $id         =   (int) ($request->request->get('id'));
            $name       =   trim($request->request->get('name'));
            $street     =   trim($request->request->get('street'));
            $city       =   trim($request->request->get('city'));
            $room       =   trim($request->request->get('room'));
            $capacity   =   trim($request->request->get('capacity'));

            $location = new Location($id, true, $name, $street, $city, $room, $capacity);
            return (new LocationRepository())->update($location);
    }

    /**
     * Summary of deleteLocation
     */
    public function deleteLocation(Request $request){
            return (new LocationRepository())->delete((int) ($request->request->get('delete_id')));
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
        $locationList = (new LocationRepository())->load();
        return $locationList;
    }
}
?>