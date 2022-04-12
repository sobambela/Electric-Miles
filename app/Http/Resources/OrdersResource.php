<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'Order',
            'attributes' => [
                'customer_id' => (string)$this->customer_id,
                'exptected_delivery_time' => $this->exptected_delivery_time,
                'delivery_address' => $this->delivery_address,
                'billing_address' => $this->billing_address,
                'status' => $this->status,
                'items' => $this->items,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}
