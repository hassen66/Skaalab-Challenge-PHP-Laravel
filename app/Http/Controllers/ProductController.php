<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Events\ProductCreatedOrUpdated;
use Validator;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="List of products",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(10);

        return response()->json([
            'statusCode' => 200,
            'data' => [
                $products
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock"},
     *             @OA\Property(property="name", type="string", description="Product name"),
     *             @OA\Property(property="price", type="number", format="float", description="Product price"),
     *             @OA\Property(property="stock", type="integer", description="Product stock quantity"),
     *             @OA\Property(property="categories", type="array", items=@OA\Items(type="integer"), description="Category IDs")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'data' => $validator->errors(),
            ], 422);
        }

        $product = Product::create($request->all());
        if ($request->has('categories')) {
            $product->categories()->attach($request->input('categories'));
        }

        event(new ProductCreatedOrUpdated($product, 'créé'));

        return response()->json([
            'statusCode' => 201,
            'data' => [
                $product->load('categories')
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a specific product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product details",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function show($id)
    {
        return Product::with('categories')->findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock"},
     *             @OA\Property(property="name", type="string", description="Product name"),
     *             @OA\Property(property="price", type="number", format="float", description="Product price"),
     *             @OA\Property(property="stock", type="integer", description="Product stock quantity"),
     *             @OA\Property(property="categories", type="array", items=@OA\Items(type="integer"), description="Category IDs")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'data' => $validator->errors(),
            ], 422);
        }

        $product->update($request->all());
        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        event(new ProductCreatedOrUpdated($product, 'mis à jour'));

        return response()->json([
            'statusCode' => 200,
            'data' => [
                $product->load('categories')
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'statusCode' => 204,
            'message' => 'Delete successfully'
        ], 204);
    }
}