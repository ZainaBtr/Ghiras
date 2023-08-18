<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentBillInFridgeStoreRequest;
use App\Http\Requests\ComponentBillInFridgeUpdateRequest;
use App\Models\Component;
use App\Models\ComponentBill;
use App\Models\ComponentBillInFridge;
use App\Notifications\MinimalQuantityAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Bridge\User;

class ComponentBillInFridgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Component $component)
    {
        $componentBillInFridge = ComponentBillInFridge::where('component_id', $component['id'])->get();

        return response()->json($componentBillInFridge, Response::HTTP_OK);
        // HTTP_OK = 200
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ComponentBillInFridgeStoreRequest $request, Component $component)
    {
        $validated = $request->validated();

        $component_bill_available = $validated['component_bill_purchase_quantity']
            - $validated['component_bill_consumption_quantity'] - $validated['component_bill_waste_quantity'];

        $componentBillInFridge = ComponentBillInFridge::create(array_merge($validated, [
            'component_id' => $component['id'],
            'component_bill_available' => $component_bill_available,
        ]));

        //////////////////////////////////////rest editing in component table

        $rest = ComponentBillInFridge::where('component_id', $component['id'])->sum('component_bill_available');

        $component->update(['component_available_quantity' => $rest]);

        return response()->json($componentBillInFridge, Response::HTTP_CREATED);
        // HTTP_CREATED = 201
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentBillInFridge  $componentBillInFridge
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentBillInFridge $componentBillInFridge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentBillInFridge  $componentBillInFridge
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentBillInFridge $componentBillInFridge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentBillInFridge  $componentBillInFridge
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComponentBillInFridgeUpdateRequest $request, ComponentBillInFridge $componentBillInFridge)
    {
        $validated = $request->validated();

        $component_bill_purchase_quantity = $validated['component_bill_purchase_quantity']
            ?? $componentBillInFridge['component_bill_purchase_quantity'];

        $component_bill_consumption_quantity = $validated['component_bill_consumption_quantity']
            ?? $componentBillInFridge['component_bill_consumption_quantity'];

        $component_bill_waste_quantity = $validated['component_bill_waste_quantity']
            ?? $componentBillInFridge['component_bill_waste_quantity'];

        $component_bill_available = $component_bill_purchase_quantity
            - $component_bill_consumption_quantity - $component_bill_waste_quantity;

        $data = array_merge($validated, [
            'component_id' => $componentBillInFridge['component_id'],
            'component_bill_available' => $component_bill_available,
        ]);

        $componentBillInFridge->update($data);

        //////////////////////////////////////rest_editing

        $rest = ComponentBillInFridge::where('component_id', $componentBillInFridge['component_id'])->sum('component_bill_available');

        Component::findOrFail($componentBillInFridge['component_id'])->update(['component_available_quantity' => $rest]);

        return response()->json($componentBillInFridge, Response::HTTP_OK);
        // HTTP_OK = 201
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentBillInFridge  $componentBillInFridge
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ComponentBillInFridge $componentBillInFridge)
    {
        $componentId = $componentBillInFridge['component_id'];

        $componentBillInFridge->delete();

        //////////////////////////////////////rest_editing

        $rest = ComponentBillInFridge::where('component_id', $componentId)->sum('component_bill_available');

        Component::findOrFail($componentId)->update(['component_available_quantity' => $rest]);

        return response()->json(['message' => 'deleted successfully'], Response::HTTP_OK);
        // HTTP_OK = 200
    }
}
