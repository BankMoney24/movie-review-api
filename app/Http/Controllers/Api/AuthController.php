<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $User = User::create($input);
        $success['token'] = $User->createToken('MyApp')->accessToken;
        $success['name'] = $User->name;

        Mail::to(User::where('role','admin')->pluck('email'))->send(new UserRegistered($User));

        return $this->sendResponse($success, 'User registration successful');
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('Myapp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'user login successfully');
        }
        else{
            return $this->sendError('Unauthorised', ['error' => 'Unauthorized']);
        }
    }
}
