<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'first_name'=>['required','string','max:255'],
                'last_name'=>['required','string','max:255'],
                'password'=>['required','string','min:8']
            ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->all(),Response::HTTP_UNPROCESSABLE_ENTITY );
        }
        $credentials = request(['first_name','last_name','password']);
        if(!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }
    public function createAccount(Request $request){
        $validator = Validator::make($request->all(),
            [
                'first_name'=>['required','string','max:255'],
                'last_name'=>['required','string','max:255'],
                'password'=>['required','string','min:8'],
            ]);

        if ($validator->fails()){
            return $validator->errors()->all();
        }

        $request['password']=Hash::make($request['password']);
        $user =User::query()->create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'role'=>$request->role,
            'password'=>$request->password,
        ]);

        $tokenResult=$user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        //Session::flush();
        //Auth::logout();
        //  return redirect('login');
        //$request->user()->token()->delete();
        $result = $request->user()->token()->revoke();
        if($result){
            $respose= response()->json(['error'=>true,'message'=>'you logout succsessfully','result'=>[]],Response::HTTP_OK);
        }else{
            $respose= response()->json(['error'=>false,'message'=>'could not logout','result'=>[]],400);
        }
        return $respose;
    }

    public function clientLogin(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'phone_number'=>['required','numeric'],
                'password'=>['required','string','min:8']
            ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->all(),Response::HTTP_UNPROCESSABLE_ENTITY );
        }
        $credentials = request(['first_name','last_name','address','gender','age','phone_number','password']);
        if(!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }
    public function createClientAccount(Request $request){
        $validator = Validator::make($request->all(),
            [
                'first_name'=>['required','string','max:255'],
                'last_name'=>['required','string','max:255'],
                'address'=>['required','string','max:255'],
                'gender'=>['required','string','max:255'],
                'age'=>['required','numeric'],
                'phone_number'=>['required','string'],
                'password'=>['required','string','min:8'],
            ]);

        if ($validator->fails()){
            return $validator->errors()->all();
        }
        $request['password']=Hash::make($request['password']);
        $user =User::query()->create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'age'=>$request->age,
            'phone_number'=>$request->phone_number,
            'password'=>$request->password,
        ]);

        $tokenResult=$user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }

    public function updateClientAccount(Request $request ){

            $id = auth()->id();
                //Auth::id();

        $user = User::findOrFail($id);

        // تحديث الحقول المطلوبة فقط
        if ($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->has('address')) {
            $user->address = $request->input('address');
        }
        if ($request->has('gender')) {
            $user->gender = $request->input('gender');
        }
        if ($request->has('age')) {
            $user->age = $request->input('age');
        }
        if ($request->has('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }if ($request->has('password')) {
            $user->password = $request->input('password');
        }

            $user->save();

        return response()->json( $user , Response::HTTP_OK);
    }


}

