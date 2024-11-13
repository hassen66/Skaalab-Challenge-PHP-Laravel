<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     required={"id", "name", "price"},
 *     @OA\Property(property="id", type="integer", description="Product ID"),
 *     @OA\Property(property="name", type="string", description="Product name"),
 *     @OA\Property(property="price", type="number", format="float", description="Product price"),
 *     @OA\Property(property="stock", type="integer", description="Stock quantity of the product"),
 *     @OA\Property(property="categories", type="array", @OA\Items(ref="#/components/schemas/Category"), description="Categories associated with the product")
 * )
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'stock'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');    
    }
}