<?php

namespace App\Http\Controllers;

use App\Models\Component_in_meal;
use Illuminate\Http\Request;

class Component_In_MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        dd("6");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        dd("7");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\Response
     */
    public function show(Component_in_meal $component_in_meal)
    {
        //
        dd("8");

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
        dd("9");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component_in_meal  $component_in_meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component_in_meal $component_in_meal)
    {
        dd("10");

        //
    }
}
