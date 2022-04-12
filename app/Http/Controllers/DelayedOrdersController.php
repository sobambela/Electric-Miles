<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DelayedOrders;
use App\Http\Requests\DelayedOrdersRequest;
use App\Http\Resources\DelayedOrdersResource;

class DelayedOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\DelayedOrdersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(DelayedOrdersRequest $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if($startDate && $endDate){
            $delayedOrders = DelayedOrders::with('order')
                ->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $startDate))
                ->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $endDate))
                ->get();

            return DelayedOrdersResource::collection($delayedOrders);
        }else if($startDate){

            $delayedOrders = DelayedOrders::with('order')
                ->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $startDate))
                ->get();

                return DelayedOrdersResource::collection($delayedOrders);
        }else if($endDate){
            
            $delayedOrders = DelayedOrders::with('order')
                ->where('created_at', '<=',  Carbon::createFromFormat('Y-m-d', $endDate))
                ->get();

            return DelayedOrdersResource::collection($delayedOrders);
        }

        return DelayedOrdersResource::collection(DelayedOrders::with('order')->get());
    }
}
