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

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.min.css') }}">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="{{ asset('Semantic/dist/semantic.min.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/dataTables/semantic.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/dataTables/dataTables.semanticui.min.css') }}">

  <script src="{{ asset('Semantic/dist/dataTables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('Semantic/dist/dataTables/dataTables.semanticui.min.js') }}"></script>
  <script src="{{ asset('Semantic/dist/dataTables/semantic.min.js') }}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.min.css') }}">
  <script src="{{ asset('Semantic/dist/semantic.js') }}"></script>
  
  <style type="text/css">
  .msgbox {
    width: 30em;
    height: 5em;
    position: absolute !important;
    left: 28em;
    top: 2em;
    display: block;
    z-index: 100;
  }
  .cont {
    margin: 0 0 0 250px;
    overflow-y: scroll;
    height:93%;
    background-color: rgba(180,180,180,.2);
    background-size: cover;
  }
  .ui.vertical.sidemenu.menu {
    float: left;
    width: 250px;
    overflow-y: scroll;
    height: 595px;
  }
  .dimmer.load{
    background-color: black;
  }
  .pusher {
    height: 100%;
    overflow: hidden;
  }
  .notif .menu .message{
    min-height: 150px;
    min-width: 250px;
  }
  .top.menu .toc.item {
    display: none;
  }

  @media only screen and (max-width: 700px) {
    .ui.vertical.sidemenu.menu {
      display: none;
    }
    .cont {
      margin: 0;
      overflow-y: scroll;
      height:90%;
    }
    .top.menu .toc.item {
      display: block;
    }
    .table-cont {
      overflow-x: scroll;
      /*width: 500px;*/
    }
    .table-cont table{
      width: 1000px;
    }
  }
  </style>
  <!-- Scripts -->
  <script>
  window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
  ]) !!};
  
  $(document).ready(function(){
    setTimeout(function(){ 
      $('.ui.active.dimmer.load').removeClass('active');
      $('.pusher').fadeIn(500); 
    }, 1000); 

    $('#side .button.logout').click(function(){
      event.preventDefault(); 
      $('#logout-form').submit();
    });

    $('.notif').dropdown({
      transition: 'drop'
    });

    $('#leftside').sidebar('attach events', '.toc.item')
      .sidebar('setting', 'transition', 'overlay');

    $('#rightside').sidebar('attach events','#menu')
      .sidebar('setting', 'transition', 'push');

  });
  </script>
  @yield('script')
  @yield('style')

</head>
<body>

<div class="ui active dimmer load">
  <div class="ui active text big loader" >Please wait for a few Seconds...</div>
</div>

<div class="ui inverted right vertical sidebar labeled icon menu" id="rightside">
  <a class="item">
    <i class="github alternate circular icon"></i>
    Your Profile
  </a>
  <a class="bottom floated item" onclick="$('#logout-form').submit();">
    <i class="sign out icon"></i>
    Sign Out
  </a>
</div>

<div class="ui inverted vertical sidebar menu" id="leftside">
  <div class="item header"><i class="home icon"></i>
    <a href="/Admin/Dashboard">Dashboard</a>
  </div>
  <div class="item header"><i class="configure icon"></i>
    <a href="/Admin/Maintenance/Package">Maintenance</a>
    <div class="menu">
      <a class="item" href="/Admin/Maintenance/Package">Package</a>
      <!-- <a class="item" href="/Admin/Maintenance/Menu">Menu</a> -->
      <a class="item" href="/Admin/Maintenance/Submenu">Submenu</a>
      <a class="item" href="/Admin/Maintenance/Services">Services</a>
      <a class="item" href="/Admin/Maintenance/Location">Location</a>
      <a class="item" href="/Admin/Maintenance/Staff">Staff</a>
      <a class="item" href="/Admin/Maintenance/Inventory">Inventory</a>
    </div>
  </div>
  <div class="item header"><i class="calendar icon"></i>
    <a href="/Admin/Transaction/Events">Transaction</a>
    <div class="menu">
      <a class="item" href="/Admin/Transaction/Events">Event Calendar</a>
      <a class="item" href="/Admin/Transaction/Event-Reservation">Event Reservations</a>
      <a class="item" href="/Admin/Transaction/Event-Inquiries">Event Inquiries</a>
      <a class="item" href="/Admin/Transaction/Food-Order">Food Orders</a>
      <a class="item" href="/Admin/Transaction/Payments">Payments</a>
    </div>
  </div>
  <div class="item header" href=""><i class="bar chart icon"></i>
    <a href="">Reports</a>
  </div>
  <div class="item header" href=""><i class="settings icon"></i>
    <a href="/Admin/Settings">Settings</a>
  </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<div class="pusher">

  <div class="ui inverted large red secondary top attached borderless menu">
    <a class="toc item">
      <i class="sidebar icon"></i>
    </a>
    <a href="/" class="item">{{$gen->catering_name}}</a>

    <div class="right menu">
      <!-- <div class="ui buttons">
        <div class="ui floating dropdown icon red button notif" tabindex="0">
          <i class="big bell icon"></i><div class="bottom right attached ui circular label">1</div>
          <div class="menu" tabindex="-1">
            <div class="ui message" style="width: 500px; max-height: 500px;overflow-y: scroll">
              <div class="ui active loader"></div>
              <div class="ui small feed">
                <div class="event">
                  <div class="label">
                    <i class="large bell icon"></i>
                  </div>
                  <div class="content">
                    <div class="date">
                      3 days ago
                    </div>
                    <div class="summary">
                       You have 3 new inquiries.
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui small feed">
                <div class="event">
                  <div class="label">
                    <i class="large bell icon"></i>
                  </div>
                  <div class="content">
                    <div class="date">
                      3 days ago
                    </div>
                    <div class="summary">
                       You have 3 new inquirieas asd asdas sad sa sds.
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div> -->
      <a class="item" id="menu">{{ Auth::user()->display_name }}</a>
    </div>
  </div>

  <div class="ui inverted large left attached vertical menu sidemenu">
    <div class="item header"><i class="home icon"></i>
      <a href="/Admin/Dashboard">Dashboard</a>
    </div>
    <div class="item header"><i class="configure icon"></i>
      <a href="/Admin/Maintenance/Package">Maintenance</a>
      <div class="menu">
        <a class="item" href="/Admin/Maintenance/Submenu">Submenu</a>
        <a class="item" href="/Admin/Maintenance/Package">Package</a>
        <a class="item" href="/Admin/Maintenance/Services">Services</a>
        <a class="item" href="/Admin/Maintenance/Location">Location</a>
        <a class="item" href="/Admin/Maintenance/Staff">Staff</a>
      </div>
    </div>
    <div class="item header"><i class="calendar icon"></i>
      <a href="/Admin/Transaction/Events">Transaction</a>
      <div class="menu">
        <a class="item" href="/Admin/Transaction/Events">Event Calendar</a>
        <a class="item" href="/Admin/Transaction/Event-Reservation">Event Reservations</a>
        <a class="item" href="/Admin/Transaction/Event-Inquiries">Event Inquiries</a>
        <a class="item" href="/Admin/Transaction/Food-Order">Food Orders</a>
        <a class="item" href="/Admin/Transaction/Payments">Payments</a>
      </div>
    </div>
    <div class="item header"><i class="archive icon"></i>
      <a href="#">Inventory</a>
      <div class="menu">
        <a class="item" href="/Admin/Inventory/EquipmentInventory">Equipment Inventory</a>
        <a class="item" href="/Admin/Inventory/Transfers">Purchase</a>
        <a class="item" href="/Admin/Inventory/Supplier">Supplier</a>
        <!-- <a class="item" href="/Admin/Inventory/Checklist">Pull Records</a> -->
      </div>
    </div>
    <div class="item header" href=""><i class="bar chart icon"></i>
      <a href="/Admin/Reports">Reports</a>
    </div>
    <div class="item header" href=""><i class="settings icon"></i>
      <a href="/Admin/Settings">Settings</a>
    </div>
  </div> 

  <div class="cont">
    @yield('content')
  </div>


</div>

  @yield('forms')
  
</body>
</html>