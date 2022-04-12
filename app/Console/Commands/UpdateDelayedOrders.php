<?php

namespace App\Console\Commands;

use App\Models\DelayedOrders;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateDelayedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-delayed-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs through the orders table and checks for orders that are passed their ETD. Updates The delayed_orders table with new entries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get delayed orders
        $now = date('Y-m-d H:i:s');
        $delayedOrders = Order::where('status', '<>', 'DELIVERED')
            ->where('exptected_delivery_time', '<', $now)
            ->get();
        
        foreach ($delayedOrders as $key => $order) {
            // Check if order is still delayed
            $isStillDelayed = DelayedOrders::where(['order_id' => $order->id])->first();
            if($isStillDelayed){
                continue;
            }

            DelayedOrders::create([
                'order_id' => $order->id,
                'current_time' => $now,
                'exptected_delivery_time' => $order->exptected_delivery_time
            ]);
        }
        return 0;
    }
}
