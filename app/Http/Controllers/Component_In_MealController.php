<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentInMealStoreRequest;
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
     * @return void
     */
    #[NoReturn] public function index()
    {
        //
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
        $validated = $request->validated();

        $component_names = $validated['component_name'];

        $component_id = Component::where('component_name',$component_names)->first();

        $component_in_meal=Component_in_meal::create([
            'meal_id' => $meal->id,
            'component_id' => $component_id->id,
            'component_in_meal_quantity' => $validated['component_in_meal_quantity'],
            'component_in_meal_unit_of_measurement' => $validated['component_in_meal_unit_of_measurement'],
        ]);

//////////// price
//        $component_row =  Component::Where('component_name',$validated['component_name'])->first();
//
//        $old_price=Meal::Where('id',$meal->id)->first();
//
//        $price = conversion($meal->id);
//
//        $old_price->update(['meal_price' => $old_price+$price]);
////////////

        return response()->json($component_in_meal,Response::HTTP_CREATED);
        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Component_in_meal $component_in_meal)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy(Component_in_meal $component_in_meal)
    {
        $component_in_meal->delete();
        return response()->json(['message' => 'component in meal deleted successfully']);


    }
}
