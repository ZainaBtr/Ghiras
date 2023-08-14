<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category_storeRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//$path="C:\xampp\htdocs\MyProjects\market\json\products_list.json";
//$json=json_decode(file_get_contents($path),true);

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
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */


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
