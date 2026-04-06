<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        return response()->json(Tags::all());
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tags::create($request->validated());
        return response()->json(['message' => 'تم إضافة الوسم', 'data' => $tag], 201);
    }

    public function show(Tags $tag)
    {
        return response()->json($tag);
    }

    public function update(UpdateTagRequest $request, Tags $tag)
    {
        $tag->update($request->validated());
        return response()->json(['message' => 'تم التحديث', 'data' => $tag]);
    }

    public function destroy(Tags $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'تم حذف الوسم']);
    }
}
