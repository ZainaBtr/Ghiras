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
    {//dd("jhjh");

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
}

