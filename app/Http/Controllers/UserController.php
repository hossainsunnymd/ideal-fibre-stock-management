<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //list user
    public function listUser(){
        $users=User::all();
        return Inertia::render('User/UserList',['users'=>$users]);
    }

    //user save page
    public function userSavePage(Request $request){
        $userId=$request->user_id;
        $user=User::where('id',$userId)->first();
        return Inertia::render('User/UserSavePage',['user'=>$user]);
    }

    //create user
    public function createUser(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'role'=>'required'
        ]);

       try{
        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
            'phone'=>$request->phone

        ];
        $user=User::create($data);
        return redirect('')->back()->with(['status'=>true,'message'=>'User created successfully']);
       }catch(Exception $e){
        return redirect()->back()->with(['status'=>false,'message'=>'Something went wrong']);
       }
    }

    //update user

    public function updateUser(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'role'=>'required'
        ]);
     try{
        User::where('id',$request->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
            'phone'=>$request->phone
        ]);
        return redirect()->back()->with(['status'=>true,'message'=>'User updated successfully']);
     }catch(Exception $e){
        return redirect()->back()->with(['status'=>false,'message'=>'Something went wrong']);
     }
    }

    //delete user
    public function deleteUser(Request $request){
        User::where('id',$request->user_id)->delete();
        return redirect()->back()->with(['status'=>true,'message'=>'User deleted successfully']);
    }
}
