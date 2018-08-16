<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    /**
     * 主页
     * @return [type] [description]
     */
    public function home()
    {
    	return view('static_pages/home',['title'=>"主页"]);
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
