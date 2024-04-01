<?php

namespace App\Http\Util;


use App\Models\Location;

class LocationHandler
{

   public function handle($location_id,$location_name,$longitude,$latitude,$radius): String
    {
        if (!$location_id.isEmptyOrNullString()) {
            $location = new Location();
            $location->name = $location_name;
            $location->longitude = $longitude;
            $location->latitude = $latitude;
            $location->radius = $radius;
            $location->save();

        } else {
            $location = Location::where('location_id',$location_id)->first();
        }
        return $location->location_id;
    }
}
