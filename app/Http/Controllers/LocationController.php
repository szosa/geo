<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
}
