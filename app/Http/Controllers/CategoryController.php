<?php

namespace App\Http\Controllers;

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
        // HTTP_OK = 200  *  يعني الأمور تحت السيطرة  *
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
            // HTTP_UNPROCESSABLE_ENTITY = 422  *  يعني غلط بالداتا المدخلة  *
        }

        $category_name=$request->category_name;

        $category_name=Category::query()->create([
            'category_name'=>$category_name
        ]);

        return response()->json($category_name,Response::HTTP_CREATED);
        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    //خليه  بفيدك بتابع البحث
    public function show(Request $request)
    {
        $id=$request->id;
        $category=Category::query()->find($id);
        return response()->json($category,Response::HTTP_OK);
        // HTTP_OK = 200  *  يعني الأمور تحت السيطرة  *
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
            // HTTP_UNPROCESSABLE_ENTITY = 422  *  يعني غلط بالداتا المدخلة  *
        }

        $id=$request->id;
        $category_name=$request->category_name;

        $category=Category::query()->find($id)->update([
            'category_name'=>$category_name
        ]);

        return response()->json($category,Response::HTTP_OK);
        // HTTP_OK = 200  *  يعني الأمور تحت السيطرة  *
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,Category $category)
    {
        $id=$request->id;

//         $category_name=$request->category_name;
//        Category::query()->find($category_name)->delete();

        $category->find($id)->delete();
        //  $category->find($category_name)->delete();
        return response()->json($category,Response::HTTP_NO_CONTENT);
        // HTTP_NO_CONTENT = 204  *  يعني تم بس مافي داتا راجعة  *


//        $categoryName = $request->category_name;
//        Category::where('category_name', $categoryName)->delete();
//        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

//    public function deleteByName(Request $request): \Illuminate\Http\JsonResponse
//    {
//        $category_name = $request->input('category_name');
//        $category_name->delete();
//       // Category::where('category_name', $category_name)->delete();
//        return response()->json(['message' => 'Category deleted successfully']);
//    }


//    use Illuminate\Http\Request;
//    use App\Models\Category;
//
//    public function deleteCategory(Request $request)
//    {
//        $category_name = $request->input('category_name');
//        $category = Category::where('category_name', $category_name)->first();
//        if ($category) {
//            Category::where('id', $category->id)->delete();
//            return response()->json(['message' => 'Category deleted successfully']);
//        } else {
//            return response()->json(['message' => 'Category not found'], 404);
//        }
//    }
}
