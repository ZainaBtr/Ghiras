<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category_storeRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $category_name=Category::query()->get()->all();

        return response()->json($category_name,Response::HTTP_OK);
        // HTTP_OK = 200  *    *
    }

    public function get_meals_in(Request $request)
    {
        $category_name = $request->category_name;
        $category = Category::where('category_name', $category_name)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $meals_in_category = Meal::where('category_id', $category->id)
            ->get(['meal_name','meal_picture']) // استرجاع اسم الوجبة والصورة فقط
            ->toArray();

        return response()->json($meals_in_category, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $validated = $request->validated();

        $category_name=Category::create($validated);

        return response()->json($category_name,Response::HTTP_CREATED);
        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'category deleted successfully']);
    }
}
