@extends('layouts.admin')

@section('title','Supplier')

@section('script')
<script type="text/javascript" src="{{ asset('js/supplier.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
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
  <div class="ui raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="credit card icon"></i>
      <div class="content">Supplier</div>
    </h1>
    <div class="large green ui labeled icon button addsup">
      <i class="add square icon"></i>Add Supplier
    </div>

    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact">
        <thead class="full-width">
          <tr>
            <th class="two wide">Supplier Name</th>
            <th class="two wide">Contact</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($list as $list)
          <tr>
            <td class="name">{{$list->supplier_name}}</td>
            <td>{{$list->supplier_contact}}</td>
            <td class="center aligned">
              <div class="ui small inverted blue icon button edit" data-id="{{$list->supplier_id}}"><i class="pencil icon"></i></div>
              <div class="ui small inverted negative icon button delete" data-id="{{$list->supplier_id}}"><i class="trash bin icon"></i></div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteSupplier" id="delete">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

<div class="ui small modal" id="addform">
  <div class="header">Add Supplier</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addSupplier">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Supplier Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="required field">
        <label>Contact:</label>
        <input type="number" placeholder="" name="contact">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Supplier
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editform">
  <div class="header">Edit Supplier</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editSupplier">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="id">
      <div class="required field">
        <label>Supplier Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="required field">
        <label>Contact:</label>
        <input type="number" placeholder="" name="contact">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save changes
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="warning sign icon"></i>
      Delete supplier "<span class="item"></span>"?
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