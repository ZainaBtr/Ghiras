<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealStoreRequest;
use App\Http\Requests\MealUpdateRequest;
use App\Models\Category;
use App\Models\component_in_meal;
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
        $meals=Meal::query()->get()->all();

        $meals_data = collect([]);

        foreach ($meals as $meal)
        {
            $category_id = $meal['category_id'];

            $category = Category::Where('id', $category_id)->first();

            $category_name = $category->category_name;

            $mealsArray = [
                'meal_name' => $meal['meal_name'],
                'meal_type' => $meal['meal_type'],
                'meal_price' =>$meal['meal_price'],
                'meal_price_show' => $meal['meal_price_show'],
                'meal_picture' => $meal['meal_picture'],
                'meal_description' => $meal['meal_description'],
                'meal_In_menu' => $meal['meal_In_menu']
            ];
            $data  = array_merge($mealsArray, [
                'category_name' => $category_name
            ]);

            $meals_data->push($data) ;
        }

        return response()->json($meals_data,Response::HTTP_OK);
    }

    public function showComponents(Meal $meal)
    {
        $components = $meal->components->map(function ($component) {
            return [
                'component_name' => $component->component_name,
                'component_in_meal_quantity' => $component->pivot->component_in_meal_quantity,
                'component_in_meal_unit_of_measurement' => $component->pivot->component_in_meal_unit_of_measurement,
            ];
        });

        return response()->json([
            'meal_name' => $meal->meal_name,
            'components' => $components,
        ], Response::HTTP_OK);
    }




    public function menu()
    {
        $name = collect([]);

        $meals_in_menu = Meal::Where('meal_In_menu' , true)->get();

        foreach ($meals_in_menu as $meal_in_menu)
        {
            $name->push($meal_in_menu->meal_name) ;
        }

        return response()->json($name,Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MealStoreRequest $request)
    {
        $validated = $request->validated();

        $category_name = $validated['category_name'];

        $category_id = Category::where('category_name',$category_name)->first();

        $meal=Meal::create([
            'meal_name' => $validated['meal_name'],
            'category_id' => $category_id->id,
            'meal_type' => $validated['meal_type'],
            'meal_price_show' => $validated['meal_price_show'],
            'meal_picture' => $validated['meal_picture'],
            'meal_description' => $validated['meal_description'],
            'meal_In_menu' => $validated['meal_In_menu'] ?? 0
        ]);

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\JsonResponse|Response
     */


    public function update(MealUpdateRequest $request, Meal $meal)
    {
        $validated = $request->validated();

        //if(isset($validated['category_name'])) شغالين
        if($request->has('category_name'))
        {

            $category_name = $validated['category_name'];

            $category_id = Category::where('category_name', $category_name)->first();

            $data = array_merge($validated, [
                'category_id' => $category_id->id,
            ]);
        }
        else
            $data = $validated;

        $meal->update($data);

        // إرجاع الوجبة المحدثة كإجابة JSON
        return response()->json($meal,Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Meal $meal )
    {
        $meal->delete();

        return response()->json(['message' => ' meal deleted successfully']);
    }

    public function findMeal(Request $request)
    {
        $meal_name = $request->meal_name;
        $meal = Meal::where('meal_name', $meal_name)->first();
        if($meal){
            return response()->json($meal, 200);
        } else {
            return response()->json(['message' => 'meal not found'], 404);
        }
    }

}
