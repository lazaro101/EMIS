@extends('layouts.admin')

@section('title','Event Inquiries')

@section('script')
  <script type="text/javascript" src="{{ asset('js/eventinquiries.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .head {
    margin-top: 20px;
  }
  .table-cont tr th{
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
      <i class="mail icon"></i>
      <div class="content">Event Inquiries</div>
    </h1>
    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">  
   
      <div class="centered row">
        <div class="column">
          <div class="ui secondary vertical segment">
            <div class="ui container">

              <form class="ui small form" style="margin: 0em 1em" method="get" action="/Admin/Transaction/Event-Inquiries">
              {{ csrf_field()}}
                <div class="four fields">
                  <div class="field">
                    <label>Event Date:</label>
                    <div class="ui calendar">
                      <div class="ui input left icon">
                        <i class="calendar icon"></i>
                        <input type="text" placeholder="Date" name="eventdate" value="@if(isset($_GET['eventdate'])){{$_GET['eventdate']}}@endif">
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
                        <div class="item"" data-value="Approved">
                          <div class="ui green empty circular label"></div>
                          Approved
                        </div>
                        <div class="item"" data-value="Pending">
                          <div class="ui yellow empty circular label"></div>
                          Pending
                        </div>
                        <div class="item"" data-value="Cancelled">
                          <div class="ui red empty circular label"></div>
                          Cancelled
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Name:</label>
                    <div class="ui icon input">
                      <input type="text" placeholder="Search..." name="name" value="@if(isset($_GET['name'])){{$_GET['name']}}@endif">
                      <i class="circular search link icon"></i>
                    </div>
                  </div>
                  <div class="field">
                    <label>&nbsp;</label>
                    <button type="submit" class="ui small button appfltr">Apply Filter</button>
                    <a href="Event-Inquiries" class="ui small button">Reset Filter</a>
                  </div>
                </div>
                <div class="field">
                  <div class="ui accordion">
                    <div class="@if(!empty($_GET['date']) or !empty($_GET['occassion'])) or !empty($_GET['location'])) active @endif title">
                      <i class="dropdown icon"></i>
                      More filter:
                    </div>
                    <div class="@if(!empty($_GET['date']) or !empty($_GET['occassion'])) or !empty($_GET['location'])) active @endif content">
                      <div class="four fields">
                        <div class="field">
                          <label>Date:</label>
                          <div class="ui calendar">
                            <div class="ui input left icon">
                              <i class="calendar icon"></i>
                              <input type="text" placeholder="Date" name="date" value="@if(isset($_GET['date'])){{$_GET['date']}}@endif">
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label>Occassion:</label>
                          <div class="ui icon input">
                            <input type="text" placeholder="Search..." name="occassion" value="@if(isset($_GET['occassion'])){{$_GET['occassion']}}@endif">
                            <i class="circular search link icon"></i>
                          </div>
                        </div>
                      <!--   <div class="field">
                          <label>Location:</label>
                          <div class="ui icon input">
                            <input type="text" placeholder="Search..." name="location" value="@if(isset($_GET['location'])){{$_GET['location']}}@endif">
                            <i class="circular search link icon"></i>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </form>

            </div>
          </div>  
        </div>
      </div>
    </div>

    <div class="table-cont">
      <table class="ui small sortable single line table inverted">
        <thead class="full-width">
          <tr>
            <th class="two wide">Date</th>
            <th class="two wide">Event Date & Time</th>
            <th class="two wide">Name</th>
            <th class="two wide">Contact</th>
            <th class="two wide">Email</th>
            <th class="one wide">PAX</th>
            <th class="two wide">Occassion</th>
            <th class="two wide">Status</th>
            <th class="two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @if(count($inquiry)==0)
          <tr>
            <td colspan="10"><center>No Results Found</center></td>
          </tr>
        @endif
        <form method="post" action="/deleteSubmenuCategory" class="delbtn">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        @foreach ($inquiry as $inquiry)
          <tr> 
            <td>{{ date("m/d/y", strtotime($inquiry->event_inquiry_date)) }}</td>
            <td>{{ date("m/d/y", strtotime($inquiry->event_date)).'  '.date("h:i A", strtotime($inquiry->event_time))}}</td>
            <td>{{ $inquiry->client_fname }} {{ $inquiry->client_lname }}</td>
            <td>{{ $inquiry->client_contact1 }}</td>
            <td>{{ $inquiry->client_email }}</td>
            <td>{{ $inquiry->event_guest_count }}</td>
            <td>{{ $inquiry->event_occassion }}</td>
            <td class="center aligned">
              <label class="ui @if($inquiry->status == 'Pending') yellow @endif @if($inquiry->status == 'Approved') green @endif @if($inquiry->status == 'Cancelled') red @endif label">
                {{ $inquiry->status}}</label>
            </td>
            <td class="center aligned" data-id="{{ $inquiry->event_inquiry_id }}">
              <div class="ui icon inverted green button edit"><i class="pencil icon"></i></div>
              <!-- <div class="ui icon inverted blue button info"><i class="circle info icon"></i></div> -->
              <div class="ui icon inverted negative button delete"><i class="trash bin icon"></i></div>
          <!--     <div class="ui teal small buttons">
                <div class="ui button">Save</div>
                <div class="ui floating dropdown icon button">
                  <i class="dropdown icon"></i>
                  <div class="menu">
                    <div class="item"><i class="edit icon"></i> Edit Post</div>
                    <div class="item"><i class="delete icon"></i> Remove Post</div>
                    <div class="item"><i class="hide icon"></i> Hide Post</div>
                  </div>
                </div>
              </div> -->
            </td>
          </tr>
        @endforeach
        </tbody>
        </form>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
  <div class="ui small modal" id="editform">
    <div class="header">Edit Status</div>
    <div class="content">
    <form class="ui form" method="post" action="/editInquiry">
    {{ csrf_field() }}
    <input type="hidden" name="id">
      <div class="ten wide field">
        <label>Status</label>
        <div class="ui fluid selection dropdown status">
          <input type="hidden" name="status">
          <i class="dropdown icon"></i>
          <span class="default text">Select</span>
          <div class="menu">
            <div class="item"" data-value="Approved">
              <div class="ui green empty circular label"></div>
              Approved
            </div>
            <div class="item"" data-value="Pending">
              <div class="ui yellow empty circular label"></div>
              Pending
            </div>
            <div class="item"" data-value="Cancelled">
              <div class="ui red empty circular label"></div>
              Cancelled
            </div>
          </div>
        </div>
      </div>
      <div class="ui error message"></div>
    </div>
    <div class="actions">
      <button class="ui positive submit button" type="submit">Save</button>
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
  <form id="deleteform" method="post" action="/deleteInquiry">
    {{csrf_field()}}
    <input type="hidden" name="id">
  </form>
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