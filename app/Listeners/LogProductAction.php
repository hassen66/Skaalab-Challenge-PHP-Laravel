<?php

namespace App\Listeners;

use App\Events\ProductCreatedOrUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogProductAction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreatedOrUpdated $event): void
    {
        Log::info("Produit {$event->action} : {$event->product->name}");
    }
}
