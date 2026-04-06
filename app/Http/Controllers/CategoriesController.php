<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return response()->json(Categories::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Categories::create($request->validated());
        return response()->json(['message' => 'تم الحفظ', 'data' => $category], 201);
    }
    public function show(Categories $category)
    {
        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, Categories $category)
    {
        $category->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث القسم بنجاح',
            'data' => $category
        ]);
    }

    public function destroy(Categories $category)
    {
        $category->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
