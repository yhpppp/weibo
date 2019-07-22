<!DOCTYPE html>
<html>

<head>
  <title>@yield('title', 'Weibo App') - AMG</title>
  <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>

<body>
  @include('layouts._header')
  <div class="container">
    @include('share._messages')
    @yield('content')
    @include('layouts._footer')
  </div>
</body>

</html>
