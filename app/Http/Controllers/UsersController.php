<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

	/**
	 * [create description]
	 * @return [type] [description]
	 */
    public function create()
    {

    	return view('users.create',['title'=>'用户注册']);
    }

    /**
     * [show description]
     * @param User $user [description]
     * @return [type] [description]
     */
    public function show(User $user)
    {
    	$title = "用户信息";
    	return view('users.show',compact('user','title'));
    }

    /**
     * [store description]用户注册界面git a
     * @param Request $request [description]
     * @return [type] [description]
     */
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name'    	=>  "required|max:50",
    		'email'   	=>  "required|email|unique:users|max:255",
    		'password'  =>  "required|confirmed|min:6"
    	]);

    	$user = User::create([
    		'name'  =>  $request->name,
    		'email' =>  $request->email,
    		'password' => bcrypt($request->password)
    	]);
    	Auth::login($user);
    	session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
    	return redirect()->route('users.show',[$user]);
    }

 }