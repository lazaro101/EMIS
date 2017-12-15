@extends('layouts.admin')

@section('title','Package')

@section('script')
  <script type="text/javascript" src="{{ asset('js/package.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .table-cont tr th{
    color: white !important;
  }
  .table-cont {
    margin-top: 20px;
  }
  .content.table {
    color:white;
  }
</style>
@endsection

@section('content')
  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="cube icon"></i>
      <div class="content">Package</div>
    </h1>
    <button class="large green ui labeled icon button" id="addsub">
      <i class="add square icon"></i>Add Package
    </button>
    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui fixed single line small unstackable table inverted">
        <thead class="full-width">
          <tr>
            <th class="eight wide">Name</th>
            <th class="center aligned two wide">No. of Choices</th>
            <th class="three wide">Price</th>
            <th class="two wide">Status</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($package as $package)
          <tr>
            <td class="name">{{ $package->package_name }}</td>
            <td class="center aligned">{{ $package->subcount }}</td>
            <td>&#8369; {{number_format($package->package_price,2)}}</td>
            <td>
              <div class="ui fitted toggle checkbox">
                <input type="checkbox" value="{{$package->package_id}}" @if($package->package_status == 0) checked @endif> 
                <label></label>
              </div>
            </td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $package->package_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $package->package_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deletePackage" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

<div class="ui long modal" id="addform">
  <div class="header">Add Package</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/addPackage" id="addformform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Package Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="required field">
        <label>Inclusions:</label>
        <textarea rows="5" class="desc" name="inclusions">
Table
Table Cloth
Chairs
Tiffany Chair
Backdrop Design
Purified Water and tube ice for beverage
Full utensils and glassware set up
Courteous waiters in uniform</textarea>
      </div> 

      <h4 class="ui dividing header">Choice of Food:</h4>
      <div id="addform-menu">
       
      </div>
      <div class="field">
        <button class="ui teal labeled icon button" type="button" id="add">ADD<i class="add circle icon"></i></button>
        <input type="text" name="pckg" style="display: none">
      </div>
      
      <div class="six wide column required field">
        <label>Package Price:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
        <input type="number" min=0 placeholder="Amount" name="price">
          <div class="ui basic label">per head</div>
        </div>
      </div>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Package
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
</div>

<div class="ui long modal" id="editform">
  <div class="header">Edit Package</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/editPackage" id="editformform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="id">
      <div class="required field">
        <label>Package Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="required field">
        <label>Inclusions:</label>
        <textarea rows="5" class="desc" name="inclusions"></textarea>
      </div> 

      <h4 class="ui dividing header">Choice of Food:</h4>
      <div id="editform-menu">

      </div>
      <div class="field">
        <button class="ui teal labeled icon button" type="button" id="add">ADD<i class="add circle icon"></i></button>
          <input type="text" name="pckg" style="display: none">
      </div>
      <div class="six wide column required field">
        <label>Package Price:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
        <input type="number" min=0 placeholder="Amount" name="price">
          <div class="ui basic label">per head</div>
        </div>
      </div> 
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save Changes
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
</div>


<div class="ui basic modal">
  <div class="ui icon header">
    <i class="warning sign icon"></i>
    Delete item "<span class="item"></span>"?
  </div>
  <div class="content">
    <center>You are about to perform an action that can't be undone.</center>
  </div>
  <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      No
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Yes
    </div>
  </div>
</div>

<div class="ui floating big message msgbox hidden valmsg">
  <i class="close icon" id="close"></i>
  <div class="header">
  </div>
  <p></p>
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

 