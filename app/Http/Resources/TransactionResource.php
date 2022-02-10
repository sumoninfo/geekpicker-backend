<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'date'          => $this->date,
            'to_user'       => new DropdownResource($this->toUser),
            'from_currency' => $this->from_currency,
            'to_currency'   => $this->to_currency,
            'from_amount'   => $this->from_amount,
            'to_amount'     => $this->to_amount,
        ];
    }
}
