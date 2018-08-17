<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function create()
    {

    	return view('users.create',['title'=>'用户注册']);
    }

    public function show(User $user)
    {
    	return view('users.show',compact('user'));
    }
}
