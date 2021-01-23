<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'address_details' => $this->address_details,
            'street' => $this->street,
            'created_at' => $this->created_at,
            'region' => new RegionResource($this->region),
        ];
    }
}
