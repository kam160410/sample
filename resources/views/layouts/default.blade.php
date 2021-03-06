<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','sample')</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
</head>
<body>
    @include('layouts/_header')
    <div class="container">
      @include('shared._msg')
      @yield('content')
      @include('layouts/_footer')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>