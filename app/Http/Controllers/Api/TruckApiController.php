<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TruckType;
use Illuminate\Http\Request;

class TruckApiController extends Controller
{
    public function getTruckTypeList() {
        $truck_types = TruckType::with('truck_type_details')->get();

        $data['status'] = 1;
        $data['data'] = $truck_types;
        return response()->json($data, 200);
    }
}
