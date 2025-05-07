<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //user login page
    public function loginPage(){
       return Inertia::render('Auth/LoginPage');
    }

    //user login
    public function login(Request $request){

          $request->validate([
            'email'=>'required',
            'password'=>'required'
          ]);

          $user = User::where('email', $request->email)->first();

          if (!$user || !Hash::check($request->password, $user->password)) {
              return redirect()->back()->with(['status'=>false,'message'=>'Invalid email or password']);
          }

          $token=JWTToken::createToken($user->email);
          return redirect('/product-stock-list')->cookie('token', $token, 60*60*24);
    }

    //user logout
    public function logout(){
        return redirect('/login-page')->cookie('token', '', -1);
    }

}
