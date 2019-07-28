<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addLocations(Request $request)
    {
        $rules = [
            '*.name' => 'required|string|unique:Locations,name',
            '*.lat' => 'required|numeric',
            '*.lng' => 'required|numeric'
        ];
        $data = $request->json()->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails())
        {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->failed()
            ]);
        }

        Location::insert($data);

        return response()->json([
            'message' => sprintf( 'Added: %s rows', count($data))
        ]);
    }

    public function getClosestPoint(Request $request)
    {
        $data = $request->json()->all();

        $rules = [
            'name' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ];
        $validator = Validator::make($data, $rules);

        if($validator->fails())
        {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->failed()
            ]);
        }

        $lat = $data['lat'];
        $lng = $data['lng'];
        $return = DB::table("locations")
            ->select("locations.name"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(locations.lat)) 
                    * cos(radians(locations.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(locations.lat))) AS distance"))
            ->orderBy('distance')

            ->first();

        return response()->json([
            'message' => $return->name
        ]);
    }

}
