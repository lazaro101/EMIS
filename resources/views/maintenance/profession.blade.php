@extends('layouts.admin')

@section('title','Profession')

@section('script')
<script type="text/javascript" src="{{ asset('js/profession.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .table-cont {
    margin-top: 20px;
  }
  .table-cont tr th {
    color: white !important;
  }
</style>
@endsection

@section('content')
  <div class="ui raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="black tie icon"></i>
      <div class="content">Profession</div>
    </h1>
    <button class="large green ui labeled icon button" id="addprof">
      <i class="add square icon"></i>Add Profession
    </button>
    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">  
   
      <div class="row">
        <div class="six wide column right floated">
          <form method="get" action="/Admin/Maintenance/Profession">
          {{ csrf_field() }}
          <div class="ui small search">
            <div class="ui icon fluid input">
              <input class="prompt" type="text" name="srch" placeholder="Search category...">
              <i class="inverted circular link search icon"></i>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="table-cont">
      <table class="ui selectable table inverted compact sortable">
        <thead class="full-width">
          <tr>
            <th class="nine wide">Description</th>
            <th class="center aligned two wide">No. of Staff</th>
            <th class="two wide"></th>
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
            <td>{{ $category->staff_profession_description }}</td>
            <td class="center aligned">{{ $category->subcount }}</td>
             <td class="center aligned">
              <button class="ui small inverted brown button" type="button" onclick="location.href='/Admin/Maintenance/Staff?profession={{ $category->staff_profession_id }}'">View Staff</button>
            </td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $category->staff_profession_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $category->staff_profession_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteProfession" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addform">
  <div class="header">Add Profession</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addProfession">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Profession Description:</label>
        <input type="text" placeholder="Text Input..." name="professionName">
      </div>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Profession
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editform">
  <div class="header">Edit Profession</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editProfession">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="professionId">
      <div class="required field">
        <label>Description:</label>
        <input type="text" placeholder="Text Input..." name="professionName">
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

<div class="ui basic modal">
  <div class="ui icon header">
    <i class="warning sign icon"></i>
    Delete selected item/s?
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
 