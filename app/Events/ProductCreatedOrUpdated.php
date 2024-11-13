<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreatedOrUpdated
{
    use Dispatchable, SerializesModels;

    public $product;
    public $action;

    public function __construct(Product $product, string $action)
    {
        $this->product = $product;
        $this->action = $action;
    }
}