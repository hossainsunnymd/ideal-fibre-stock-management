<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //list user
    public function listUser(){
        $users=User::all();
        return Inertia::render('Users/UserListPage',['users'=>$users]);
    }

    //user save page
    public function userSavePage(Request $request){
        $userId=$request->user_id;
        $users=User::where('id',$userId)->first();
        return Inertia::render('Users/UserSavePage',['users'=>$users]);
    }

    //create user
    public function createUser(Request $request){
       $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required',
    ]);

     if ($validator->fails()) {
        return Inertia::render('Users/UserSavePage', [
            'errors' => $validator->errors()
        ]);
    }

       try{
        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
            'phone'=>$request->phone

        ];
        User::create($data);
        return redirect()->back()->with(['status'=>true,'message'=>'User created successfully']);
       }catch(Exception $e){
        return redirect()->back()->with(['status'=>false,'message'=>'Something went wrong'.$e->getMessage() ]);
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
        $userRole=User::where('id',$request->user_id)->first()->role;
        if($userRole=='superadmin'){
            return redirect()->back()->with(['status'=>false,'message'=>'You can not delete This User']);
        }
        User::where('id',$request->user_id)->delete();
        return redirect()->back()->with(['status'=>true,'message'=>'User deleted successfully']);
    }
}
