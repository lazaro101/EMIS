@extends('layouts.admin')

@section('title','Purchase')

@section('script')
<script type="text/javascript" src="{{ asset('js/transfers.js') }}"></script>
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
      <div class="content">Purchase</div>
    </h1>
    <a class="large green ui labeled icon button" href="/Admin/Inventory/Transfers?form=new">
      <i class="add square icon"></i>Add Purchase
    </a>

    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact">
        <thead class="full-width">
          <tr>
            <th class="two wide">Purchase #</th>
            <th class="two wide">Created</th>
            <th class="two wide">Date Received</th>
            <th class="four wide">Supplier</th>
            <th class="two wide">Quantity</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invtr as $inv)
          <tr>
            <td class="name">#{{$inv->inventory_transfers_id}}</td>
            <td>{{date("m/d/y h:i A", strtotime($inv->date))}}</td>
            <td>{{date("M d Y", strtotime($inv->date_received))}}</td>
            <td>{{$inv->supplier_name}}</td>
            <td class="center aligned">{{$inv->quantity}}</td>
            <td class="center aligned">
           <!--    <a class="ui small inverted blue icon button" href="/Admin/Inventory/Transfers?form=edit&id={{$inv->inventory_transfers_id}}"><i class="pencil icon"></i></a> -->
              <a class="ui small inverted negative icon button delete" data-id="{{$inv->inventory_transfers_id}}"><i class="trash bin icon"></i></a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteTransfer" id="delete">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="warning sign icon"></i>
      Delete transfer "<span class="item"></span>"?
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