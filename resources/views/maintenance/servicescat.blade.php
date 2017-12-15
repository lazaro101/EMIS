@extends('layouts.admin')

@section('title','Services')

@section('script')
<script type="text/javascript" src="{{ asset('js/services.js') }}"></script>
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
  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="shipping icon"></i>
      <div class="content">Services</div>
    </h1>
   <button class="large green ui labeled icon button" id="addservice">
      <i class="add square icon"></i>Add Service
    </button>
    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">  
   
      <div class="row">
        <div class="six wide column right floated">
          <form method="get" action="/Admin/Maintenance/Services">
          {{ csrf_field() }}
          <div class="ui small search">
            <div class="ui icon fluid input">
              <input class="prompt" type="text" name="srch" placeholder="Search services...">
              <i class="inverted circular link search icon"></i>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="table-cont">
      <table class="ui selectable fixed single line table sortable inverted compact">
        <thead class="full-width">
          <tr>
            <th class="six wide">Service Name</th>
            <th class="seven wide">Service Description</th>
            <th class="center aligned two wide">Action</th>
          </tr>
        </thead>
        <tbody>
        @if(count($service)==0)
          <tr>
            <td colspan="3"><center>No Results Found</center></td>
          </tr>
        @endif
        @foreach ($service as $service)
          <tr> 
            <td>{{ $service->services_name }}</td>
            <td>{{ $service->services_description }}</td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $service->services_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $service->services_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteServices" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addform">
  <div class="header">Add Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/addServices">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <div class="required field">
          <label>Service Name:</label>
          <input type="text" placeholder="Text Input..." name="serviceName">
        </div>
        <div class="required field">
          <label>Description:</label>
          <textarea rows="2" name="serviceDescription"></textarea>
        </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Service
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>
<div class="ui small modal" id="editform">
  <div class="header">Edit Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/editServices">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="serviceId">
    <input type="hidden" name="dupserviceName">
        <div class="required field">
          <label>Service Name:</label>
          <input type="text" placeholder="Text Input..." name="serviceName">
        </div>
        <div class="required field">
          <label>Description:</label>
          <textarea rows="2" name="serviceDescription"></textarea>
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