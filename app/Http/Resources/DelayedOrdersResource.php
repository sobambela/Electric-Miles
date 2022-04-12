<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DelayedOrdersResource extends JsonResource
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
      'type' => 'Delayed Order',
      'attributes' => [
        'order_id' => (string)$this->order_id,
        'current_time' => $this->current_time,
        'exptected_delivery_time' => $this->exptected_delivery_time,
        'order' => [
          'customer_id' => (string)$this->order->customer_id,
          'exptected_delivery_time' => $this->order->exptected_delivery_time,
          'delivery_address' => $this->order->delivery_address,
          'billing_address' => $this->order->billing_address,
          'status' => $this->order->status
        ],
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
      ]
    ];
  }
}
