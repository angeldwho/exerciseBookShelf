<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Utils\ApiCustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
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

        return ApiCustomResponse::sendResponse($success,'User register successfully');
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
            dispatch(new SendEmailJob($request->email));
            return ApiCustomResponse::sendResponse($success, 'User login successfully.');
        }
        else{
            return ApiCustomResponse::sendError('Unauthorised.', ['error'=>'Unauthorised'],403);
        }
    }

    public function getToken(Request $request){
        Auth::user()->tokens->get();
    }
    public function logout(){
        auth()->user()->tokens->delete();
        return ApiCustomResponse::sendResponse( 'User logout successfully.');

    }
}
