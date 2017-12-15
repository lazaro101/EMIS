<!DOCTYPE HTML>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('pics/blacklogo.png')}}" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') | {{$gen->catering_name}}</title>

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
  
  <style type="text/css">
    .ui.dimmer{
      background-color: black;
      opacity:0.8;
      position:fixed;
      width:100%;
      height:100%;
      top:0px;
      left:0px;
      z-index:1000;
    }
    .hidden.menu {
      display: none;
    }

    .masthead.segment {
      min-height: 700px;
      padding: 1em 0em;
    }
    .masthead .logo.item img {
      margin-right: 1em;
    }
    .masthead .ui.menu .ui.button {
      margin-left: 0.5em;
    }
    .masthead h1.ui.header {
      margin-top: 3em;
      margin-bottom: 0em;
      font-size: 4em;
      font-weight: normal;
    }
    .masthead h2 {
      font-size: 1.7em;
      font-weight: normal;
      color:black;
    }

    .ui.vertical.stripe {
      padding: 8em 0em;
    }
    .ui.vertical.stripe h3 {
      font-size: 2em;
    }
    .ui.vertical.stripe .button + h3,
    .ui.vertical.stripe p + h3 {
      margin-top: 3em;
    }
    .ui.vertical.stripe .floated.image {
      clear: both;
    }
    .ui.vertical.stripe p {
      font-size: 1.33em;
    }
    .ui.vertical.stripe .horizontal.divider {
      margin: 3em 0em;
    }

    .quote.stripe.segment {
      padding: 0em;
    }
    .quote.stripe.segment .grid .column {
      padding-top: 5em;
      padding-bottom: 5em;
    }

    .footer.segment {
      padding: 5em 0em;
    }

    .secondary.pointing.menu .toc.item {
      display: none;
    }

    @media only screen and (max-width: 700px) {
      .stripe.segment .row h1 {
        font-size:30px !important;
      }
      .masthead.segment{
        background-size: cover !important;
      }
      .ui.fixed.menu {
        display: none !important;
      }
      .secondary.pointing.menu .item,
      .secondary.pointing.menu .menu {
        display: none;
      }
      .secondary.pointing.menu .toc.item, 
      .secondary.pointing.menu .logo.item {
        display: block;
      }
      .masthead.segment {
        min-height: 350px;
      }
      .masthead h1.ui.header {
        font-size: 2em;
        margin-top: 1.5em;
      }
      .masthead h2 {
        margin-top: 0.5em;
        font-size: 1.5em;
      }
      .fixed.menu {
        display: none;
      }
    }
  </style>
  <!-- Scripts -->
<script>
$(document).ready(function() {
    
  setTimeout(function(){ 
    $('.ui.active.dimmer').removeClass('active');
  }, 1000); 

  // fix menu when passed
  $('.ui.text.masthead').visibility({
      once: false,
      onBottomPassed: function() {
        $('.fixed.menu').transition('fade in');
      },
      onBottomPassedReverse: function() {
        $('.fixed.menu').transition('fade out');
      }
  });

  // create sidebar and attach to menu open
  $('.ui.sidebar')
    .sidebar('attach events', '.toc.item');
  });
</script>

  @yield('script')
  @yield('style')

</head>
<body>

<!-- Following Menu -->
<div class="ui top fixed hidden menu">
  <div class="ui container">
    <a class="header item"><img src="generalpics/blacklogo.png">{{$gen->catering_name}}</a>
    <div class="right item">
      <a class="item" href="/">Home</a>
      <a class="item" href="/Menus">Menus</a>
      <a class="item" href="/Package">Packages</a>
      <a class="item" href="">About Us</a>
      <a class="item" href="/Contact-Us">Contact Us</a>
    </div>
  </div>
</div>

<!-- Sidebar Menu -->
<div class="ui vertical inverted right sidebar menu">
  <a class="item" href="/">Home</a>
  <a class="item" href="/Menus">Menus</a>
  <a class="item" href="/Package">Packages</a>
  <a class="item" href="">About Us</a>
  <a class="item" href="/Contact-Us">Contact Us</a>
</div>


<div class="ui active dimmer loading">
  <div class="ui active text big loader" >Please wait for a few Seconds...</div>
</div>

<div class="pusher">
  @yield('header')

  @yield('content')

  <div class="ui inverted vertical footer segment">
    <div class="ui container">
      <div class="ui stackable inverted divided equal width height stackable grid">
        <div class="centered center aligned column">
        <h4 class="ui inverted icon header">
          <i class="marker icon"></i>
          <div class="content">
            Location
            <div class="sub header"><p><br>{{$gen->address.' '.$gen->barangay.', '.$gen->city.' City'.$gen->province}}</p></div>
          </div>
        </h4>
        </div>
        <div class="centered center aligned column">
        <h4 class="ui inverted icon header">
          <i class="mobile icon"></i>
          <div class="content">
            Contact
            <div class="sub header"><br>
              <p>
                Email: {{$gen->contact_email}}<br>
                Telephone: {{$gen->contact_tele}}<br>
                Cellphone: {{$gen->contact_cell}}
              </p>
            </div>
          </div>
        </h4>
        </div>
      </div>
      <div class="ui divider"></div>
      <div class="ui inverted basic segment"><div class="ui centered header">Copyright © 2017 {{$gen->catering_name}}. All Rights Reserved</div></div>
      <div class="ui divider"></div>
    </div>
  </div>
</div>
 @yield('forms')
</body>
</html>