@extends('layouts.admin')

@section('title','Food Order')

@section('script')
  <script type="text/javascript" src="{{ asset('js/foodorder.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>

<?php
  if(session('message')){
    echo "<script>$(document).ready(function(){";
    $message= session('message');
      if($message == 1) {
        echo "swal('Sucessfully saved!', ' ', 'success'); ";
      }
      if($message == 2) {
        echo "swal('Sucessfully updated!', ' ', 'success'); ";
      }
      if($message == 3) {
        echo "swal('Sucessfully deleted!', ' ', 'success'); ";
      }
    echo '});</script>';
  }
?>
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
      <i class="add to calendar icon"></i>
      <div class="content">Food Order</div>
    </h1>
    <a class="large green ui labeled icon button" href="/Admin/Transaction/Food-Order?orderdetails=new">
      <i class="add square icon"></i>Add Food Order
    </a>

    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact">
        <thead class="full-width">
          <tr>
            <th class="two wide">Food Order #</th>
            <th class="three wide">Delivery Date/Time</th>
            <th class="four wide">Name</th>
            <th class="two wide">Total</th>
            <th class="two wide">Status</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @foreach($tbldata as $tbldata)
          <tr>
            <td>#{{$tbldata->food_order_id}}</td>
            <td>{{date("m/d/y h:i a", strtotime( $tbldata->food_order_date.' '.$tbldata->food_order_time))}}</td>
            <td>{{$tbldata->client_fname.' '.$tbldata->client_lname}}</td>
            <td>&#8369; {{number_format($tbldata->total,2)}}</td>
            <td><label class="ui @if($tbldata->status ==  'Pending') yellow @elseif($tbldata->status ==  'Confirmed') green @elseif($tbldata->status ==  'Completed') blue @else red @endif label">{{$tbldata->status}}</label></td>
            <td class="center aligned">
              <a class="ui small inverted blue icon button edit" data-id="{{$tbldata->food_order_id}}" href="Food-Order?orderdetails=edit&id={{$tbldata->food_order_id}}"><i class="write icon"></i></a>
              <a class="ui small inverted negative icon button delbtn" data-id="{{$tbldata->food_order_id}}"><i class="trash bin icon"></i></a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
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

@endsection