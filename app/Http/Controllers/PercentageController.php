<?php

namespace App\Http\Controllers;

use App\Http\Requests\PercentageStoreRequest;
use App\Models\Percentage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class PercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $percentage =Percentage::query()->get()->all();

        return response()->json($percentage,Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PercentageStoreRequest $request)
    {

        $validated = $request->validated();

        $percentage=Percentage::create($validated);

        return response()->json($percentage,Response::HTTP_CREATED);
        // HTTP_CREATED = 201  *  يعني تأنشأ صح  *


    }

}
