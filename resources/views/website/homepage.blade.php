@extends('layouts.web')

@section('title','Homepage')

@section('script')

@endsection

@section('style')

@endsection

@foreach($gen as $gen)
@endforeach

@section('header')
<div class="ui inverted vertical masthead center aligned segment" style="background-image: url('{{ asset('image/Website/headerbg.jpg') }}');">
  <div class="ui container">
    <div class="ui large secondary pointing menu" style="border:none">
    <a href="/" class="header logo item"><img src="generalpics/blacklogo.png">{{$gen->catering_name}}</a>
      <div class="right item"> 
      <a class="toc item">
        <i class="sidebar icon"></i>
      </a>
      <a href="/" class="active item">Home</a>
      <a href="/Menus" class="item">Menus</a>
      <a href="/Package" class="item">Packages</a>
      <a href="" class="item">About Us</a>
      <a href="/Contact-Us" class="item">Contact Us</a>
      </div>
    </div>
  </div>

  <div class="ui text masthead">
    <h1 class="ui header">
      {{$gen->catering_name}}
    </h1>
    <h2>Your Catering for All Occassions.</h2>
    <a class="ui huge primary button" href="/Contact-Us">Inquire Now<i class="right arrow icon"></i></a>
  </div>
</div>
@endsection

@section('content')
  <div class="ui vertical stripe segment">
    <div class="ui grid container">
      <div class="row">
        <div class="fourteen wide centered center aligned column">
          <h1 class="ui header" style="font-size: 4em">Welcome to {{$gen->catering_name}}</h1><br>
          <div class="ui small images">
            <img src="image/Website/wel1.jpg">
            <img src="image/Website/wel2.jpg">
            <img src="image/Website/wel3.jpg">
          </div><br>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="ui vertical stripe segment">
    <div class="ui equal width stackable internally grid container">
      <div class="twelve wide centered column">
        <h1 class="ui horizontal divider header">Our Food</h1>
      </div>
      <div class="center aligned row">
        <div class="column">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><br><br>
          <a class="ui inverted big button green" href="/Menus">Our Menu</a>
        </div>
        <div class="column">
          <img class="ui centered medium large circular image" src="image/Website/wel1.jpg">
        </div>
      </div>
    </div>
  </div>

  <div class="ui vertical stripe segment">
    <div class="ui equal width stackable internally grid container">
      <div class="twelve wide centered column">
        <h1 class="ui horizontal divider header">Packages</h1>
      </div>
      <div class="center aligned row ">
        <div class="column">
          <img class="ui centered medium large circular image" src="image/Website/wel1.jpg">
        </div>
        <div class="column">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><br><br>
          <a class="ui inverted big button green" href="/Packages">View Details</a>
        </div>
      </div>
    </div>
  </div>

  <div class="ui vertical stripe quote segment">
    <div class="ui equal width stackable internally celled grid">
      <div class="center aligned row">
        <div class="column">
          <h3>"What a Company"</h3>
          <p>That is what they all say about us</p>
        </div>
        <div class="column">
          <h3>"I shouldn't have gone with their competitor."</h3>
          <p>
            <img src="assets/images/avatar/nan.jpg" class="ui avatar image"> <b>Nan</b> Chief Fun Officer Acme Toys
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="ui vertical stripe segment">
    <div class="ui text container">
      <h3 class="ui header">Breaking The Grid, Grabs Your Attention</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a class="ui large button">Read More</a>
      <h4 class="ui horizontal header divider">
        <a href="#">Case Studies</a>
      </h4>
      <h3 class="ui header">Did We Tell You About Our Bananas?</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a class="ui large button">I'm Still Quite Interested</a>
    </div>
  </div>
@endsection