@extends('layouts.admin')

@section('title','Checklist')

@section('script')
<script type="text/javascript" src="{{ asset('js/checklist.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
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
      <div class="content">Checklist</div>
    </h1>

    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact">
        <thead class="full-width">
          <tr>
            <th class="two wide">Date & Time</th>
            <th class="two wide">Event Name</th>
            <th class="two wide">Status</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($chklst as $chk)
          <tr>
            <td>{{date("m/d/y h:i A", strtotime($chk->event_date.' '.$chk->event_time))}}</td>
            <td>{{$chk->event_name}}</td>
            <td class="center aligned">
              <label class="ui @if($chk->checklist_status == 'Unchecked') yellow @elseif($chk->checklist_status == 'Pulled out') green @else blue @endif label">{{$chk->checklist_status}}</label>
            </td>
            <td class="center aligned">
              <button type="button" class="ui small inverted yellow icon button out" data-id="{{$chk->catering_checklist_id}}" @if($chk->checklist_status == 'Pulled out' || $chk->checklist_status == 'Returned') disabled @endif>Out</button>
              <button class="ui small inverted green icon button in" data-id="{{$chk->catering_checklist_id}}" @if($chk->checklist_status == 'Returned') disabled @endif>In</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<div class="ui long modal" id="checklist">
  <div class="header">Equipment Checklist</div>
    <div class="content" style="min-height: 500px"> 
    <form class="ui form" method="post" action="/saveChecklist">
    {{ csrf_field() }}
    <input type="hidden" name="ccid">
      <div class="fields">
        <div class="ten wide field">
          <select id="equipSelect" class="ui search multiple dropdown esel" multiple="">
            <option value="">Equipment</option>
            @foreach($elist as $elist)
            <option value="{{$elist->equipment_inventory_id}}">{{$elist->equipment_inventory_name}} ({{$elist->equipment_inventory_qty}})</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <div class="ui primary button add" id="addCart">Add</div>
        </div>
      </div>
      <table class="ui very basic table">
        <thead>
          <tr>
            <th class="six wide">Equipment</th>
            <th class="four wide">Stock</th>
            <th class="four wide">Out</th>
            <th class="two wide"></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon addbtn" type="submit"><i class="pencil icon"></i>Save</button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

<div class="ui long modal" id="inlist">
  <div class="header">Equipment Checklist</div>
    <div class="content" style="min-height: 400px"> 
    <form class="ui form" method="post" action="/saveChecklist">
    <input type="hidden" name="ccid">
    {{ csrf_field() }}
      <!-- <div class="ui primary button">Mark all as checked</div> -->
      <table class="ui very basic table">
        <thead>
          <tr>
            <th class="six wide">Equipment</th>
            <th class="two wide">Out</th>
            <th class="four wide">In</th>
            <th class="four wide">Lost/Damage</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon addbtn" type="submit"><i class="pencil icon"></i>Save</button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

<form method="post" action="/deleteFoodOrder" id="deleteorder">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

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