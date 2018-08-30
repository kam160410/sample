<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use Auth;
class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        //如果关注的用户是自己，跳转到首页
        if (Auth::user()->id === $user->id) {
            session()->flash("info",'不能关注和取消关注自己!');
            return redirect('/home');
        }
        //如果不存在关注列表中，添加关注
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        session()->flash('success','关注成功!');
        return redirect()->route('users.show', $user->id);
    }

    public  function destroy(User $user)
    {
        //如果取消关注的用户是自己，跳转到首页
        if (Auth::user()->id === $user->id) {
            session()->flash("info",'不能关注和取消关注自己!');
            return redirect('/home');
        }

        //如果存在关注列表中，取关
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        session()->flash("success",'取消关注成功');
        return redirect()->route('users.show', $user->id);
    }
}
