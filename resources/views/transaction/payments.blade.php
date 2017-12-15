@extends('layouts.admin')

@section('title','Payments')

@section('script')
<script type="text/javascript" src="{{ asset('js/payments.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script> -->
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
      <div class="content">Payments</div>
    </h1>
    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact main">
        <thead class="full-width">
          <tr>
            <!-- <th class="one wide"></th> -->
            <th class="two wide">Invoice #</th>
            <th class="four wide">Event Name</th>
            <th class="four wide">Client Name</th>
            <th class="two wide">Balance</th>
            <th class="two wide">Total</th>
            <th class="two wide">Status</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pmt as $pmt)
          <tr>
          <!--   <td class="center aligned">
            <a target="_blank" href="" class="ui small red vertical inverted animated button pdf" tabindex="0">
              <div class="visible content"><i class="file pdf outline icon"></i></div>
              <div class="hidden content"><i class="download icon"></i></div>
            </a>
            </td> -->
            <td>#{{$pmt->payment_id}}</td>
            <td>{{$pmt->event_name}}</td>
            <td>{{$pmt->client_fname.' '.$pmt->client_lname}}</td>
            <td>&#8369; {{number_format($pmt->grand_total - $pmt->amt_paid,2)}}</td>
            <td>&#8369; {{number_format($pmt->grand_total,2)}}</td>
            <td class="center aligned">
              <label class="ui @if($pmt->payment_status == 'Pending') yellow @elseif($pmt->payment_status == 'Partial') orange @elseif($pmt->payment_status == 'Paid') blue @else red @endif label">{{$pmt->payment_status}}</label>
            </td>
            <td class="center aligned">
              <a class="ui small inverted blue icon button edit" data-id="{{$pmt->payment_id}}"><i class="write icon"></i></a>
              <!-- <a class="ui small inverted negative icon button"><i class="trash bin icon"></i></a> -->
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

  <div class="ui long modal">
    <div class="header">Payment Details</div>
    <div class="content">
      <form class="ui form" method="post" action="/Pay">
      {{csrf_field()}}
      <input type="hidden" name="pid">
      <div class="ui grid">
        <div class="two column row">
          <div class="column">
            <div class="inline field">
              <label>Invoice #: </label>
              <p class="pid"></p>
            </div>
            <div class="field">
              <label>Amount: </label>
              <input type="number" name="amount">
            </div>
            <div class="ui primary right floated button full">Pay full</div>
          </div>
          <div class="column">
            <table class="ui very basic small compact table payment">
              <tr class="right aligned">
                <td>Food and Services:</td>
                <td class="menu">&#8369; 0.00</td>
              </tr>
              <tr class="right aligned">
                <td>Food Addons: </td>
                <td class="addons">&#8369; 0.00</td>
              </tr>
              <tr class="right aligned">
                <td>Venue:</td>
                <td class="venue">&#8369; 0.00</td>
              </tr>
              <tr class="right aligned">
                <td>Other Additional Charges:</td>
                <td class="services">&#8369; 0.00</td>
              </tr>
              <tr class="right aligned">
                <td>Extra Cost/s:</td>
                <td class="extra">&#8369; 0.00</td>
              </tr>
              <tr class="right aligned">
                <td>Total:</td>
                <td class="total">&#8369; 0.00}</td>
              </tr>
              <tr class="right aligned">
                <td>Balance:</td>
                <td class="balance">&#8369; 0.00</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="actions">
      <div class="ui buttons">
        <button class="ui positive button labeled icon active" type="submit">Save
        <i class="pencil icon"></i></button>
        <div class="or"></div>
        <button class="ui black deny button" type="reset">Cancel</button>
      </div>
    </div>
    </form>
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