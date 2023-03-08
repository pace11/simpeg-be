<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class UserController extends ResponseController
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email', 
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return $this->sendResponse($user, "Register user success");
    }

    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] = $user->createToken('MyApp')->accessToken; 
            $success['expires_at'] = $user->createToken('MyApp')->token->expires_at;

            return $this->sendResponse($success, 'login success');
        } 

        return $this->sendError('Unauthorized', false, 401);
    }

    public function me() {
        $user = Auth::guard('api')->user();
        return $this->sendResponse($user, 'Get user success');
    }
}
