<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Component;
//use Illuminate\Http\Request;
//use Illuminate\Http\Response;
//use JetBrains\PhpStorm\NoReturn;
//use Illuminate\Support\Facades\Validator;
//
//class ComponentController extends Controller
//{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    #[NoReturn] public function index()
//    {
//        //
//        $component=Component::query()->get()->all();
//
//        return response()->json($component,Response::HTTP_OK);
//
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param Request $request
//     * @return void
//     */
//    public function store(Request $request)
//    {
//        //
//        $validator = Validator::make($request->all(), [
//            'component_name' => ['required'],
//            'component_type' => ['required'],
//            'component_price' => ['required'],
//            'component_address' => ['required'],
//            'component_minimal_quantity' => ['required'],
//            'component_available_quantity' => ['required'],
//            'component_unit_of_measurement' => ['required'],
//            'component_appointment_end_date_reminder' => ['required'],
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
//            // HTTP_UNPROCESSABLE_ENTITY = 422  *  يعني غلط بالداتا المدخلة  *
//        }
//
//        $component_name=$request->component_name;
//        $component_type =$request->component_type;
//        $component_price=$request->component_price;
//        $component_address=$request->component_address;
//        $component_minimal_quantity=$request->component_minimal_quantity;
//        $component_available_quantity=$request->component_available_quantity;
//        $component_unit_of_measurement=$request->component_unit_of_measurement;
//        $component_appointment_end_date_reminder=$request->component_appointment_end_date_reminder;
//
//
//        $component=Component::query()->create([
//            'component_name'=>$component_name,
//            'component_type'=>$component_type,
//            'component_price'=>$component_price,
//            'component_address'=>$component_address,
//            'component_minimal_quantity'=>$component_minimal_quantity,
//            'component_available_quantity'=>$component_available_quantity,
//            'component_unit_of_measurement'=>$component_unit_of_measurement,
//            'component_appointment_end_date_reminder'=>$component_appointment_end_date_reminder,
//        ]);
//        $component->save();
//        return response()->json($component,Response::HTTP_CREATED);
//
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param Component $component
//     * @return void
//     */
//    #[NoReturn] public function show(Component $component)
//    {
//        //
//        dd("13");
//
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param Request $request
//     * @param Component $component
//     * @return void
//     */
//
//    public function update(Request $request, $id)
//    {
//        // استرداد الوجبة التي سيتم تحديثها
//        $component = Component::findOrFail($id);
//
//        // تحديث الحقول المطلوبة فقط
//        if ($request->has('meal_name')) {
//            $component->component_name = $request->input('component_name');
//        }
//        if ($request->has('component_type')) {
//            $component->component_type = $request->input('component_type');
//        }
//        if ($request->has('component_price')) {
//            $component->component_price = $request->input('component_price');
//        }
//        if ($request->has('component_address')) {
//            $component->component_address = $request->input('component_address');
//        }
//        if ($request->has('component_minimal_quantity')) {
//            $component->component_minimal_quantity = $request->input('component_minimal_quantity');
//        }
//
//        if ($request->has('component_available_quantity')) {
//            $component->component_available_quantity = $request->input('component_available_quantity');
//
//        }if ($request->has('component_unit_of_measurement')) {
//        $component->component_unit_of_measurement = $request->input('component_unit_of_measurement');
//
//        }if ($request->has('component_appointment_end_date_reminder')) {
//        $component->component_appointment_end_date_reminder = $request->input('component_appointment_end_date_reminder');
//        }
//
//        // حفظ التحديثات في قاعدة البيانات
//        $component->save();
//
//        // إرجاع الوجبة المحدثة كإجابة JSON
//        return response()->json($component,Response::HTTP_CREATED);
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param Component $component
//     * @return void
//     */
//
//    public function destroy(Component $component )
//    {
//        //
//        $component->delete();
//        return response()->json(['message' => 'component deleted successfully']);
//
//    }
//
//    public function findComponent(Request $request)
//    {
//        $component_name = $request->component_name;
//        $component = Component::where('component_name', $component_name)->first();
//        if($component){
//            return response()->json($component, 200);
//            // HTTP_OK = 200  * يعني تم بنجاح وراجع بيانات *
//        } else {
//            return response()->json(['message' => 'component not found'], 404);
//            // HTTP_NOT_FOUND = 404  * يعني مو راجع شيء وفي خطأ *
//        }
//    }
//
//
//
//}


namespace App\Http\Controllers;

use App\Http\Requests\ComponentStoreRequest;
use App\Http\Requests\ComponentUpdateRequest;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $component = Component::query()->get();

        return response()->json($component, Response::HTTP_OK);
        // HTTP_OK = 200
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ComponentStoreRequest $request)
    {
        $validated = $request->validated();

        if ($validated['component_type'] != 'مادة نصف مصنعة') {
            $validated['component_available_quantity'] = 0;
        } else {
            $validated['component_available_quantity'] = $validated['component_available_quantity'] ?? 0;
        }

        $component = Component::create($validated);

        return response()->json($component, Response::HTTP_CREATED);
        // HTTP_CREATED = 201
    }

    /**
     * Display the specified resource.
     *
     * @param Component $component
     * @return void
     */
    public function show(Component $component)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Component $component
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComponentUpdateRequest $request, Component $component)
    {
        $validated = $request->validated();

        if (($validated['component_type'] ?? $component['component_type']) != 'مادة نصف مصنعة') {
            $validated['component_available_quantity'] = 0;
        } else {
            $validated['component_available_quantity'] = $validated['component_available_quantity'] ?? 0;
        }

        $component->update($validated);

        return response()->json($component, Response::HTTP_OK);
        // HTTP_OK = 200
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Component $component
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Component $component)
    {
        $component->delete();

        return response()->json(['message' => 'deleted successfully'], Response::HTTP_OK);
        // HTTP_OK = 200
    }
}
