<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\TagsController;

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('sub-categories', SubCategoriesController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('tags', TagsController::class);

