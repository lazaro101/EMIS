@extends('layouts.admin')

@section('title','Event Reservations')

@section('script')
  <script type="text/javascript" src="{{ asset('js/eventreservation.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
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
      <i class="add to calendar icon"></i>
      <div class="content">Event Reservations</div>
    </h1>
    <a class="large green ui labeled icon button" href="/Admin/Transaction/Event-Reservation?eventdetails=new">
      <i class="add square icon"></i>Create Reservation
    </a>

    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">  
   
      <div class="centered row">
        <div class="column">
          <div class="ui secondary vertical segment">
            <div class="ui container">

              <form class="ui small form" style="margin: 0em 1em" method="get" action="/Admin/Transaction/Event-Reservation">
              {{ csrf_field()}}
                <div class="four fields">
                  <div class="field">
                    <label>Event Date:</label>
                    <div class="ui calendar">
                      <div class="ui input left icon">
                        <i class="calendar icon"></i>
                        <input type="text" placeholder="Date" name="date" value="@if(isset($_GET['date'])){{$_GET['date']}}@endif">
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Status:</label>
                    <div class="ui fluid selection dropdown status">
                      <input type="hidden" name="status" value="@if(isset($_GET['status'])){{$_GET['status']}}@else{{'All'}}@endif">
                      <i class="dropdown icon"></i>
                      <span class="default text">Select</span>
                      <div class="menu">
                        <div class="item" data-value="All">
                          <div class="ui empty circular label"></div>
                          All
                        </div>
                        <div class="item" data-value="Created">
                          <div class="ui yellow empty circular label"></div>
                          Created
                        </div>
                        <div class="item" data-value="Submitted">
                          <div class="ui orange empty circular label"></div>
                          Submitted
                        </div>
                        <div class="item" data-value="Booked">
                          <div class="ui green empty circular label"></div>
                          Booked
                        </div>
                        <div class="item" data-value="Completed">
                          <div class="ui blue empty circular label"></div>
                          Completed
                        </div>
                        <div class="item" data-value="Cancelled">
                          <div class="ui red empty circular label"></div>
                          Cancelled
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Event name:</label>
                    <div class="ui icon input">
                      <input type="text" placeholder="Search..." name="name" value="@if(isset($_GET['name'])){{$_GET['name']}}@endif"> 
                      <i class="circular search link icon"></i>
                    </div>
                  </div>
                  <div class="field">
                    <label>&nbsp;</label>
                    <button type="submit" class="ui small button">Apply Filter</button>
                    <a href="Event-Reservation" class="ui small reset button">Reset Filter</a>
                  </div>
                </div>
              </form>
            </div>
          </div>  
        </div>
      </div>

    </div>

    <div class="table-cont">
      <table class="ui sortable table small inverted unstackable compact">
        <thead class="full-width">
          <tr>
            <th class="one wide"></th>
            <th class="two wide">Event Date & Time</th>
            <th class="three wide">Event Name</th>
            <th class="two wide">PAX</th>
            <th class="two wide">Status</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @if(count($events)==0)
          <tr>
            <td colspan="6"><center>No Results Found</center></td>
          </tr>
        @endif
        @foreach($events as $events)
          <tr>
            <td class="center aligned">
            <a target="_blank"  href="/Admin/Transaction/Event-Reservation?eventdetails=eventpdf&id={{$events->event_reservation_id}}" class="ui small red vertical inverted animated button pdf" tabindex="0">
              <div class="visible content"><i class="file pdf outline icon"></i></div>
              <div class="hidden content"><i class="download icon"></i></div>
            </a>
            </td>
            <td>{{date("m/d/y h:i a", strtotime( $events->event_date.' '.$events->event_time))}}</td>
            <td class="name">{{ $events->event_name }}</td>
            <td>{{ $events->event_guest_count }}</td>
            <td class="center aligned">
              <label class="ui @if($events->status=='Created') yellow @elseif($events->status=='Submitted') orange @elseif($events->status=='Booked') green @elseif($events->status=='Completed') blue @else red @endif label">{{ $events->status }}</label>
            </td>
            <td class="center aligned">
              <a class="ui small inverted blue icon button edit" href="/Admin/Transaction/Event-Reservation?eventdetails=edit&id={{$events->event_reservation_id}}"><i class="write icon"></i></a>
              <a class="ui small inverted negative icon button delete" data-id="{{$events->event_reservation_id}}"><i class="trash bin icon"></i></a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="get" action="/deleteReservation" id="deleteReservation">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="warning sign icon"></i>
      Delete Event "<span class="item"></span>"?
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