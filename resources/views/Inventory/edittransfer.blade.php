@extends('layouts.admin')

@section('title','Purchase')

@section('script')
<script type="text/javascript" src="{{ asset('js/addtransfers.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
@endsection

@section('style')

@endsection

@section('content')
@foreach($invtr as $invtr)
<div class="ui basic segment content">
  <form class="ui form main" method="post" action="/editTransfer">
  {{ csrf_field() }}
  <input type="hidden" name="trid" value="{{$invtr->inventory_transfers_id}}">
    <div class="ui stackable grid">
      <div class="row">
        <h2 class="ui right floated header">
          <i class="calendar outline icon"></i>
          <div class="content">Edit Purchase</div>
        </h2>
      </div>

      <div class="row">
        <div class="ten wide column">
          <div class="ui segment">
            <h4 class="ui horizontal divider header"><i class="calendar icon"></i>Equipments</h4>
            <div class="ui blue button browse">Browse equipments</div>
            <table class="ui very basic table trtbl">
              <thead>
                <tr>
                  <th class="seven wide"></th>
                  <th class="four wide">Unit value</th>
                  <th class="four wide">Quantity ordered</th>
                  <th class="one wide"></th>  
                </tr>
              </thead>
              <tbody>
                @foreach($trdet as $det)
                <tr>
                  <td>{{$det->equipment_inventory_name}}<input type="hidden" name="eqid[]" value="{{$det->equipment_inventory_id}}"></td>
                  <td><div class="field"><input type="number" name="price[]" value="{{$det->unit_value}}"></div></td>
                  <td><div class="field"><input type="number" name="qty[]" value="{{$det->qty}}"></div></td>
                  <td class="center aligned"><i class="remove icon"></i></td>
                </tr>
                @endforeach
              </tbody>
            </table>


          </div>
        </div>
        <div class="six wide column">
          <div class="row">
            <div class="ui segment">
              <h4 class="ui horizontal divider header"><i class="info icon"></i>Information</h4>
              <div class="required field">
                <label>Supplier:</label>
                <input type="text" name="supplier" value="{{$invtr->supplier_name}}">
              </div>
              <div class="field">
                <label>Date Received:</label>
                <div class="ui calendar date">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input placeholder="Date" name="date" value="{{$invtr->date_received}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <div class="ui error message"></div>
        </div>
      </div>
      
      <div class="ui divider"></div>

      <div class="row">
        <div class="column">
          <div class="ui basic segment">
            <a class="ui black reset deny button" href="/Admin/Inventory/Transfers"><i class="arrow left icon"></i>Back</a>
            <button class="ui positive submit button labeled icon right floated addbtn" type="submit">Save Purchase
            <i class="pencil icon"></i></button>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('forms')
<div class="ui long modal" id="addequipment">
  <div class="header">Equipment List</div>
  <div class="content">

    <table class="ui fixed single line unstackable very basic table">
      <thead>
        <tr> 
          <th class="two wide"></th>
          <th class="seven wide">Equipment</th>
          <th class="seven wide">Type</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
  </div>
</div>

@endsection
@endforeach