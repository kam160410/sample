<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;
use Auth;

class StaticPagesController extends Controller
{
    /**
     * 主页
     * @return [type] [description]
     */
    public function home()
    {
        $title = "主页";
        $feed_items = [];
        if(Auth::check()){
            $feed_items = Auth::user()->feed()->paginate('30');
        }
    	return view('static_pages/home',compact('title','feed_items'));
    }

    /**
     * 帮助页
     * @return [type] [description]
     */
    public function help()
    {
    	return view('static_pages/help',['title'=>"帮助页"]);
    }

    /**
     * 关于
     * @return [type] [description]
     */
    public function about()
    {
    	return view('static_pages/about',['title'=>"关于页"]);
    }
}
