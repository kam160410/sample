<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

	/**
	 * 用户登录
	 * @return [type] [description]
	 */
    public function create()
    {
    	$title = "用户登录";
    	return view('sessions.create',compact('title'));
    }

    public function store(Request $request)
    {
    	 $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required|min:6'
      	 ]);

    	 if( Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来!');
            return redirect()->route('users.show',[Auth::user()]);
    	 }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
    	 }

    }

    /**
     * 用户退出
     * @return [type] [description]
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','退出成功!');
        return redirect()->route('login');
    }

}