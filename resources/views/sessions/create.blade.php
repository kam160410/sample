@extends('layouts.default')
@section('title', $title)

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>{{$title}}</h5>
    </div>
    <div class="panel-body">
      @include('shared._error')

      <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="email">邮箱：</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
          </div>

          <div class="form-group">
            <label for="password">密码：</label>
            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
          </div>

          <div class="checkbox">
              <label><input type="checkbox" name="remember"> 记住我</label>
          </div>

          <button type="submit" class="btn btn-primary">登录</button>
      </form>

      <hr>

        <p>
            <span class="col-xs-6">还没账号？<a href="{{ route('signup') }}">现在注册！</a></span>
            <span  class="col-xs-6 text-right"><a href="{{ route('password.request') }}">忘记密码</a></span>
        </p>
    </div>
  </div>
</div>
@stop