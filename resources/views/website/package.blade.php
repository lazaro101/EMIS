@extends('layouts.web')

@section('title','Packages')

@section('script')

@endsection

@section('style')
<style type="text/css">  
.ui.text.masthead {
  min-height: 150px;
  padding: 20px;
  background-image: url('{{ asset('image/Website/hdrbg.jpg') }}');
}
.ui.text h1.ui.header{
  margin-top: 1em;
  text-align: center;
  font-size: 3em;
  font-weight: bold;
  font-family: harrington;
}
</style>
@endsection

@foreach($gen as $gen)
@endforeach

@section('header')
<div class="ui container">
  <div class="ui large secondary pointing menu" style="border:none">
  <a href="/" class="header logo item"><img src="generalpics/blacklogo.png">{{$gen->catering_name}}</a>
    <div class="right item"> 
    <a class="toc item">
      <i class="sidebar icon"></i>
    </a>
    <a href="/" class="item">Home</a>
    <a href="/Menus" class=" item">Menus</a>
    <a href="/Package" class="active item">Packages</a>
    <a href="" class="item">About Us</a>
    <a href="/Contact-Us" class="item">Contact Us</a>
    </div>
  </div>
</div>

<div class="ui text masthead">
  <h1 class="ui header">
    Packages
  </h1>
</div>
@endsection

@section('content')
  <div class="ui vertical stripe segment">
    <div class="ui stackable grid container">
 <!--      <div class="row">
        <div class="fourteen wide centered column">
          <p>Find all time favorites and international dishes that are sure to please all types of guests. International cuisines, local Filipino dishes,even Halal menu are made available by request.</p>
          <h3>Our Serving</h3>
          <p>Guaranteed to satisfy even the biggest of appetites, our generous food servings will give you real value for your money.. even more!!!</p>
        </div>
      </div> -->


      <div class="three column row">
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 1</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 2</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 3</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="three column row">
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 4</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 5</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 6</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="three column row">
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 7</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 8</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Package 9</div>
                <div class="description">
                  A choice of 2 Beef/ 2 Pork/ 1 Fish/ 1 Drinks/ 1 Veggies
                </div>
              </div>
              <div class="ui bottom attached button">
                <!-- <i class="add icon"></i> -->
                More Details
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
