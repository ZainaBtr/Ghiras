<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentBillStoreRequest;
use App\Http\Requests\ComponentBillTransferRequest;
use App\Http\Requests\ComponentBillUpdateRequest;
use App\Models\Component;
use App\Models\component_in_meal;
use App\Models\ComponentBill;
use App\Models\ComponentBillInFridge;
use App\Notifications\MinimalQuantityAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComponentBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Component $component)
    {
        $componentBill = ComponentBill::where('component_id', $component['id'])->get();

        return response()->json($componentBill, Response::HTTP_OK);
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
    public function store(ComponentBillStoreRequest $request, Component $component)
    {
        $componentBill = (new \App\Models\ComponentBill)->store($request, $component);

        return response()->json($componentBill, Response::HTTP_CREATED);
        // HTTP_CREATED = 201
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentBill  $componentBill
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentBill $componentBill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentBill  $componentBill
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentBill $componentBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentBill  $componentBill
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComponentBillUpdateRequest $request, ComponentBill $componentBill)
    {
        $validated = $request->validated();

        $data['component_id'] = $componentBill['component_id'];

        $component_bill_purchase_quantity = $validated['component_bill_purchase_quantity']
            ?? $componentBill['component_bill_purchase_quantity'];

        $component_bill_consumption_quantity = $validated['component_bill_consumption_quantity']
            ?? $componentBill['component_bill_consumption_quantity'];

        $component_bill_waste_quantity = $validated['component_bill_waste_quantity']
            ?? $componentBill['component_bill_waste_quantity'];

        $component_bill_available = $component_bill_purchase_quantity
            - $component_bill_consumption_quantity - $component_bill_waste_quantity;

        $data = array_merge($validated, [
            'component_id' => $componentBill['component_id'],
            'component_bill_available' => $component_bill_available,
        ]);

        $componentBill->update($data);

        //////////////////////////////////////rest_editing

        $rest = ComponentBill::where('component_id', $componentBill->component_id)->sum('component_bill_available');

        Component::where('id', $componentBill['component_id'])->update(['component_available_quantity' => $rest]);

        //////////////////////////////////////notification to admin

//        $user = User::Where('is_admin', 'true')->first();
//
//        if($componentBill['components']->component_minimal_quantity >= $componentBill['components']->component_available_quantity)
//        {
//            Notification::send($user, new MinimalQuantityAdminNotification($componentBill['components']->component_name));
//        }

        return response()->json($componentBill, Response::HTTP_OK);
        // HTTP_OK = 201
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentBill  $componentBill
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ComponentBill $componentBill)
    {
        $componentId = $componentBill['component_id'];

        $componentBill->delete();

        //////////////////////////////////////rest_editing

        $rest = ComponentBill::where('component_id', $componentId)->sum('component_bill_available');

        Component::findOrFail($componentId)->update(['component_available_quantity' => $rest]);

        return response()->json(['message' => 'deleted successfully'], Response::HTTP_OK);
        // HTTP_OK = 200
    }

    public function transfer(ComponentBillTransferRequest $request, ComponentBill $componentBill)
    {
        $validated = $request->validated();

        $component = Component::where('component_name', $componentBill['components']->component_name)
            ->where('component_address', 'first store')->first();

        if (!$component) {
            return response()->json(['message' => 'Invalid component in the first store'], Response::HTTP_UNPROCESSABLE_ENTITY);
            // HTTP_UNPROCESSABLE_ENTITY = 422
        }

        $component_bill_quantity = $validated['component_bill_quantity'];

        $available = $componentBill['component_bill_available'];

        if ($component_bill_quantity == 0) {
            return response()->json(['message' => 'Unable to transfer, you did not enter any value to transfer'], Response::HTTP_OK);
            //HTTP_OK = 200
        }

        if ($available == 0) {
            return response()->json(['message' => 'Unable to transfer, no available quantity to transfer'], Response::HTTP_OK);
            //HTTP_OK = 200
        }

        if ($component_bill_quantity > $available) {
            return response()->json(['message' => 'There is an error, the transfer quantity must be less than or equal to the available quantity in this bill'], Response::HTTP_OK);
            //HTTP_OK = 200
        }

        $componentBillInSecondStore = ComponentBill::find($componentBill['id']);

        $componentBillRequest = new ComponentBillStoreRequest();
        $componentBillRequest->merge([
            'component_bill_purchase_quantity' => $componentBillInSecondStore->component_bill_purchase_quantity,
            'component_bill_purchase_price' => $componentBillInSecondStore->component_bill_purchase_price,
            'component_bill_purchase_date' => $componentBillInSecondStore->component_bill_purchase_date,
            'component_bill_consumption_quantity' => $componentBillInSecondStore->component_bill_consumption_quantity,
            'component_bill_waste_quantity' => $componentBillInSecondStore->component_bill_waste_quantity,
            'component_bill_expiration_date' => $componentBillInSecondStore->component_bill_expiration_date,
        ]);

        $component_bill_available = $componentBillInSecondStore->component_bill_available;
        $componentBillInSecondStore->update(['component_bill_available' => $component_bill_available - $component_bill_quantity]);
        $new_component_bill_available = $component_bill_quantity;

        $dateString = now()->toDateString();
        $componentBillInSecondStore->update(['component_date_of_transfer_or_hosting' => $dateString]);

        $componentBillInFirstStore = (new \App\Models\ComponentBill)->store($componentBillRequest, $component);

        $componentBillInFirstStore->update([
            'component_id' => $component->id,
            'component_bill_available' => $new_component_bill_available,
            'component_date_of_transfer_or_hosting' => $dateString
        ]);

        return response()->json(['message' => 'Transferring successfully'], Response::HTTP_OK);
        //HTTP_OK = 200
    }
}
