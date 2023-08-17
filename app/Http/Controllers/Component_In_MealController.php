<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentInMealStoreRequest;
use App\Http\Requests\ComponentInMealUpdateRequest;
use App\Models\Component;
use App\Models\Component_in_meal;
use App\Models\Meal;
use http\Message;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Component_In_MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    #[NoReturn] public function index()
    {
        $component_in_meal = Component_in_meal::query()->get()->all();

        return response()->json($component_in_meal, Response::HTTP_OK);

    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
         */


    public function store(ComponentInMealStoreRequest $request, Meal $meal)
    {
        try{
        $validated = $request->validated();


        $component_names = $validated['component_name'];

        $component_id = Component::where('component_name',$component_names)->first();

        $component_in_meal=Component_in_meal::create([
            'meal_id' => $meal->id,
            'component_id' => $component_id->id,
            'component_in_meal_quantity' => $validated['component_in_meal_quantity'],
            'component_in_meal_unit_of_measurement' => $validated['component_in_meal_unit_of_measurement'],
        ]);

////////// price///

          $meal_row = Meal::Where('id',$meal->id)->first();
        $component_row =  Component::Where('component_name',$validated['component_name'])->first();
        if ($component_row->component_unit_of_measurement != $validated['component_in_meal_unit_of_measurement']) {
            $quantity = Component_in_meal::convert( $validated['component_in_meal_quantity'], $validated['component_in_meal_unit_of_measurement'], $component_row->component_unit_of_measurement);
            $price= $component_row->component_price*$quantity;
         //   $price = (new \App\Models\Component_in_meal)->conversion($component_in_meal);
            $meal_row->update(['meal_price' => $meal_row->meal_price + $price]);
            return response()->json($component_in_meal,Response::HTTP_CREATED);


        }
        elseif($component_row->component_unit_of_measurement = $validated['component_in_meal_unit_of_measurement']){
            $price= $component_row->component_price*$validated['component_in_meal_quantity'];
            $meal_row->update(['meal_price' => $meal_row->meal_price + $price]);
            return response()->json($component_in_meal,Response::HTTP_CREATED);

        }
        else{
            return response()->json(['message' => 'error, please try again'],
                Response::HTTP_OK);
        }
    }catch (\Illuminate\Database\QueryException $e) {
            // إذا حدثت خطأ بسبب قيد فريد (تكرار مكون)
            return response()->json(['message' => 'This component is already added to the meal'], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\Response
     */
    public function show(Component_in_meal $component_in_meal)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\JsonResponse
     */


    public function update(ComponentInMealUpdateRequest $request, Meal $meal, Component_in_meal $component_in_meal)
    {
        $validated = $request->validated();
        $old_quantity = $component_in_meal->component_in_meal_quantity;
        $old_unit_of_measurement = $component_in_meal->component_in_meal_unit_of_measurement;

        // تحديث البيانات في الجدول
        $component_in_meal->update([
            'component_in_meal_quantity' => $validated['component_in_meal_quantity'] ?? $old_quantity,
            'component_in_meal_unit_of_measurement' => $validated['component_in_meal_unit_of_measurement'] ?? $old_unit_of_measurement,
        ]);

        $component = Component::find($component_in_meal->component_id);
        $meal_row = $meal;
        $component_row = $component;

        // حساب التكلفة القديمة والجديدة
        $old_cost = $component_row->component_price * Component_in_meal::convert($old_quantity, $old_unit_of_measurement, $component_row->component_unit_of_measurement);
        $new_cost = $component_row->component_price * Component_in_meal::convert($validated['component_in_meal_quantity'], $validated['component_in_meal_unit_of_measurement'], $component_row->component_unit_of_measurement);

        // تحديث سعر الوجبة
        $meal_row->update(['meal_price' => $meal_row->meal_price - $old_cost + $new_cost]);

        return response()->json(['message' => 'ok'], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy(Meal $meal, Component_in_meal $component_in_meal)
    {
        $component = Component::find($component_in_meal->component_id);
        $old_cost = $component->component_price * Component_in_meal::convert($component_in_meal->component_in_meal_quantity, $component_in_meal->component_in_meal_unit_of_measurement, $component->component_unit_of_measurement);

        // حذف المكون من وجبة
        $component_in_meal->delete();

        $meal->update(['meal_price' => $meal->meal_price - $old_cost]);

        return response()->json(['message' => 'Component deleted successfully'], Response::HTTP_OK);
    }

}
