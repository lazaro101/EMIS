@extends('layouts.admin')

@section('title','Event Reservations')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.print.css') }}" media="print">
<!-- <script src="{{ asset('Semantic/dist/fullcalendar/lib/jquery.min.js') }}"></script> -->
<script src="{{ asset('Semantic/dist/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('Semantic/dist/fullcalendar/fullcalendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.css') }}">
<script type="text/javascript" src="{{ asset('js/editreservation.js') }}"></script>
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
  <form class="ui form main" method="post" action="/editReservation">
  {{ csrf_field() }}
  <input type="hidden" name="eventrsrvtnid" value="{{$rsrvtn->event_reservation_id}}">
    <div class="ui grid">
      <div class="row">
        <div class="column">
          <h2 class="ui left floated header">
            <i class="large icons">
              <i class="calendar outline icon"></i>
              <i class="write corner icon"></i>
            </i>
            <div class="content">Reservation Details</div>
          </h2>
          <h3 class="ui right floated header">
            <i class="user icon"></i>
            <div class="content">
              <div class="sub header">Created By: {{$rsrvtn->created_by}}, {{date_create($rsrvtn->created_at)->format('m/d/y h:i A')}}</div>
              <div class="sub header">Updated By: {{$rsrvtn->updated_by}}, {{date("m/d/y h:i A", strtotime($rsrvtn->updated_at))}}</div>
            </div>
          </h3>
        </div>
      </div>

      <div class="centered row">
        <div class="ui header">Current Status: <label class="ui large @if($rsrvtn->status=='Created') yellow @elseif($rsrvtn->status=='Submitted') orange @elseif($rsrvtn->status=='Booked') green @elseif($rsrvtn->status=='Completed') blue @else red @endif label">{{$rsrvtn->status}}</label></div>
      </div>

      <div class="centered row">
        <div class="ui mini steps">
          <div class="@if($rsrvtn->status=='Created' or $rsrvtn->status=='Submitted' or $rsrvtn->status=='Booked' or $rsrvtn->status=='Cancelled' or $rsrvtn->status=='Completed') active completed @endif step">
            <i class="info icon"></i>
            <div class="content">
              <div class="title">Created</div>
              <div class="description">Fill up form.</div>
            </div>
          </div>
          <div class="@if($rsrvtn->status=='Submitted' or $rsrvtn->status=='Booked' or $rsrvtn->status=='Cancelled' or $rsrvtn->status=='Completed') active completed @endif step">
            <i class="file outline icon"></i>
            <div class="content">
              <div class="title">Submitted</div>
              <div class="description">Submit details.</div>
            </div>
          </div>
          <div class="@if($rsrvtn->status=='Booked' or $rsrvtn->status=='Cancelled' or $rsrvtn->status=='Completed') active completed @endif step">
            <i class="checked calendar icon"></i>
            <div class="content">
              <div class="title">Booked</div>
              <div class="description">Approved and booked.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="centered row">
        <div class="inline field">
          <label>Change Status:</label>
          <div class="ui selection dropdown status">
            <input type="hidden" name="status" value="{{$rsrvtn->status}}">
            <i class="dropdown icon"></i>
            <span class="default text">Select</span>
            <div class="menu">
              <div class="item" data-value="Created">
                Created
              </div>
              <div class="item" data-value="Submitted">
                Submitted
              </div>
              <div class="item" data-value="Booked">
                Booked
              </div>
              <div class="@if($rsrvtn->status!='Booked') disabled @endif item" data-value="Completed">
                Completed
              </div>
            </div>
          </div>
          <button class="ui teal basic small button" type="submit">Save Changes</button>
        </div>
      </div>

      <div class="two column row">
        <div class="column">
          <div class="ui segment">
            <h4 class="ui horizontal divider header"><i class="calendar icon"></i>Event Details</h4>
            <div class="two fields">
              <div class="inline field">
                <label>Invoice #: {{$rsrvtn->payment_id}}</label>
              </div>
              <div class="field">
                <div class="ui basic purple right floated vertical animated button checked  ">
                  <div class="visible content"><i class="checked calendar icon"></i>Check calendar</div>
                  <div class="hidden content">
                    <i class="right arrow icon"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="required field">
              <label>Event Name:</label>
              <input type="text" name="eventname" value="{{ $rsrvtn->event_name }}">
            </div>
            <div class="two fields">
              <div class="required field">
                <label>Event Date:</label>
                <div class="ui calendar date">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input placeholder="Date" name="eventdate" value="{{ $rsrvtn->event_date }}">
                  </div>
                </div>
              </div>
              <div class="required field">
                <label>Event Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="eventtime" value="{{ $rsrvtn->event_time }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="three fields">
              <div class="field">
                <label>Setup Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="setuptime" value="{{ $rsrvtn->event_setup }}">
                  </div>
                </div>
              </div>
              <div class="field">
                <label>End Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="endtime" value="{{ $rsrvtn->event_end }}">
                  </div>
                </div>
              </div>
              <div class="required field">
                <label>Guest Count:</label>
                <input type="number" name="guestcount" value="{{ $rsrvtn->event_guest_count }}">
              </div>
            </div>
            <div class="two fields">
              <div class="required field">
                <label>Occassion:</label>
                <input type="text" placeholder="Input..." name="occassion" value="{{ $rsrvtn->event_occassion }}">
              </div>
              <div class="field">
                <label>Motif:</label>
                <input type="text" placeholder="Input..." name="motif"  value="{{ $rsrvtn->event_motif }}">
              </div>
            </div>
            <div class="field">
              <label>Event Setup Notes:</label>
              <textarea rows="3" name="eventnotes">{{ $rsrvtn->event_setup_notes }}</textarea>
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
                  <input type="text" placeholder="Input..." name="fname" value="{{ $rsrvtn->client_fname }}">
                </div>
                <div class="required field">
                  <label>Last Name:</label>
                  <input type="text" placeholder="Input..." name="lname" value="{{ $rsrvtn->client_lname}}">
                </div>
              </div>
              <div class="two fields">
                <div class="required field">
                  <label>Cellphone Number:</label>
                  <input type="text" placeholder="Primary Number..." name="cpnum1" value="{{ $rsrvtn->client_contact1 }}">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="cpnum2" value="{{ $rsrvtn->client_contact2 }}">
                </div>
              </div>
              <div class="two fields">
                <div class="field">
                  <label>Telephone:</label>
                  <input type="text" placeholder="Primary Number..." name="telnum1" value="{{ $rsrvtn->client_telephone1 }}">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="telnum2" value="{{ $rsrvtn->client_telephone2 }}">
                </div>
              </div>
              <div class="required field">
                <label>Email:</label>
                <input type="text" placeholder="Input..." name="email" value="{{ $rsrvtn->client_email }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="column">              
              <div class="ui segment">
                <h4 class="ui horizontal divider header"><i class="map icon"></i>Location</h4>
                <div class="field">
                  <div class="ui checkbox location">
                    <input type="checkbox" name="loctype" value="1" @if($rsrvtn->event_loctype == 1) checked @endif>
                    <label>Choose on suggested location?</label>
                  </div>
                </div>
                <div class="ui form location">
                  <div class="sixteen wide field">
                    <div class="first side @if($rsrvtn->event_loctype == 1) transition hidden @endif">
                      <div class="required field">
                        <label>Address:</label>
                        <input type="text" name="venue" value="{{$rsrvtn->event_address}}">
                      </div>
                    </div>
                    <div class="second side @if($rsrvtn->event_loctype == 0) transition hidden @endif">
                      <div class="two fields">
                        <div class="twelve wide required field">
                          <label>Location:</label>
                          <div class="ui selection dropdown" tabindex="0">
                            <input type="hidden" name="location" value="{{$rsrvtn->event_location}}">
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
                          <input type="number" name="hrs" value="{{$rsrvtn->event_hrs}}">
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
                <table class="ui compact celled structured green table menu-table">
                  <input type="hidden" name="cmid" value="{{$rsrvtn->catering_menu_id}}">
                  <input type="hidden" name="pkgid" value="{{$rsrvtn->package_id}}">
                  <thead>
                    <tr>
                      <th colspan="2">Package Name: <span class="pkgname">{{$rsrvtn->package_name}}</span></th>
                    </tr>
                    <tr>
                      <th>Food Name</th>
                      <th class="four wide">Category</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($menu) == 0)
                    <tr>
                      <td colspan="2" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($menu as $menu)
                      <tr>
                        <td>{{$menu->submenu_name}}<input type="hidden" name="menu[]" value="{{$menu->submenu_id}}"></td>
                        <td class="four wide">{{$menu->submenu_category_name}}</td>
                      </tr>
                      @endforeach
                      @if(count($addons) != 0)
                      <tr>
                        <td colspan="2" class="center aligned">Addons:</td>
                      </tr>
                      @foreach($addons as $ao)
                      <tr>
                        <td>{{$ao->submenu_name}}<input type="hidden" name="addons[]" value="{{$ao->submenu_id}}"></td>
                        <td class="four wide">{{$ao->submenu_category_name}}</td>
                      </tr>
                      @endforeach
                      @endif
                    @endif
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
                <a class="ui red right ribbon label">Staff Assignment</a>
                <table class="ui compact celled green table staff-table">
                  <input type="hidden" name="cstid" value="{{$rsrvtn->catering_staff_id}}">
                  <thead>
                    <tr>
                      <th class="ten wide">Staff Name</th>
                      <th class="four wide">Profession</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($staff) == 0)
                    <tr>
                      <td colspan="3" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($staff as $st)
                      <tr>
                        <td>{{$st->staff_fname.' '.$st->staff_lname}}<input type="hidden" name="staff[]" value="{{$st->staff_id}}"></td>
                        <td>{{$st->staff_profession_description}}</td>
                        <td class="center aligned"><i class="delete icon"></i></td>
                      </tr>
                      @endforeach
                    @endif
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
                  <input type="hidden" name="csid" value="{{$rsrvtn->catering_services_id}}">
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
                    @if(count($services) == 0)
                    <tr>
                      <td colspan="5" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($services as $ser)
                      <tr>
                        <td>{{$ser->services_contact_name}}<input type="hidden" name="serviceContact[]" value="{{$ser->services_contact_id}}"></td>
                        <td class="right aligned price">₱ {{number_format($ser->services_contact_price,2).' '}}@if($ser->price_type == 1) flat @else per hr. @endif</td>
                        <td>@if($ser->price_type == 2) 0 @else <div class="field"><input type="number" name="shrs" value="{{$ser->total/$ser->services_contact_price}}"></div> @endif</td>
                        <td class="right aligned total">₱ {{number_format($ser->total,2)}}<input type="hidden" name="sctot[]" value="{{$ser->total}}"></td>
                        <td class="center aligned">
                          <div class="ui secondary small icon button delser"><i class="delete icon"></i></div>
                        </td>
                      </tr>
                      @endforeach
                    @endif
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
                <table class="ui compact fixed single line small brown extracost table">
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
                  @if(count($extra) == 0)
                    <tr>
                      <td colspan="5" class="center aligned">Empty</td>
                    </tr>
                  @else
                    @foreach($extra as $extra)
                    <tr>
                      <input type="hidden" value="{{$extra->extra_cost_id}}">
                      <td>{{$extra->cost_type}}</td>
                      <td class="right aligned">₱ {{$extra->amount}}</td>
                      <td class="center aligned">({{$extra->guest_count}})</td>
                      <td class="right aligned">₱ {{$extra->total}}</td>
                      <td class="center aligned">
                        <div class="ui mini teal icon button editextra" data-id="{{$extra->extra_cost_id}}"><i class="pencil icon"></i></div>
                        <div class="ui mini negative icon button deleteextra" data-id="{{$extra->extra_cost_id}}"><i class="trash bin icon"></i></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5">{{$extra->comments}}<input type="hidden" name="extraCost[]" value="{{$extra->extra_cost_id}}"></td>
                    </tr>
                    @endforeach
                  @endif
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
                    @if(count($task) == 0)
                      <tr>
                        <td colspan="3" class="center aligned">Empty</td> 
                      </tr>
                    @else
                      @foreach($task as $task)
                      <tr>
                        <td>{{$task->description}}<input type="hidden" value="{{$task->reminder_id}}"></td>
                        <td>{{$task->date.' '.$task->time}}</td>
                        <td class="three wide center aligned">
                          <div class="ui mini teal icon button edittask" data-id="{{$task->reminder_id}}"><i class="pencil icon"></i></div>
                          <div class="ui mini red icon button deletetask" data-id="{{$task->reminder_id}}"><i class="trash bin icon"></i></div>
                        </td>
                      </tr>
                      @endforeach
                    @endif
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
                <div class="row">
                <!--   <div class="column">
                    <h4 class="ui header">
                      <i class="file icon"></i>
                      <div class="content">
                        Email Invoice
                      </div>
                    </h4>
                  </div> -->
                 <!--  <div class="column">
                    <div class="ui right floated button">Email invoice</div>
                  </div> -->
                </div>
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
                    <td>&#8369; {{number_format($rsrvtn->menu_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Food Addons: </td>
                    <td>&#8369; {{number_format($rsrvtn->addons_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Venue:</td>
                    <td>&#8369; {{number_format($rsrvtn->location_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Other Additional Charges:</td>
                    <td class="oac">&#8369; {{number_format($rsrvtn->services_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Extra Cost/s:</td>
                    <td>&#8369; {{number_format($rsrvtn->extra_cost_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Total:</td>
                    <td class="total pay">&#8369; {{number_format($rsrvtn->grand_total,2)}}</td>
                  </tr>
                </table>
              </div><input type="hidden" name="amtpaid" value="{{$rsrvtn->amt_paid}}">
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="column">
          <div class="ui basic segment">
              <div class="ui black reset deny button back"><i class="arrow left icon"></i>Back</div>
              <div class="ui right floated small purple button delete">Delete Event</div>
              <!-- <div class="ui right floated small purple button">Export Invoice</div> --> 
              <div class="ui right floated small purple button export">Export PDF</div>
              <div class="ui right floated small purple button cancel">Cancel Event</div>
              <button class="ui right floated small purple button" type="submit">Update Event</button>
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
    <form class="ui form">
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
      <div class="ui positive submit button labeled icon active addbtn">Save
      <i class="pencil icon"></i></div>
      <div class="or"></div>
      <div class="ui black reset deny button cancelbtn">Cancel</div>
    </div>
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
      <button class="ui positive button labeled icon active addbtn" type="submit">Save
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
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
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

