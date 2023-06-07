<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $meal=Meal::query()->get()->all();

        return response()->json($meal,Response::HTTP_OK);

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
            'meal_name' => ['required'],
            'category_id' => ['required'],
            'meal_type' => ['required'],
            'meal_ready_quantity' => ['required'],
            'meal_picture' => ['required'],
            'meal_description' => ['required'],
            //'meal_In_menu' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
            // HTTP_UNPROCESSABLE_ENTITY = 422  *  يعني غلط بالداتا المدخلة  *
        }

        $meal_name=$request->meal_name;
        $category_id=$request->category_id;
        $meal_type=$request->meal_type;
        $meal_ready_quantity=$request->meal_ready_quantity;
        $meal_picture=$request->meal_picture;
        $meal_description=$request->meal_description;
        $meal_In_menu=$request->meal_In_menu;


        $meal=Meal::query()->create([
            'meal_name'=>$meal_name,
            'category_id'=>$category_id,
            'meal_type'=>$meal_type,
            'meal_ready_quantity'=>$meal_ready_quantity,
            'meal_picture'=>$meal_picture,
            'meal_description'=>$meal_description,
            'meal_In_menu'=>$meal_In_menu,
        ]);
        $meal->save();
        return response()->json($meal,Response::HTTP_CREATED);
        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
        dd("18");

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request)
//    {
//        //
////        if (Auth::id()!=$meal->user_id){
////            throw new AccessDeniedHttpException();
////        }
//        //dd("zero");
//
//        $id=$request->id;
//        $meal_name=$request->meal_name;
//        $category_id=$request->category_id;
//        $meal_type=$request->meal_type;
//        $meal_ready_quantity=$request->meal_ready_quantity;
//        $meal_picture=$request->meal_picture;
//        $meal_description=$request->meal_description;
//        $meal_In_menu=$request->meal_In_menu;
//
//        //dd("one");
//        $meal=Meal::query()->find($id)->update([
//            'meal_name'=>$meal_name,
//            'category_id'=>$category_id,
//            'meal_type'=>$meal_type,
//            'meal_ready_quantity'=>$meal_ready_quantity,
//            'meal_picture'=>$meal_picture,
//            'meal_description'=>$meal_description,
//            'meal_In_menu'=>$meal_In_menu,
//        ]);
//       // dd("two");
//        $meal->save();
//        return response()->json($meal,Response::HTTP_CREATED);
//        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *
//
//    }


//    public function update(Request $request, $id)
//    {
//        // استرداد الوجبة التي سيتم تحديثها
//        $meal = Meal::findOrFail($id);
//
//        // تحديث الحقول المطلوبة
//        $meal->meal_name = $request->input('meal_name');
//        $meal->category_id = $request->input('category_id');
//        $meal->meal_type = $request->input('meal_type');
//        $meal->meal_ready_quantity = $request->input('meal_ready_quantity');
//        $meal->meal_picture = $request->input('meal_picture');
//        $meal->meal_description = $request->input('meal_description');
//        $meal->meal_In_menu = $request->input('meal_In_menu');
//
//        // حفظ التحديثات في قاعدة البيانات
//        $meal->save();
//
//        // إرجاع الوجبة المحدثة كإجابة JSON
//        return response()->json($meal);
//    }

//    public function update(Request $request)
//    {
//        $id = $request->id;
//
//        // التحقق من وجود الوجبة قبل تحديثها
//        $meal = Meal::findOrFail($id);
//
//        // التحقق من وجود القيم المطلوبة
//        if ($request->filled('meal_name')) {
//            $meal->meal_name = $request->meal_name;
//        }
//
//        if ($request->filled('category_id')) {
//            $meal->category_id = $request->category_id;
//        }
//
//        if ($request->filled('meal_type')) {
//            $meal->meal_type = $request->meal_type;
//        }
//
//        if ($request->filled('meal_ready_quantity')) {
//            $meal->meal_ready_quantity = $request->meal_ready_quantity;
//        }
//
//        if ($request->filled('meal_picture')) {
//            $meal->meal_picture = $request->meal_picture;
//        }
//
//        if ($request->filled('meal_description')) {
//            $meal->meal_description = $request->meal_description;
//        }
//
//        if ($request->filled('meal_In_menu')) {
//            $meal->meal_In_menu = $request->meal_In_menu;
//        }
//
//        // حفظ التحديثات في قاعدة البيانات
//        $meal->save();
//
//        return response()->json($meal, Response::HTTP_CREATED);
//    }
    public function update(Request $request, $id)
    {
        // استرداد الوجبة التي سيتم تحديثها
        $meal = Meal::findOrFail($id);

        // تحديث الحقول المطلوبة فقط
        if ($request->has('meal_name')) {
            $meal->meal_name = $request->input('meal_name');
        }
        if ($request->has('category_id')) {
            $meal->category_id = $request->input('category_id');
        }
        if ($request->has('meal_type')) {
            $meal->meal_type = $request->input('meal_type');
        }
        if ($request->has('meal_ready_quantity')) {
            $meal->meal_ready_quantity = $request->input('meal_ready_quantity');
        }
        if ($request->has('meal_picture')) {
            $meal->meal_picture = $request->input('meal_picture');
        }
        if ($request->has('meal_description')) {
            $meal->meal_description = $request->input('meal_description');
        }
        if ($request->has('meal_In_menu')) {
            $meal->meal_In_menu = $request->input('meal_In_menu');
        }

        // حفظ التحديثات في قاعدة البيانات
        $meal->save();

        // إرجاع الوجبة المحدثة كإجابة JSON
        return response()->json($meal,Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        dd("20");

    }
}
