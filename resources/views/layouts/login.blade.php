<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN</title>
  @include('layouts.header')
  <style>
    .bgmenu {
       background: url('gambar/coffe_bg.jpg');
       background-repeat: no-repeat;
       background-size: 100%;
    }
  </style>
  
</head>
<body class="hold-transition login-page bgmenu">
  @yield('content')
    

@include('layouts.footer')
@include('sweetalert::alert')
</body>
</html>
