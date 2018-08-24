<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth',[
            'except'  => ['show','create','store','confirmEmail']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * 用户中心展示页
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

	/**
	 * 用户注册页面展示
	 */
    public function create()
    {

    	return view('users.create',['title'=>'用户注册']);
    }

    /**
     * 用户信息展示
     */
    public function show(User $user)
    {
    	$title = "用户信息";
    	//$this->authorize('update',$user);
    	return view('users.show',compact('user','title'));
    }

    /**
     * 用户注册提交
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
    	//dd($user);
    	//邮箱注册
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('home');

//    	Auth::login($user);
//    	session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
//    	return redirect()->route('users.show',[$user]);
    }

    /**
     * 编辑用户展示页
     */
    public function edit(User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $authorizationException) {
            //session()->flash('warning','对不起，你无权访问此页面！');
            return redirect()->back();
            //return abort(403, '对不起，你无权访问此页面！');
        }
        $title = "编辑用户";
        return view('users.edit',compact('title','user'));
    }

    /**
     * 更新用户信息
     */
    public function update(User $user ,Request $request)
    {
            $this->validate($request,[
                'name' => 'required|max:50',
                'password' => 'required|min:6|confirmed'
            ]);

            try {
                $this->authorize('update', $user);
            } catch (AuthorizationException $authorizationException) {
                //session()->flash('warning','对不起，你无权访问此页面！');
                return redirect()->back();
                //return abort(403, '对不起，你无权访问此页面！');
            }

            $user->update([
                'name' => $request->name,
                'password' =>bcrypt($request->password)
            ]);
            session()->flash('success',"更新个人信息成功!");
            return redirect()->route('users.show',$user->id);
    }

    /**
     * 删除用户
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','删除成功!');
        return redirect()->back();
    }

    /**
     * 用户注册验证
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }

    public function sendEmailConfirmationTo($user)
    {
        $view = "users.confirm";
        $data = compact('user');
        $to   = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";
        Mail::send($view,$data,function($message) use ($to,$subject){
            $message->to($to)->subject($subject);
        });
    }



}