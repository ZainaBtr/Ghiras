<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\NoReturn;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    #[NoReturn] public function index()
    {
        //
        dd("11");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
        dd("12");

    }

    /**
     * Display the specified resource.
     *
     * @param Component $component
     * @return void
     */
    #[NoReturn] public function show(Component $component)
    {
        //
        dd("13");

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Component $component
     * @return void
     */
    #[NoReturn] public function update(Request $request, Component $component)
    {
        //
        dd("14");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Component $component
     * @return void
     */
    #[NoReturn] public function destroy(Component $component)
    {
        //
        dd("15");

    }
}
