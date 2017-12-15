@extends('layouts.admin')

@section('title','Event Reservations')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.print.css') }}" media="print">
<!-- <script src="{{ asset('Semantic/dist/fullcalendar/lib/jquery.min.js') }}"></script> -->
<script src="{{ asset('Semantic/dist/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('Semantic/dist/fullcalendar/fullcalendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.css') }}">
<script type="text/javascript" src="{{ asset('js/editreservation.js') }}"></script>
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

@foreach($rsrvtn as $rsrvtn)
<div class="ui basic segment content">
  <form class="ui form" method="post" action="/editReservation">
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
        <div class="ui header">Current Status: <label class="ui large @if($rsrvtn->status=='Created' or $rsrvtn->status=='Submitted') yellow @elseif($rsrvtn->status=='Booked') green @elseif($rsrvtn->status=='Completed') blue @else red @endif label">{{$rsrvtn->status}}</label></div>
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
                <label>Invoice #:</label>
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
        <!--     <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" name="example" tabindex="0" class="">
                <label>Choose on suggested location?</label>
              </div>
            </div> -->
            <div class="required field">
              <label>Venue (where):</label>
              <input type="text" placeholder="Input..." name="venue"  value="{{ $rsrvtn->event_location }}">
          <!--     <select class="ui dropdown">
                <option value="sad">Sad, 5,000</option>
              </select> -->
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
                <table class="ui compact celled green table">
                  <thead>
                    <tr>
                      <th class="thirteen wide">@if($rsrvtn->package_name == "") No Package Selected @else {{$rsrvtn->package_name}} @endif</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($menu)==0)
                  <tr>
                    <td class="center aligned" colspan="2">Empty</td>
                  </tr>
                  @else
                  @foreach($menu as $menu)
                    <tr>
                      <td>{{ $menu->submenu_name }}</td>
                    </tr>
                  @endforeach
                  @endif
                  @if($addons != NULL)
                    @if(count($addons) != 0)
                    <tr>
                      <td><h3 class="ui header right aligned">Addons: </h3></td>
                    </tr>
                    @foreach($addons as $ao)
                    <tr>
                      <td>{{ $ao->submenu_name }}</td>
                    </tr>
                    @endforeach
                    @endif
                  @endif
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="2">
                        <div class="ui blue small right floated labeled icon button addmenu" data-cmid="{{$rsrvtn->catering_menu_id}}" data-packname="{{$rsrvtn->package_name}}" data-aoid="{{$rsrvtn->catering_addons_id}}"><i class="pencil icon"></i>Add / Modify Package Menu</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="column">
                <table class="ui compact celled blue table service-table">
                  <thead>
                    <tr>
                      <th class="ten wide">Other Additional Charges</th>
                      <th class="four wide right aligned">Price</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($services)==0)
                  <tr>
                    <td class="center aligned" colspan="3">Empty</td>
                  </tr>
                  @else
                  @php $services1 = $services @endphp
                  @foreach($services1 as $services1)
                    <tr>
                      <td>{{ $services1->services_contact_name }}<input type="hidden" name="serviceContact[]" value="{{ $services1->services_contact_id }}"></td>
                      <td class="right aligned price">&#8369; {{ number_format($services1->services_contact_price,2) }}</td>
                      <td class="center aligned"><i class="delete icon" data-id="{{ $services1->services_contact_id }}"></i></td>
                    </tr>
                  @endforeach
                  @endif
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="3">
                        <div class="ui green small labeled icon right floated button addservices" data-id="{{$rsrvtn->catering_services_id}}"><i class="pencil icon"></i>Add / Modify Services</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="two column row">
              <div class="column">
                <table class="ui compact celled green table">
                  <thead>
                    <tr>
                      <th class="thirteen wide">Inventory Checklist</th>
                      <th>Quantity</th>
                      <th>Equipment Used</th>
                      <th>Equipment Return</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($invlist) != 0)
                  @foreach($invlist as $invlist)
                  <tr>
                    <td>{{$invlist->equipment_inventory_name}}</td>
                    <td>{{$invlist->equipment_qty}}</td>
                    <td>{{$invlist->equipment_used_qty}}</td>
                    <td>{{$invlist->equipment_return_qty}}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="center aligned" colspan="4">Empty</td>
                  </tr>
                  @endif
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="4">
                        <div class="ui blue small right floated labeled icon button addchecklist" data-id="{{$rsrvtn->catering_inventory_id}}"><i class="pencil icon"></i>Add / Modify Checklist</div>
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="column">
                <table class="ui compact celled green table staff-table">
                  <thead>
                    <tr>
                      <th class="ten wide">Staff Assignment</th>
                      <th class="four wide">Profession</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($stafflist) == 0)
                  <tr>
                    <td class="center aligned" colspan="3">Empty</td>
                  </tr>
                  @endif
                  @foreach($stafflist as $sl)
                  <tr>
                    <td>{{$sl->staff_fname.' '.$sl->staff_lname}}<input type="hidden" name="staff[]" value="{{$sl->staff_id}}"></td>
                    <td>{{$sl->staff_profession_description}}</td>
                    <td class="center aligned"><i class="delete icon" data-id="{{$sl->staff_id}}"></i></td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot class="full-width">
                    <tr>
                      <th colspan="3">
                        <div class="ui blue small right floated labeled icon button addstaff" data-id="{{$rsrvtn->catering_staff_id}}"><i class="pencil icon"></i>Add / Modify Staff</div>
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
                <!-- <label class="ui violet ribbon label">Extra Cost:</label> -->
                <table class="ui compact fixed single line small brown table">
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
                  @if(count($extra)==0)
                    <tr>
                      <td class="center aligned" colspan="5">Empty</td>
                    </tr>
                  @else
                  @foreach($extra as $extra)
                    <tr>
                      <td>{{$extra->cost_type}}</td>
                      <td class="right aligned">&#8369; {{number_format($extra->amount)}}</td>
                      <td class="center aligned">({{$extra->guest_count}})</td>
                      <td class="right aligned">&#8369; {{number_format($extra->total)}}</td>
                      <td class="center aligned">
                        <div class="ui mini teal icon button editextra" data-id="{{$extra->extra_cost_id}}"><i class="pencil icon"></i></div>
                        <div class="ui mini negative icon button deleteextra" data-id="{{$extra->extra_cost_id}}"><i class="trash bin icon"></i></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5">{{$extra->comments}}</td>
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
                  <table class="ui inverted small compact table">
                    <thead>
                      <tr>
                        <th colspan="3">Task/Reminders:</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(count($task)==0)
                    <tr>
                      <td class="center aligned" colspan="3">Empty</td>
                    </tr>
                    @else
                    @foreach($task as $task)
                      <tr>
                        <td class="seven wide">{{$task->description}}</td>
                        <td class="five wide center aligned">{{date_create($task->date.$task->time)->format('m/d/y h:i A')}}</td>
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
                    <td>&#8369; {{number_format($rsrvtn->package_price*$rsrvtn->event_guest_count,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Food Addons: </td>
                    <td>&#8369; @if($addons != NULL) {{number_format($rsrvtn->addons_total,2)}} @else 0.00 @endif</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Venue:</td>
                    <td>&#8369; {{number_format('0',2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Other Additional Charges:</td>
                    <td class="oac">&#8369; {{number_format($rsrvtn->services_total,2)}}</td>
                  </tr>
                  <tr class="right aligned">
                    <td>Extra Costs:</td>
                    <td>&#8369; {{number_format($rsrvtn->extra_cost_total,2)}}</td>
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
                    <td>&#8369; {{number_format($rsrvtn->overall,2)}}</td>
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
              <div class="ui right floated small purple button" type="submit">Delete Event</div>
              <div class="ui right floated small purple button">Export Invoice</div>
              <a href="/Admin/Transaction/Event-Reservation?eventdetails=eventpdf&id={{$rsrvtn->event_reservation_id}}" target="_blank" class="ui right floated small purple button">Export PDF</a>
              <div class="ui right floated small purple button">Copy Event</div>
              <a class="ui right floated small purple button" href="/cancelReservation?id={{$rsrvtn->event_reservation_id.'&log='.$rsrvtn->reservation_logs_id}}">Cancel Event</a>
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
    <form class="ui form" method="post" action="/addCateringMenu/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
      {{csrf_field()}}
      <input type="hidden" name="cmid" value="{{$rsrvtn->catering_menu_id}}">
      <input type="hidden" name="cdid" value="{{$rsrvtn->catering_details_id}}">
      <input type="hidden" name="packid" value="{{$rsrvtn->package_id}}">

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
      @foreach($type as $type)
        <tr data-id="{{$type->services_id}}">
          <td class="fourteen wide name">{{$type->services_name}}</td>
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

    <form class="ui form" method="post" action="/addCateringServices/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$rsrvtn->catering_services_id}}">
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
    </form>
  </div>
</div>

<div class="ui long modal" id="addinventory">
  <div class="header">Equipment List</div>
  <div class="content">
    <form class="ui form" method="post" action="/addCateringInventory/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
      {{csrf_field()}}
      <!-- <input type="hidden" name="csid" value="{{$rsrvtn->catering_inventory_id}}"> -->
      <!-- <input type="hidden" name="cdid" value="{{$rsrvtn->catering_details_id}}">   -->
      <div class="list">
      <table class="ui fixed single line unstackable very basic table">
        <thead>
          <tr>
            <th class="eight wide">Equipment</th>
            <th class="four wide">Type</th>
            <th class="two wide">In Stock</th>
            <th class="two wide">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($inventory as $inv)
          <tr>
            <td class="name">{{$inv->equipment_inventory_name}}</td>
            <td>{{$inv->equipment_type_description}}</td>
            <td>{{$inv->equipment_inventory_qty}}</td>
            <td class="center aligned">
              <div class="ui green button add" data-id="{{$inv->equipment_inventory_id}}">ADD</div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      </div>
      <div class="selected transition hidden">
      <table class="ui very basic table">
        <thead>
          <tr>
            <th class="seven wide">Name</th>
            <th class="three wide">Quantity</th>
            <th class="three wide">Equipment Used</th>
            <th class="three wide">Equipment Return</th>
            <th class="two wide">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      </div>

  </div>
  <div class="actions">
    <div class="ui primary left floated button selchk">Selected Equipment</div>
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>

<div class="ui long modal" id="addstaff">
  <div class="header">Add/Modify Staff Assignment</div>
  <div class="content" style="min-height: 500px">
    <form class="ui form" method="post" action="/addCateringStaff/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
      {{csrf_field()}}
      <input type="hidden" name="csid" value="{{$rsrvtn->catering_staff_id}}">
      <input type="hidden" name="cdid" value="{{$rsrvtn->catering_details_id}}">

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

<div class="ui small modal" id="addextra">
  <div class="header">Add Extra Cost</div>
  <div class="content">
    <form class="ui form" method="post" action="/addExtraCost/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
    {{csrf_field()}}
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
      <button class="ui positive submit button labeled icon active" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>
<div class="ui small modal" id="editextra">
  <div class="header">Edit Extra Cost</div>
  <div class="content">
    <form class="ui form" method="post" action="/editExtraCost/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
    {{csrf_field()}}
    <input type="hidden" name="id">
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
      <button class="ui positive submit button labeled icon active" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>
<form id="deleteextra" action="/deleteExtra/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}" method="post" style="display: none">
  {{csrf_field()}}
  <input name="id">
</form>

<div class="ui small modal" id="addtask">
  <div class="header">Add Task/Reminder</div>
  <div class="content">
    <form class="ui form" method="post" action="/addTask/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
    {{csrf_field()}}
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
      <button class="ui positive submit button labeled icon active" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>
<div class="ui small modal" id="edittask">
  <div class="header">Edit Task/Reminder</div>
  <div class="content">
    <form class="ui form" method="post" action="/editTask/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}">
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
      <button class="ui positive submit button labeled icon active" type="submit">Save
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>
</div>
<form id="deletetask" action="/deleteTask/{{$rsrvtn->event_reservation_id.'/'.$rsrvtn->reservation_logs_id}}" method="post" style="display: none">
  {{csrf_field()}}
  <input name="id">
</form>

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

@endforeach
