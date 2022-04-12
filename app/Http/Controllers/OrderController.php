<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Http\Resources\OrdersResource;
use App\Models\OrderItems;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource. All, by order status
     *
     * @param  \App\Http\Requests\OrderStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(OrderStatusRequest $request)
    {
        if(isset($request->order_status)){
            return OrdersResource::collection(Order::with('items')->where(['status' => $request->order_status])->get());
        }
        return OrdersResource::collection(Order::with('items')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'exptected_delivery_time' => $request->exptected_delivery_time,
            'delivery_address' => $request->delivery_address,
            'billing_address' => $request->billing_address,
            'status' => ($request->status) ? $request->status : 'PENDING'
        ]);
        
        if(isset($request->items) && count($request->items) > 0){
            foreach ($request->items as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity']
                ]);
            }
        }

        $order = Order::with('items')->find($order->id);

        return new OrdersResource($order);
    }

    /**
     * Display the specified resource. By Order ID
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrdersResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update([
            'status' => $request->input('order_status')
        ]);

        return new OrdersResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        OrderItems::where(['order_id' => $order->id])->delete();
        return response(null, 204);
    }

}
