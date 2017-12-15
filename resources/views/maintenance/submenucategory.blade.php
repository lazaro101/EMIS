@extends('layouts.admin')

@section('title','Submenu Category')

@section('script')
  <script type="text/javascript" src="{{ asset('js/submenucategory.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .head {
    margin-top: 20px;
  } 
  .table-cont tr th {
    color: white !important;
  }
  .table-cont {
    margin-top: 20px;
  }
</style>
@endsection

@section('content')
  <div class="ui raised basic segment content" id="example1">
    <div class="ui sticky">
    <h1 class="ui right floated header">
      <i class="tags icon"></i>
      <div class="content">Submenu Category</div>
    </h1>
    <button class="large green ui labeled icon button" id="addctgry">
      <i class="add square icon"></i>Add Category
    </button>
    </div>
    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">  
   
      <div class="row">

        <div class="six wide column right floated">
          <form method="get" action="/Admin/Maintenance/SubmenuCategory">
          <input type="hidden" name="_token" value="{{ csrf_token()}}">
          <div class="ui small search">
            <div class="ui icon fluid input">
              <input class="prompt" type="text" name="srch" placeholder="Search Category by name..." value="@if(isset($_GET['srch'])){{$_GET['srch']}}@endif">
              <i class="inverted circular link search icon"></i>
            </div>
          </div>
          </form>
        </div>

      </div>
    </div>

    <div class="table-cont">
      <table class="ui sortable table inverted compact">
        <thead class="full-width">
          <tr>
            <th class="ten wide">Category</th>
            <th class="center aligned two wide">No. of foods</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @if(count($category)==0)
          <tr>
            <td colspan="3"><center>No Results Found</center></td>
          </tr>
        @endif
        @foreach ($category as $category)
          <tr> 
            <td>{{ $category->submenu_category_name }}</td>
            <td class="center aligned">{{ $category->subcount }}</td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $category->submenu_category_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $category->submenu_category_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteSubmenuCategory" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addform">
  <div class="header">Add Food Category</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addSubmenuCategory" name="addform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Category Name:</label>
        <input type="text" placeholder="Text Input..." name="categoryName" class="addname">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Category
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editform">
  <div class="header">Edit Food Category</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editSubmenuCategory">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="categoryId" class="id">
      <div class="required field">
        <label>Category Name:</label>
        <input class="name" type="text" placeholder="Text Input..." name="categoryName">
      </div>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button right labeled icon active addbtn" type="submit">Save Changes
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

@if (count($errors) > 0)
  <div class="ui error floating medium message msgbox valmsg" style="left:38em;top:3em">
    <i class="close icon" id="close"></i>
    <div class="header">Error Adding/Modfying Category!</div>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
  </div>
@endif

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