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
        $data = $request->validated();

        $data['name'] = [
            'ar' => $request->name_ar,
            'en' => $request->name_en,
        ];
        $data['description'] = [
            'ar' => $request->description_ar,
            'en' => $request->description_en,
        ];

        $product = $this->productService->handleStore($data);
        return response()->json(['message' => 'تم إضافة المنتج', 'data' => $product], 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Products::findOrFail($id);
        $data = $request->validated();

        if ($request->has('name_ar')) {
            $product->setTranslation('name', 'ar', $request->name_ar);
        }
        if ($request->has('name_en')) {
            $product->setTranslation('name', 'en', $request->name_en);
        }
        if ($request->has('description_ar')) {
            $product->setTranslation('description', 'ar', $request->description_ar);
        }
        if ($request->has('description_en')) {
            $product->setTranslation('description', 'en', $request->description_en);
        }


        unset($data['name_ar'], $data['name_en'], $data['description_ar'], $data['description_en']);

        $updatedProduct = $this->productService->handleUpdate($product, $data);

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
