<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupperController extends Controller
{

    protected  $validate;

    public function custom_validation($data, $condition)
    {
        $this->validate = Validator::make($data, $condition);
        if ($this->validate->fails()) {

            return response([
                'status' =>false ,
                'message' =>  implode('\r\n', $this->validate->errors()->all())
            ]);
        }
        return true;
    }



}
