<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('generalpics/blacklogo.png')}}" />
  <title>Login</title>

  <script src="{{ asset('Semantic/assets/library/jquery.min.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/accordion.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/ad.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/breadcrumb.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/button.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/card.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/checkbox.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/comment.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/container.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/dimmer.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/divider.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/dropdown.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/embed.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/feed.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/flag.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/form.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/grid.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/header.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/icon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/image.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/input.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/item.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/label.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/list.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/loader.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/menu.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/message.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/modal.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/nag.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/popup.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/progress.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/rail.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/rating.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/reset.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/reveal.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/search.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/segment.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/shape.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/sidebar.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/site.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/statistic.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/step.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/sticky.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/tab.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/table.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/video.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/transition.css') }}">

  <script src="{{ asset('Semantic/dist/components/accordion.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/api.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/checkbox.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/colorize.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/dimmer.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/dropdown.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/embed.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/form.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/modal.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/nag.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/popup.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/progress.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/rating.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/search.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/shape.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/sidebar.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/state.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/sticky.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/tab.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/transition.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/video.js') }}"></script>
  <script src="{{ asset('Semantic/dist/components/visit.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.css') }}">
  <script src="{{ asset('Semantic/dist/semantic.js') }}"></script>

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
    background-image: url("{{ asset('generalpics/bg.jpg') }}") !important;
  }
  body > .grid {
    height: 100%;
  }
  .image {
    margin-top: -100px;
  }
  .column {
    max-width: 450px;
  }
</style>

</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui image header">
      <img src="{{ asset('generalpics/blacklogo.png')}}" class="image">
      <div class="content">
        @foreach($gen as $gen)
        {{$gen->catering_name}}
        @endforeach
      </div>
    </h2>
    <form class="ui large form" method="post" action="/doLogin">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="Username" value="{{ old('email') }}">
          </div>
        </div>
        @if ($errors->has('email'))
        <div class="ui negative message">
          <p>{{ $errors->first('email') }}</p>
        </div>
        @endif
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
          </div>
        </div>
        @if ($errors->has('password'))
        <div class="ui negative message">
          <p>{{ $errors->first('password') }}</p>
        </div>
        @endif
        @if(session('message'))
        <div class="ui negative message">
          <p>{{ session('message.text')}}</p>
        </div>
        @endif
        <button type="submit" class="ui fluid large green submit button">Login</button>
        <div class="ui grid">
          <div class="row">
            <div class="six wide column right floated">
              <a href="">Forgot password?</a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>