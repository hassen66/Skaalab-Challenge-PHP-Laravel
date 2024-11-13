<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Product;
use App\Notifications\LowStockNotification;

class SendLowStockNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = Product::where('stock', '<', 10)->get();

        foreach ($products as $product) {
            $admin = User::where('is_admin',true)->first();
            if ($admin) {
                $admin->notify(new LowStockNotification($product));
            }
        }
    }
}
