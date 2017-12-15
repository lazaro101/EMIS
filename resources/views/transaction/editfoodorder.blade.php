@extends('layouts.admin')

@section('title','Food Order')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.print.css') }}" media="print">
<!-- <script src="{{ asset('Semantic/dist/fullcalendar/lib/jquery.min.js') }}"></script> -->
<script src="{{ asset('Semantic/dist/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('Semantic/dist/fullcalendar/fullcalendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.css') }}">
<script type="text/javascript" src="{{ asset('js/addfoodorder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
#addmenu .content{
  min-height: 500px;
}
</style>
@endsection
@section('content') 
  @foreach($fo as $fo)
  @endforeach
<div class="ui basic segment content">
  <form class="ui form main" method="post" action="/editFoodOrder">
  {{ csrf_field() }}
  <input type="hidden" name="foodorderid" value="{{$fo->food_order_id}}">

    <div class="ui stackable grid">
      <div class="row">
        <h2 class="ui right floated header">
          <i class="calendar outline icon"></i>
          <div class="content">Edit Order</div>
        </h2>
      </div>

      <div class="two column row">
        <div class="column">
          <div class="ui segment">
            <h4 class="ui horizontal divider header"><i class="calendar icon"></i>Order Details</h4>
            <div class="two fields">
              <div class="required field">
                <label>Delivery Date:</label>
                <div class="ui calendar date">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input placeholder="Date" name="date" value="{{$fo->food_order_date}}">
                  </div>
                </div>
              </div>
              <div class="required field">
                <label>Delivery Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input placeholder="Input..." name="time" value="{{$fo->food_order_time}}">
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label>Status:</label>
              <div class="ui selection dropdown status">
                <input type="hidden" name="status" value="{{$fo->status}}">
                <i class="dropdown icon"></i>
                <span class="default text">Select</span>
                <div class="menu">
                  <div class="item" data-value="Pending">
                    Pending
                  </div>
                  <div class="item" data-value="Completed">
                    Completed
                  </div>
                  <div class="item" data-value="Cancelled">
                    Cancelled
                  </div>
                </div>
              </div>
            </div>
            <div class="required field">
              <label>Delivery Address:</label>
              <textarea rows="3" name="address">{{$fo->food_order_address}}</textarea>
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
                  <input type="text" placeholder="Input..." name="fname" value="{{$fo->client_fname}}">
                </div>
                <div class="required field">
                  <label>Last Name:</label>
                  <input type="text" placeholder="Input..." name="lname" value="{{$fo->client_lname}}">
                </div>
              </div>
              <div class="two fields">
                <div class="required field">
                  <label>Cellphone Number:</label>
                  <input type="text" placeholder="Primary Number..." name="cpnum1" value="{{$fo->client_contact1}}">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="cpnum2" value="{{$fo->client_contact2}}">
                </div>
              </div>
              <div class="two fields">
                <div class="field">
                  <label>Telephone:</label>
                  <input type="text" placeholder="Primary Number..." name="telnum1" value="{{$fo->client_telephone1}}">
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <input type="text" placeholder="Secondary Number..." name="telnum2" value="{{$fo->client_telephone2}}">
                </div>
              </div>
              <div class="required field">
                <label>Email:</label>
                <input type="text" placeholder="Input..." name="email" value="{{$fo->client_email}}">
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
                <h4 class="ui horizontal divider header"><i class="user icon"></i>Food</h4>
              </div>
            </div>
            <div class="row">
              <div class="column">
                <table class="ui compact striped basic table foodmenu">
                  <thead>
                    <tr>
                      <th class="seven wide">Food</th>
                      <th class="three wide">Price</th>
                      <th class="three wide">Qty</th>
                      <th class="three wide">Total</th>
                      <th class="two wide"></th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($fom as $fom)
                    <tr>
                      <td>{{$fom->submenu_name}}<input type="hidden" name="submenu[]" value="{{$fom->submenu_id}}"></td>
                      <td class="price">₱ {{$fom->submenu_price}}</td>
                      <td><div class="field"><input type="number" name="qty[]" value="{{$fom->qty}}"></div></td>
                      <td><span class="total">₱ {{number_format($fom->subtotal,2)}}</span><input type="hidden" name="subtotal[]" value="{{$fom->subtotal}}"></td>
                      <td><div class="ui negative icon button remove"><i class="delete icon"></i></div></td>
                    </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5"><div class="ui primary right floated button browse">Browse Menu</div></th>
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
                <h4 class="ui horizontal divider header"><i class="credit card icon"></i>Payment Information</h4>
              </div>
            </div>
            <div class="two column row">
              <div class="column">
                <div class="ui button">Send Confirmation Email</div>
              </div>
              <div class="column">
                <table class="ui basic small compact table payment">
                  <tr class="right aligned">
                    <td>Total:</td>
                    <td class="total">&#8369; {{number_format($fo->total,2)}}</td>
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
            <a class="ui black reset deny button" href="/Admin/Transaction/Food-Order"><i class="arrow left icon"></i>Back</a>
            <button class="ui positive submit button labeled icon right floated addbtn" type="submit">Save
            <i class="plus icon"></i></button>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@section('forms')
<div class="ui long modal" id="addmenu">
  <div class="header">
    Menu
  </div>
  <div class="content">
    <table class="ui very basic table">
      <thead>
        <tr>
          <th class="two wide"></th>
          <th class="nine wide">Food Name</th>
          <th class="three wide">Category</th>
          <th class="two wide">Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($menu as $menu)
        <tr>
          <td class="center aligned chkbox">
            <div class="ui checkbox">
              <input type="checkbox" name="submenuid" class="checkbox" value="{{$menu->submenu_id}}">
              <label></label>
            </div>
          </td>
          <td class="name">{{$menu->submenu_name}}</td>
          <td class="ctgry">{{$menu->submenu_category_name}}</td>
          <td class="price">&#8369; {{number_format($menu->submenu_price,2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
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