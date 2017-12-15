@extends('layouts.web')

@section('title','Menus')

@section('script')
  <script type="text/javascript" src="{{asset('js/websitemenu.js')}}"></script>
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
.ui.vertical{
  margin-top: 0px !important;
}
.img{
  height: 250px !important;
  width: 100px;
}

.list {
  min-height: 200px;
}

#cate{
  font-size: 18px;
  margin: 6px;
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
    <a href="/Menus" class="active item">Menus</a>
    <a href="/Package" class="item">Packages</a>
    <a href="" class="item">About Us</a>
    <a href="/Contact-Us" class="item">Contact Us</a>
    </div>
  </div>
</div>

<div class="ui text masthead">
  <h1 class="ui header">
    Our Menu
  </h1>
</div>
@endsection

@section('content')
  <div class="ui vertical stripe segment">
    <div class="ui stackable grid container">
      <div class="row">
        <div class="fourteen wide centered column">
          <p>Find all time favorites and international dishes that are sure to please all types of guests. International cuisines, local Filipino dishes,even Halal menu are made available by request.</p>
          <h3>Our Serving</h3>
          <p>Guaranteed to satisfy even the biggest of appetites, our generous food servings will give you real value for your money.. even more!!!</p>
        </div>
      </div>

      <div class="row">
      <div class="eight wide centered column">
        <label id="cate">View Food by Category:</label>
        <select name="cat" class="ui search dropdown ctgry">
           <option value="">Select Category</option>
           @foreach ($category as $category)
              <option value="{{ $category->submenu_category_id }}">{{ $category->submenu_category_name }}</option>
            @endforeach
        </select>
      </div>
      </div>
      <div class = "list three column row">

      </div>

      </div>
    </div>
  </div>
@endsection

@section('forms')
<div class="ui long modal" id="addmenu">
  <div class="header">
    Menu
  </div>
  <div class="content">
    <table class="ui very basic table">
      <thead>
        <tr>
          <th class="two wide"></th>
          <th class="nine wide">Food Name</th>
          <th class="three wide">Category</th>
          <th class="two wide">Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($menu as $menu)
        <tr>
          <td class="center aligned">
            <div class="ui checkbox">
              <input type="checkbox" name="submenuid" class="checkbox" value="{{$menu->submenu_id}}">
              <label></label>
            </div>
          </td>
          <td class="name">{{$menu->submenu_name}}</td>
          <td>{{$menu->submenu_category_name}}</td>
          <td class="price">&#8369; {{number_format($menu->submenu_price,2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <form class="ui form" method="post" action="/addCateringServices/">
    {{csrf_field()}}

  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="button">Add Selected
      <i class="add icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form> 
  </div> 
</div>

  @if(session('message'))
  <div class="ui {{ session('message.type')}} floating big message msgbox scsmsg">
    <i class="close icon" id="close1"></i>
    <div class="header">
      {{ session('message.head')}}
    </div>
    <p>{{ session('message.text')}}</p>
  </div>
  @endif
@endsection