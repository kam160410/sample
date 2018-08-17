



@extends('layouts.default')

@section('title',$title)

@section('content')
  <div class="jumbotron">
    <h1>Sample App</h1>
    <p class="lead">
       Believe in yourself
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p>
  </div>
@stop