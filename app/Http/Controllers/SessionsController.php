<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }


	/**
	 * 用户登录
	 * @return [type] [description]
	 */
    public function create()
    {
    	$title = "用户登录";
    	return view('sessions.create',compact('title'));
    }

    /**
     * 提交登录页
     */
    public function store(Request $request)
    {
    	 $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required|min:6'
      	 ]);

    	 if( Auth::attempt($credentials,$request->has('remember'))){
    	     if(Auth::user()->activated){
                 session()->flash('success','欢迎回来!');
                 return redirect()->intended( route('users.show',[Auth::user()]) );
             }else{
                    Auth::logout();
                    session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                    return  redirect()->route('home');
             }
    	 }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
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

