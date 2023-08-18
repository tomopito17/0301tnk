<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('user.index',compact('users'));
    }
    

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('user.edit',compact('user'));
    
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->role){ $user->role = $request->role; }
        else{ $user->role = 0; }
        $user->save();
        
        return redirect('/user');
    }


}