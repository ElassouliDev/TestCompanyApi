<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends SupperController
{

    function login(Request $request)
    {
        $response = $this->custom_validation($request->all(), [
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:6'
        ]);

        if ($response !== true) // if  failed  auth
            return $response;

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $token = $user->createToken('customer_token');

            return response(['status' => true, 'user' => new UserResource($user), 'token' => $token->plainTextToken]);


        }


        return response(['status' => false, 'message' => __('api.failed_login')]);


    }

    function register(Request $request)
    {

        $response = $this->custom_validation($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:191|unique:users',
            'mobile' => 'nullable|string|max:100',
            'region_id' => 'nullable|numeric|exists:regions,id',
            'password' => 'required|string|min:6'
        ]);
        if ($response !== true)
            return $response;


        $data = $request->only('email', 'name', 'password','mobile','region_id');
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);


        $token = $user->createToken('customer');

        $user->token = $token->plainTextToken;
        return response([
            'status' => true,
            'user' => new UserResource($user),
            'token' => $user->token,
            'message' => __('api.create_user_success')
        ]);


    }

    function getUserInfo(Request $request)
    {
        return response([
            'status' => true,
            'user' => new UserResource(\auth()->user())

        ]);


    }


    function updateUserInfo(Request $request)
    {

        $response = $this->custom_validation($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:191|unique:users,email,'.\auth()->id(),
            'mobile' => 'nullable|string|max:100',
            'region_id' => 'nullable|numeric|exists:regions,id',
        ]);
        if ($response !== true)
            return $response;


        $data = $request->only('email', 'name', 'password','mobile','region_id');
        \auth()->user()->update($data);


        return response([
            'status' => true,
            'user' => new UserResource( \auth()->user()),
        ]);


    }

}
