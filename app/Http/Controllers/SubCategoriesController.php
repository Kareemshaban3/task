<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\SubCategories;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $subCategories = SubCategories::with('categories')->get();
        return response()->json($subCategories);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategories::create($request->validated());

        $subCategory->categories()->sync($request->category_ids);

        return response()->json([
            'message' => 'تمت الإضافة بنجاح',
            'data' => $subCategory->load('categories')
        ], 201);
    }

    public function show(SubCategories $subCategory)
    {
        return response()->json($subCategory->load('categories'));
    }

    public function update(UpdateSubCategoryRequest $request, SubCategories $subCategory)
    {
        $subCategory->update($request->validated());

        $subCategory->categories()->sync($request->category_ids);

        return response()->json([
            'message' => 'تم التحديث بنجاح',
            'data' => $subCategory->load('categories')
        ]);
    }

    public function destroy(SubCategories $subCategory)
    {
        $subCategory->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
