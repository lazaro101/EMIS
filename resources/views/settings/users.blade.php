@extends('layouts.admin')

@section('title','Users')

@section('script')
<script type="text/javascript" src="{{ asset('js/users.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .head {
    margin-top: 20px;
  } 
  .table-cont thead th {
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
      <i class="users icon"></i>
      <div class="content">Users</div>
    </h1>
    <button class="large green ui labeled icon button" id="addctgry">
      <i class="add square icon"></i>Add User
    </button>
    <div class="ui clearing divider"></div>
    
    <div class="table-cont">
      <table class="ui selectable table inverted compact">
        <thead class="full-width">
          <tr>
            <th class="five wide">Name</th>
            <th class="four wide">Username</th>
            <th class="four wide">Email</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @if(count($user)==0)
          <tr>
            <td colspan="4"><center>No Results Found</center></td>
          </tr>
        @endif
        @foreach ($user as $user) 
          <tr>
            <td>{{ $user->display_name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $user->id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $user->id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteUsers" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

<div class="ui small modal" id="addform">
  <div class="header">Add User</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addUsers" name="addform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="field">
        <label>Enter Username:</label>
        <input type="text" name="username" placeholder="Username">
      </div>
      <div class="two fields">
        <div class="field">
          <label>Enter Password:</label>
          <input type="password" name="password1" placeholder="Password">
        </div>
        <div class="field">
          <label>Re-Enter Password:</label>
          <input type="password" name="password2" placeholder="Password">
        </div>
      </div>
      <div class="field">
        <label>Email:</label>
        <input type="text" name="email" placeholder="email">
      </div>
      <div class="field">
        <label>Display Name:</label>
        <input type="text" name="disname" placeholder="Name">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add User
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

<div class="ui small modal" id="editform">
  <div class="header">Add User</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editformUsers" name="editform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="id">
      <div class="field">
        <label>Enter Username:</label>
        <input type="text" name="username" placeholder="Username">
      </div>
      <div class="two fields">
        <div class="field">
          <label>Enter Password:</label>
          <input type="password" name="password1" placeholder="Password">
        </div>
        <div class="field">
          <label>Re-Enter Password:</label>
          <input type="password" name="password2" placeholder="Password">
        </div>
      </div>
      <div class="field">
        <label>Email:</label>
        <input type="text" name="email" placeholder="email">
      </div>
      <div class="field">
        <label>Display Name:</label>
        <input type="text" name="disname" placeholder="Name">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add User
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
 