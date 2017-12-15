@extends('layouts.admin')

@section('title','Menu')

@section('script')
  <script type="text/javascript" src="{{ asset('js/menu.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .table-cont {
    margin-top: 20px;
  }
  .content.table {
    color:white;
  }
  .second.segment {
    min-height: 20em;
  }
  .first.segment {
    height: 20em;
    vertical-align: middle;
  }
  .fluid.action {
    margin-top: 8em;
  }
  .table-cont thead th {
    color: white !important;
  }
</style>
@endsection

@section('content')
  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="book icon"></i>
      <div class="content">Menu</div>
    </h1>
    <button class="large green ui labeled icon button" id="addsub">
      <i class="add square icon"></i>Add Menu
    </button>
    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui selectable fixed single line table compact inverted">
        <thead class="full-width">
          <tr>
            <th class="four wide">Menu</th>
            <th class="four wide">Package</th>
            <th class="five wide">Description</th>
            <!-- <th class="one wide">Status</th> -->
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @if(count($menu)==0)
          <tr>
            <td colspan="5"><center>No Results Found</center></td>
          </tr>
        @endif
          @foreach ($menu as $menu)
          <tr>
            <td>{{ $menu->menu_title }}</td>
            <td>{{ $menu->package_name }}</td>
            <td>{{ $menu->menu_description }}</td>
            <!-- <td class="collapsing centered">
              <div class="ui fitted toggle checkbox">
                <input type="checkbox"> <label></label>
              </div>
            </td> -->
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $menu->menu_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $menu->menu_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteMenu" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

<div class="ui long modal" id="addform">
  <div class="header">Add Menu</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/addMenu" id="addformform">
    {{csrf_field()}}
      <div class="required field">
        <label>Menu title:</label>
        <input type="text" placeholder="Text Input..." name="title">
      </div>
      <div class="field">
        <label>Description:</label>
        <textarea rows="4" class="desc" name="description"></textarea>
      </div>
      <br>
      <h4 class="ui header">Food Menu</h4>
      <div class="ui clearing divider"></div>
      
      <div class="ui center aligned first segment">
        <div class="ui fluid action">
          <select class="ui search dropdown pkg" id="selpkg" name="package">
            <option value="">Select Package</option>
          </select>
          <button type="button" class="ui blue button fixpkg">Choose</button>
        </div>
      </div>

      <div class="ui center aligned second segment transition hidden">
        <h2 class="ui header second">Package: <span class="name"></span></h2>
        <div id="addform-menu"></div>
      </div>

      <div class="field">
       <input type="text" name="mn" style="display: none">
      </div>

    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save Menu
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

<div class="ui long modal" id="editform">
  <div class="header">Update Menu</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/editMenu">
    {{csrf_field()}}
    <input type="hidden" name="id">
    <input type="hidden" name="duptitle">
      <div class="required field">
        <label>Menu title:</label>
        <input type="text" placeholder="Text Input..." name="title">
      </div>
      <div class="field">
        <label>Description:</label>
        <textarea rows="4" class="desc" name="description"></textarea>
      </div>
      <br>
      <h4 class="ui header">Food Menu</h4>
      <div class="ui clearing divider"></div>
      
      <div class="ui center aligned first segment transition hidden">
        <div class="ui fluid action">
          <select class="ui search dropdown pkg" id="selpkg" name="package">
            <option value="">Select Package</option>
          </select>
          <button type="button" class="ui blue button fixpkg">Choose</button>
        </div>
      </div>

      <div class="ui center aligned second segment">
        <h2 class="ui header second">Package: <span class="name"></span></h2>
        <div id="editform-menu"></div>
      </div>
      <p id="sample"></p>
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


<div class="ui basic modal">
  <div class="ui icon header">
    <i class="warning sign icon"></i>
    Delete this item?
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

 