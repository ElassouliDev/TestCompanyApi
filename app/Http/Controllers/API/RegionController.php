<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;


class RegionController extends SupperController
{

    function getRegions(Request $request)
    {
        $regions = Region::latest()->get();
        return response(['status' => true, 'regions' => RegionResource::collection($regions)]);


    }
}


