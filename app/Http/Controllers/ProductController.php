<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $products = Product::query();

            if ($request->has('search')) {
                $search = $request->search;

                $products->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhere('price', 'like', "%{$search}%");
                });
            }

            return response()->json([
                'success' => true,
                'products' => $products->paginate(10)
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب المنتجات',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                'success' => true,
                'product' => $product
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ غير متوقع',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المنتج بنجاح',
                'product' => $product
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في إضافة المنتج',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم تعديل المنتج بنجاح',
                'product' => $product
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تعديل المنتج',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج بنجاح'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف المنتج',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
