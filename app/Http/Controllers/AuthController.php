<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //user login page
    public function loginPage(){
       return Inertia::render('Auth/LoginPage');
    }

    //user login
    public function login(Request $request){


          $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
          ]);

          if($validator->fails()){

            return redirect()->back()->with(['errors' => $validator->errors()]);

          }


          $user = User::where('email', $request->email)->first();

          if (!$user || !Hash::check($request->password, $user->password)) {
              return redirect()->back()->with(['status'=>false,'message'=>'Invalid email or password']);
          }
          $request->session()->put('role',$user->role);
          $token=JWTToken::createToken($user->email);
          return redirect('/product-stock-list')->cookie('token', $token, 60*60*24);
    }

    //user logout
    public function logout(Request $request){
        $request->session()->flush();

        return redirect('/')->cookie('token', '', -1);
    }

}
