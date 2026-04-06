<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Products;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller

{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json(Products::with(['subCategories', 'tags', 'images'])->get());
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->handleStore($request->validated());
        return response()->json(['message' => 'تم إضافة المنتج', 'data' => $product], 201);
    }

    public function show(Products $product)
    {
        return response()->json($product->load(['subCategories', 'tags', 'images']));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Products::findOrFail($id);

        $updatedProduct = $this->productService->handleUpdate($product, $request->all());

        $updatedProduct->load(['subCategories', 'tags', 'images']);

        return response()->json([
            'status' => true,
            'message' => 'تم التحديث بنجاح',
            'data' => $updatedProduct
        ]);
    }

    public function destroy(Products $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $product->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}
