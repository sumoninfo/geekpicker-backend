<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MostConversionUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'currency'     => $this->currency,
            'total_amount' => $this->total_amount,
        ];
    }
}
