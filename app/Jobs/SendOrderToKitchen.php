<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderToKitchen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->order->update(['status' => 'In-Progress']);

            // can implement realtime notifications in the future
            logger()->info("Order #{$this->order->id} sent to the kitchen.");
        } catch (\Exception $e) {
            logger()->error("Failed to send order #{$this->order->id} to the kitchen. Error: {$e->getMessage()}");
        }
    }
}
