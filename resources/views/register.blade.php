<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('pics/logo1.png')}}" />
  <title>Register</title>

  <script src="{{ asset('Semantic/assets/library/jquery.min.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.min.css') }}">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="{{ asset('Semantic/dist/semantic.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#menu').click(function(){
      $('#side').sidebar('toggle')
        .sidebar('setting', 'transition', 'push');
    });
  });
</script>

<style type="text/css">
  body {
    background-image: url("{{ asset('pics/bg.jpg') }}") !important;
    /*background-size:contain;
    background-attachment: all;
    background-clip: content-box;*/
  }    
  .segment {
    position: absolute;
    width: 60%;
    left: 20%;
    top: 20%;
  }
</style>

</head>
<body>

<div class="ui segment">
  <form class="ui form" method="post" action="/doRegister">
  <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <div class="field">
      <label>Enter Username:</label>
      <input type="text" placeholder="Username" name="username" value="{{ old('Admin')}}">
    </div>
    <div class="field">
      <label>Enter Password:</label>
      <input type="password" placeholder="Password" name="password">
    </div>
    
    <button class="ui button" type="submit" name="register" value="register">Register</button>
    @if($errors->any())
    @foreach($errors->all() as $error)
      {{ $error }} <br>
    @endforeach
  @endif
  @if(session('message'))
      {{ session('message.text')}}
  @endif
  </form>
</div>

</body>
</html>