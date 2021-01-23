<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends SupperController
{

    function getAddresses()
    {
        $data = Address::where('user_id', auth()->id())->latest()->get();
        return response(['status' => true, 'addresses' => AddressResource::collection($data)]);
    }

    function showAddress($address_id)
    {
        $address = Address::where('user_id', auth()->id())->find($address_id);
        if (!$address)
            return response(['status' => false, 'message' => __('api.not_found_item')]);

        return response(['status' => true, 'addresses' => new  AddressResource($address)]);
    }


    function createAddress(Request $request)
    {
        $response = $this->custom_validation($request->all(), [
            'mobile' => 'required|string',
            'email' => 'required|string|email|max:191',
            'address_details' => 'required|string',
            'street' => 'nullable|string',
            'region_id' => 'required|numeric|exists:regions,id',
        ]);
        if ($response !== true)
            return $response;
        $data = $this->validate->validated();
        $data['user_id'] = auth()->id();
        $address = Address::create($data);
        return response(['status' => true, 'address' => new  AddressResource($address), 'message' => __('api.operation_successfully')]);
    }

    function updateAddress(Request $request, $address_id)
    {
        $address = Address::where('user_id', auth()->id())->find($address_id);
        if (!$address)
            return response(['status' => false, 'message' => __('api.not_found_item')]);

        $response = $this->custom_validation($request->all(), [
            'mobile' => 'required|string',
            'email' => 'required|string|email|max:191',
            'address_details' => 'required|string',
            'street' => 'nullable|string',
            'region_id' => 'required|numeric|exists:regions,id',
        ]);
        if ($response !== true)
            return $response;
        $data = $this->validate->validated();
        $address->update($data);
        return response(['status' => true, 'address' => new  AddressResource($address), 'message' => __('api.operation_successfully')]);
    }

}
