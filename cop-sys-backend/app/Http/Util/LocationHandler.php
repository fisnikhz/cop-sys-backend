<?php

namespace App\Http\Util;


use App\Models\Location;
use function PHPUnit\Framework\isNull;

class LocationHandler
{

   public function handle($location_id,$location_name,$longitude,$latitude,$radius): String
    {
        if (is_null($location_id)) {
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
