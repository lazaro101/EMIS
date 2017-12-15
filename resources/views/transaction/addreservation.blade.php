@extends('layouts.admin')

@section('title','Event Reservations')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.print.css') }}" media="print">
<!-- <script src="{{ asset('Semantic/dist/fullcalendar/lib/jquery.min.js') }}"></script> -->
<script src="{{ asset('Semantic/dist/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('Semantic/dist/fullcalendar/fullcalendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.css') }}">
<script type="text/javascript" src="{{ asset('js/addreservation.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  #addmenu .content, #addservices .content{
    min-height: 500px;
  }
  #calendar{
    min-height: 500px;
  }
  #addservices .icon,#addservices table.all, #addservices table.type {
    cursor:pointer;
  }
</style>
@endsection

@section('content')
<div class="ui basic segment content">
  <form class="ui form main" method="post" action="/addReservation">
  {{ csrf_field() }}
  <input type="hidden" name="eventcount">
    <div class="ui grid">
      <div class="row">
        <h2 class="ui right floated header">
          <i class="calendar outline icon"></i>
          <div class="content">Create Reservation</div>
        </h2>
      </div>

      <div class="centered row">
        <div class="ui header">Current Status: <label class="ui large yellow label">Created</label></div>
      </div>
      <div class="centered row">
        <div class="ui mini steps">
          <div class="active step">
            <i class="add square icon"></i>
            <div class="content">
              <div class="title">Created</div>
              <div class="description">Fill up form.</div>
            </div>
          </div>
          <div class="step">
            <i class="file outline icon"></i>
            <div class="content">
              <div class="title">Submitted</div>
              <div class="description">Submit details.</div>
            </div>
          </div>
          <div class="step">
            <i class="checked calendar icon"></i>
            <div class="content">
              <div class="title">Booked</div>
              <div class="description">Approved and booked.</div>
            </div>
          </div>
        </div>
      </div>

      @if(isset($event) || $event != "")

      <div class="two column row">
        <div class="column">
          <div class="ui segment">
            <h4 class="ui horizontal divider header"><i class="calendar icon"></i>Event Details</h4>
            <div class="two fields">
              <div class="inline field">
                <label>Invoice #:</label>
              </div>
              <div class="field">
                <div class="ui basic purple right floated vertical animated button checked">
                  <div class="visible content"><i class="checked calendar icon"></i>Check calendar</div>
                  <div class="hidden content">
                    <i class="right arrow icon"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="required field">
              <label>Event Name:</label>
              <input type="text" name="eventname">
            </div>
            <div class="two fields">
              <div class="required field">
                <label>Event Date:</label>
                <div class="ui calendar date">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input placeholder="Date" name="eventdate" value="@if(!isset($event->event_date)){{date_format(date_create('now'),'Y-m-d')}}@else {{$event->event_date}} @endif">
                  </div>
                </div>
              </div>
              <div class="required field">
                <label>Event Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="eventtime">
                  </div>
                </div>
              </div>
            </div>
            <div class="three fields">
              <div class="field">
                <label>Setup Time:</label>
                <div class="ui calendar time set">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="setuptime" value="{{ date_format(date_create('15:00'),'H:i:s') }}">
                  </div>
                </div>
              </div>
              <div class="field">
                <label>End Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="endtime" value="{{ date_format(date_create('18:00'),'H:i:s') }}">
                  </div>
                </div>
              </div>
              <div class="required field">
                <label>Guest Count:</label>
                <input type="number" name="guestcount" value="@if(isset($event->event_guest_count)){{$event->event_guest_count}}@endif">
              </div>
            </div>
            <div class="two fields">
              <div class="required field">
                <label>Occassion:</label>
                <input type="text" placeholder="Input..." name="occassion" value="@if(isset($event->event_occassion)) {{$event->event_occassion}} @endif">
              </div>
              <div class="field">
                <label>Motif:</label>
                <input type="text" placeholder="Input..." name="motif">
              </div>
            </div>
            <div class="field">
              <label>Event Setup Notes:</label>
              <textarea rows="3" name="eventnotes"></textarea>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="row">
            <div class="ui segment">
              <h4 class="ui horizontal divider header"><i class="user icon"></i>Client Details</h4>
              <div class="two fields">
                <div class="required field">
                  <label>First Name:</label>
                  <input type="text" placeholder="Input..." name="fname" value="@if(isset($event->client_fname)){{$event->client_fname}}@endif">
                </div>
                <div class="required field">
                  <label>Last Name:</label>
                  <input type="text" placeholder="Input..." name="lname" value="@if(isset($event->client_lname)){{$event->client_lname}}@endif">
                </div>
              </div>
              <div class="two fields">
                <div class="required field">
                  <label>Cellphone Number:</label>
                  <input type="text" placeholder="Primary Number..." name="cpnum1" value="@if(isset($event->client_contact1)){{$event->client_contact1}}@endif">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="cpnum2">
                </div>
              </div>
              <div class="two fields">
                <div class="field">
                  <label>Telephone:</label>
                  <input type="text" placeholder="Primary Number..." name="telnum1">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="telnum2">
                </div>
              </div>
              <div class="required field">
                <label>Email:</label>
                <input type="text" placeholder="Input..." name="email" value="@if(isset($event->client_email)){{$event->client_email}}@endif">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="column">              
              <div class="ui segment">
                <h4 class="ui horizontal divider header"><i class="map icon"></i>Location</h4>
                <div class="field">
                  <div class="ui checkbox location">
                    <input type="checkbox" name="loctype" value="1">
                    <label>Choose on suggested location?</label>
                  </div>
                </div>
                <div class="ui form location">
                  <div class="sixteen wide field">
                    <div class="first side">
                      <div class="required field">
                        <label>Address:</label>
                        <input type="text" name="venue" value="">
                      </div>
                    </div>
                    <div class="second side transition hidden">
                      <div class="two fields">
                        <div class="twelve wide required field">
                          <label>Location:</label>
                          <div class="ui selection dropdown drpdwn" tabindex="0">
                            <input type="hidden" name="location" value="">
                            <i class="dropdown icon"></i>
                            <div class="default text">Location</div>
                            <div class="menu" tabindex="-1">
                            @foreach($location as $loc)
                              <div class="item" data-value="{{$loc->location_id}}">{{$loc->location_name}}</div>
                            @endforeach
                            </div>
                          </div>  
                        </div>
                        <div class="four wide required field">
                          <label>Hour/s:</label>
                          <input type="number" name="hrs" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @endif

      <div class="row">
        <div class="column">
          <div class="ui grid segment">
            <div class="row">
              <div class="column">
                <h4 class="ui horizontal divider header"><i class="list icon"></i>Catering Details</h4>
              </div>
            </div>
            <div class="two column row">
              <div class="column">
                <div class="ui red ribbon label">Package Menu</div>
                <table class="ui compact celled green structured table menu-table">
                  <input type="hidden" name="pkgid">
                  <thead>
                    <tr>
                      <th colspan="2">Package Name: <span class="pkgname"></span></th>
                    </tr>
                    <tr>
                      <th>Food Name</th>
                      <th class="four wide">Category</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="center aligned">Empty</td>
                    </tr>
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="2">
                        <div class="ui blue small right floated labeled icon button addmenu"><i class="pencil icon"></i>Add / Modify Package Menu</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="column">
                <div class="ui red right ribbon label">Staff Assignment</div>
                <table class="ui compact celled green table staff-table">
                  <thead>
                    <tr>
                      <th class="ten wide">Staff Name</th>
                      <th class="four wide">Profession</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="3" class="center aligned">Empty</td>
                    </tr>
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="3">
                        <div class="ui blue small right floated labeled icon button addstaff"><i class="pencil icon"></i>Add / Modify Staff</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="column">
                <div class="ui red right ribbon label">Other Additional Charges</div>
                <table class="ui compact celled blue table service-table">
                  <input type="hidden" name="csid" value="">
                  <thead>
                    <tr>
                      <th class="six wide">Service Name</th>
                      <th class="three wide right aligned">Price</th>
                      <th class="two wide">Hour/s</th>
                      <th class="three wide right aligned">Total</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="5" class="center aligned">Empty</td>
                    </tr>
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="5">
                        <div class="ui green small labeled icon right floated button addservices"><i class="pencil icon"></i>Add / Modify Services</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <div class="ui grid segment">
            <div class="row">
              <div class="column">
                <h4 class="ui horizontal divider header"><i class="add circle card icon"></i>Additional Information</h4>
              </div>
            </div>
            <div class="two column row">
              <div class="column">
                <div class="ui red ribbon label">Extra Cost:</div>
                <table class="ui compact fixed single line small brown table extracost">
                  <thead>
                    <tr>
                      <th class="five wide">Type</th>
                      <th class="right aligned three wide">Amount</th>
                      <th class="center aligned two wide">Count</th>
                      <th class="right aligned three wide">Total</th>
                      <th class="three wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="center aligned" colspan="5">Empty</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">
                        <div class="ui brown mini labeled right floated icon button addextra"><i class="add icon"></i>Add Extra Cost</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="column">
                <div class="field">
                  <div class="ui red right ribbon label">Task/Reminder:</div>
                  <table class="ui inverted small compact table task">
                    <thead>
                      <tr>
                        <th>Description</th>
                        <th>Date & Time</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="center aligned" colspan="3">Empty</td>
                      </tr>
                    </tbody>
                    <tfoot class="full-width">
                      <th colspan="3">
                        <div class="ui right floated mini brown labeled icon button addtask">
                          <i class="add icon"></i> Add Task
                        </div>
                      </th>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <div class="ui grid segment">
            <div class="row">
              <div class="column">
                <h4 class="ui horizontal divider header"><i class="credit card icon"></i>Payment Information</h4>
              </div>
            </div>
            <div class="two column row">
              <div class="column">

              </div>
              <div class="column">
                <table class="ui basic small compact table payment">
                  <tr>
                    <th class="twelve wide"></th>
                    <th class="four wide"></th>
                  </tr>
                  <tr>
                    <td colspan="2"><label class="ui violet ribbon label">Pricing Details:</label></td>
                  </tr>
                  <tr class="right aligned">
                    <td>Food and Services:</td>
                    <td>&#8369; 0.00</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Food Addons: </td>
                    <td>&#8369; 0.00</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Venue:</td>
                    <td>&#8369; 0.00</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Other Additional Charges:</td>
                    <td class="oac">&#8369; 0.00</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Extra Costs:</td>
                    <td>&#8369; 0.00</td>
                  </tr>
                 <!--  <tr class="right aligned">
                    <td>Subtotal:</td>
                    <td>&#8369; 0.00</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Sales Tax:</td>
                    <td>&#8369; 0.00</td>
                  </tr> -->
                  <tr class="right aligned">
                    <td>Total:</td>
                    <td>&#8369; 0.00</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <div class="ui basic segment">
            <a class="ui black reset deny button" href="/Admin/Transaction/Event-Reservation"><i class="arrow left icon"></i>Back</a>
            <button class="ui purple submit button right floated" type="submit">Save Event</button>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('forms')
<div class="ui long modal" id="addmenu">
  <div class="header">Add/Modify Package Menu</div>
  <div class="content">
    <form class="ui form" id="menuform">
      {{csrf_field()}}
      <input type="hidden" name="packid">

      <div class="pkg-cont" id="pkg-cont">
        <table class="ui fixed single line unstackable very basic table pkg">
          <thead>
            <tr>
              <th class="ten wide">Package Name</th>
              <th class="four wide">Price</th>
              <th class="two wide">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($package as $package)
            <tr>
              <td class="name">{{$package->package_name}}</td>
              <td>&#8369; {{number_format($package->package_price,2)}} per head</td>
              <td><div class="ui blue button fixpkg" data-id="{{$package->package_id}}">Choose</div></td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="ui second segment transition hidden segment">
        <h2 class="ui centered header"></h2>
        <div id="menu-cont"></div>
        <div class="ui header">Add-ons:</div>
        <div id="add-ons"></div>
        <div class="field">
          <div class="ui teal labeled icon button addfood">ADD<i class="add icon"></i></div>
        </div>
        <div class="field">
          <label>Special Menu Instructions:</label>
          <textarea rows="3" name="menuins"></textarea>
        </div>
      </div>
  </div>
  <div class="actions">
    <div class="ui primary left floated button chngpkg">Change Package</div>
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>

<div class="ui long modal" id="addservices">
  <div class="header">
    <span class="title" id="popo">Services</span>
    <span class="transition hidden selected"><i class="left chevron icon sel"></i> Selected</span>
  </div>
  <div class="content">
    <div id="service-cont">

    <div class="ui fluid category search">
      <div class="ui fluid icon input">
        <input class="prompt" type="text" placeholder="Search services..." autocomplete="off">
        <i class="search icon"></i>
      </div>
    </div>
    <div class="ui divider"></div>

    <table class="ui very basic selectable table all">
      <tbody>
        <tr data-id="all">
          <td class="fourteen wide">All Services</td>
          <td class="two wide center aligned"><i class="right chevron icon"></i></td>
        </tr>
        <tr data-id="ctgry">
          <td class="fourteen wide">Service Category</td>
          <td class="two wide center aligned"><i class="right chevron icon"></i></td>
        </tr>
      </tbody>
    </table>

    <table class="ui very basic table transition hidden list">
      <tbody>
      </tbody>
    </table>

    <table class="ui very basic selectable table transition hidden type">
      <tbody>
      @foreach($stype as $stype)
        <tr data-id="{{$stype->services_id}}">
          <td class="fourteen wide name">{{$stype->services_name}}</td>
          <td class="two wide center aligned"><i class="right chevron icon"></i></td>
        </tr>
      @endforeach
      </tbody>
    </table>
    </div>

    <table class="ui very basic table selected transition hidden">
      <tbody>
      </tbody>
    </table>

    <div id="service-input">
    </div>
  </div>
  <div class="actions">
    <div class="ui left floated button varsel"><span class="counter">0</span> Service Selected</div>
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>

  </div>
</div>

<div class="ui long modal" id="addstaff">
  <div class="header">Add/Modify Staff Assignment</div>
  <div class="content" style="min-height: 500px">

      <table class="ui fixed single line unstackable very basic table">
        <thead>
          <tr>
            <th class="two wide"></th>
            <th class="eight wide">Staff Name</th>
            <th class="three wide">Profession</th>
            <th class="three wide">Status</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>

<div class="ui long modal" id="addinventory">
  <div class="header">Equipment List</div>
  <div class="content">
    <div class="list">
    <table class="ui fixed single line unstackable very basic table">
      <thead>
        <tr>
          <th class="two wide"></th>
          <th class="six wide">Equipment</th>
          <th class="four wide">Type</th>
          <th class="four wide">In Stock</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <div class="ui positive submit button labeled icon active addbtn">Save
      <i class="pencil icon"></i></div>
      <div class="or"></div>
      <div class="ui black reset deny button cancelbtn">Cancel</div>
    </div>
    </form>
  </div>
</div>

<div class="ui small modal" id="addextra">
  <div class="header">Add Extra Cost</div>
  <div class="content">
    <form class="ui form">
    <div class="five wide required field">
      <label>Extra Cost:</label>
      <input type="number" name="amount">
    </div>
    <div class="inline fields">
      <div class="field">
        <div class="ui radio checkbox type">
          <input type="radio" name="type" checked="checked" tabindex="0" value="Flat Cost">
          <label>Extra Cost is a Flat Cost</label>
        </div>
      </div>
      <div class="field">
        <div class="ui radio checkbox count">
          <input type="radio" name="type" tabindex="0" value="Count Based">
          <label>Calculate Extra Cost based on Count</label>
        </div>
      </div>
    </div>
    <div class="three wide field">
      <label>Count:</label>
      <div class="ui input disabled guestcount">
        <input type="number" name="count">
      </div>
    </div>
    <div class="field">
      <label>Extra Cost Comments:</label>
      <textarea rows="3" name="comment"></textarea>
    </div>
    </form>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button" type="reset">Cancel</button>
    </div>
  </div>
</div>
<div class="ui small modal" id="editextra">
  <div class="header">Edit Extra Cost</div>
  <div class="content">
    <form class="ui form">
    <input type="hidden" name="ecid">
    <div class="five wide required field">
      <label>Extra Cost:</label>
      <input type="number" name="amount">
    </div>
    <div class="inline fields">
      <div class="field">
        <div class="ui radio checkbox">
          <input type="radio" name="type" checked="checked" tabindex="0" value="Flat Cost">
          <label>Extra Cost is a Flat Cost</label>
        </div>
      </div>
      <div class="field">
        <div class="ui radio checkbox count">
          <input type="radio" name="type" tabindex="0" value="Count Based">
          <label>Calculate Extra Cost based on Count</label>
        </div>
      </div>
    </div>
    <div class="three wide field">
      <label>Count:</label>
      <div class="ui input disabled guestcount">
        <input type="number" name="count">
      </div>
    </div>
    <div class="field">
      <label>Extra Cost Comments:</label>
      <textarea rows="3" name="comment"></textarea>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>

<div class="ui small modal" id="addtask">
  <div class="header">Add Task/Reminder</div>
  <div class="content">
    <form class="ui form">
    <div class="two fields">
      <div class="required field">
        <label>Task Date:</label>
        <div class="ui calendar date">
          <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input placeholder="Date" name="date">
          </div>
        </div>
      </div>
      <div class="required field">
        <label>Task Time:</label>
        <div class="ui calendar time">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input placeholder="Input..." name="time">
          </div>
        </div>
      </div>
    </div>
    <div class="required field">
      <label>Description:</label>
      <textarea rows="3" name="description"></textarea>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>
<div class="ui small modal" id="edittask">
  <div class="header">Edit Task/Reminder</div>
  <div class="content">
    <form class="ui form" method="post" action="">
    {{csrf_field()}}
    <input type="hidden" name="id">
    <div class="two fields">
      <div class="required field">
        <label>Task Date:</label>
        <div class="ui calendar date">
          <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input placeholder="Date" name="date">
          </div>
        </div>
      </div>
      <div class="required field">
        <label>Task Time:</label>
        <div class="ui calendar time">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input placeholder="Input..." name="time">
          </div>
        </div>
      </div>
    </div>
    <div class="required field">
      <label>Description:</label>
      <textarea rows="3" name="description"></textarea>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>

<div class="ui basic modal delete">
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

  <div class="ui long modal calendar">
    <div class="header">Calendar</div>
    <div class="content">
      <div id="calendar"></div>
    </div>
    <div class="actions">
      <button class="ui positive button">OK</button>
    </div>
  </div>
  <div class="ui floating big error message msgbox hidden valmsg">
    <i class="close icon" id="close"></i>
    <div class="header">
      Reservation Details
    </div>
    <ul class="list">
      <li>Save Event first before adding.</li>
    </ul>
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
