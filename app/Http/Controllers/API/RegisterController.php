<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $request->validate(
        [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password',
        ]);
        /*if($validator->fails()){
            return $this->sendError('Validation Error.',$validator->errors());
        }*/
        $validator['password'] = bcrypt($validator['password']);
        $user = User::create($validator);
        $success['token'] = $user -> createToken('exerciseBookShelf')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success,'User register successfully');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user -> createToken('exerciseBookShelf')->plainTextToken;
            $success['name'] =  $user -> name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'],403);
        }
    }
    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
