@extends('layouts.admin')

@section('title','Dashboard')

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.task.menu .item').tab();
    $('.outt.menu .item').tab();
    $('.day.table').DataTable();
    $('.all.table').DataTable();
    $('.dropdown.multiple').dropdown();
  });
</script>

<script type="text/javascript" src="{{asset('js/dashboard.js')}}"></script>
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('content')

  <div class="ui raised basic segment content">
    <h1 class="ui right floated header">
      <i class="dashboard icon"></i>
      <div class="content">Dashboard</div>
    </h1>
    <div class="ui clearing divider"></div>

    <div class="ui grid stackable">
      <div class="three column row">
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Reservations</div>
                <div class="description">
                  You have {{$eve}} Reservation/s on this day.
                </div>
              </div>
              <a class="ui bottom attached button" href="/Admin/Transaction/Event-Reservation">
                <i class="info icon"></i>
                View Reservations
              </a>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Inquiries</div>
                <div class="description">
                  You have {{$inq}} inquiry on this day.
                </div>
              </div>
              <a class="ui bottom attached button" href="/Admin/Transaction/Event-Inquiries">
                <i class="info icon"></i>
                View Inquiries
              </a>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
              <div class="content">
                <div class="header">Food Orders</div>
                <div class="description">
                  You have {{$fo}} food order/s on this day.
                </div>
              </div>
              <a class="ui bottom attached button" href="/Admin/Transaction/Food-Order">
                <i class="info icon"></i>
                View Food Orders
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="twelve wide column centered">
          <div class="ui stacked segment">
            <div class="ui top attached tabular menu task">
              <a class="active item" data-tab="first">Daily Task</a>
              <a class="item" data-tab="second">All Task</a>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="first">
              <h3 class="ui header">Task/Reminders:</h3>
              <table class="ui inverted small compact table day">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Description</th>
                    <th>Date/Time</th>
                    <!-- <th class="two wide">Actions</th> -->
                  </tr>
                </thead>
                <tbody>
                @foreach($dtask as $dtask)
                  <tr>
                    <td>{{$dtask->event_name}}</td>
                    <td>{{$dtask->description}}</td>
                    <td>{{date("m/d/y h:i A", strtotime($dtask->date.' '.$dtask->time))}}</td>
               <!--      <td class="center aligned">
                      <div class="ui mini teal icon button" ><i class="pencil icon"></i></div>
                      <div class="ui mini red icon button"><i class="trash bin icon"></i></div>
                    </td> -->
                  </tr>
                @endforeach
                </tbody>
                <tfoot class="full-width">
                 <!--  <th colspan="4">
                    <div class="ui right floated mini primary labeled icon button addtask">
                      <i class="add icon"></i> Add Task
                    </div>
                  </th> -->
                </tfoot>
              </table>
            </div>
            <div class="ui bottom attached tab segment" data-tab="second">
              <h3 class="ui header">Task/Reminders:</h3>
              <table class="ui inverted small compact table all">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Description</th>
                    <th>Date/Time</th>
                    <!-- <th class="two wide">Actions</th> -->
                  </tr>
                </thead>
                <tbody>
                @foreach($atask as $atask)
                  <tr>
                    <td>{{$atask->event_name}}</td>
                    <td>{{$atask->description}}</td>
                    <td>{{date("m/d/y h:i A", strtotime($atask->date.' '.$atask->time))}}</td>
                  <!--   <td class="center aligned">
                      <div class="ui mini teal icon button" ><i class="pencil icon"></i></div>
                      <div class="ui mini red icon button"><i class="trash bin icon"></i></div>
                    </td> -->
                  </tr>
                @endforeach
                </tbody>
                <tfoot class="full-width">
               <!--    <th colspan="4">
                    <div class="ui right floated mini primary labeled icon button addtask">
                      <i class="add icon"></i> Add Task
                    </div>
                  </th> -->
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- IN AND OUT TAB -->
    <!--   <div class="row">
        <div class="twelve wide column centered">
          <div class="ui stacked segment">
            <div class="ui top attached tabular menu outt">
              <a class="active item" data-tab="onee">Out</a>
              <a class="item" data-tab="twoo">In</a>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="onee">
              <h3 class="ui header">Out:</h3>
              <table class="ui inverted small compact table day">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Date/Time</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($out as $out)
                    <tr>
                      <td>{{$out->event_name}}</td>
                      <td>{{$out->event_dateTime}}</td>
                       <td><button type="button" class="ui small inverted blue icon button out"><i class="check icon"></i></button></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="ui bottom attached tab segment" data-tab="twoo">
              <h3 class="ui header">In:</h3>
              <table class="ui inverted small compact table all">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($in as $inn)
                    <tr>
                      <td>{{$inn->event_name}}</td>
                      <td><button type="button" id="{{$inn->event_id}}" class="ui small inverted blue icon button in"><i class="check icon"></i></button></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> -->
      <!-- END OF IN AND OUT TAB -->
      <div class="row">
        <div class="twelve wide column centered">
          <div class="ui stacked segment">
              <h3 class="ui header">Incoming:</h3>
              <table class="ui inverted small compact table day">
                <thead>
                  <tr>
                    <th>Event</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($incoming as $inc)
                    <tr>
                      <td>{{$inc->event_name}}</td>
                      <td>{{$inc->event_date}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('forms')
<div class="ui long modal" id="outact">
  <div class="header">
     Assign Equipments
  </div>
  <div class="content">
    <form class="ui form" id="out_form">
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
          <button class="ui primary button add" id="addCart">Add</button>
        </div>
      </div>
      <table id="inTable" class="ui basic compact table" style="width:100%">
        <thead>
          <tr>
            <th hidden>asd</th>
            <th class="three wide">Equipment</th>
            <th class="three wide">Available Qty</th>
            <th class="three wide">Out</th>
            <th class="three wide">Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Selected
      <i class="add icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
      </form>
    </div>
  </div>
</div>


<div class="ui long modal" id="inact">
  <div class="header">
     Assign Equipments
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="button">Add Selected
      <i class="add icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
  </div>
</div>

@endsection
