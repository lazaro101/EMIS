@extends('layouts.admin')

@section('title','Service Contact')

@section('script')
<script type="text/javascript" src="{{ asset('js/servicecontact.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/servicecat.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/table.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .table-cont {
    margin-top: 20px;
  }
  .table-cont tr th {
    color: white !important;
  }
  .ui.header.tbl, .ui.header.tbl .ui.sub.header {
    color:white;
  }
</style>
@endsection

@section('content')
  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="call icon"></i>
      <div class="content">Services</div>
    </h1>
    <div class="ui clearing divider"></div>

    <div class="ui top attached tabular menu">
      <a class="@if(!isset($_GET['tab'])) active @endif item" data-tab="first">Contacts</a>
      <a class="@if(isset($_GET['tab'])) active @endif item" data-tab="second">Category</a>
    </div>

    <div class="ui bottom attached @if(!isset($_GET['tab'])) active @endif tab segment" data-tab="first"> 
      <button class="large green ui labeled icon button" id="addservice">
        <i class="add square icon"></i>Add Contact
      </button>
      <div class="table-cont ser">
        <table class="ui selectable fixed single line table inverted compact">
          <thead class="full-width">
            <tr>
              <th class="four wide">Service Name</th>
              <th class="three wide">Owner</th>
              <th class="four wide">Address</th>
              <th class="two wide">Price</th>
              <th class="center aligned two wide">Action</th>
            </tr>
          </thead>
          <tbody>        
          @foreach ($contact as $contact)
            <tr>
              <td>
                <h5 class="ui header tbl">
                  <div class="content">
                    <span class="name">{{ $contact->services_contact_name }}</span>
                    <div class="ui sub header">{{ $contact->services_name }}</div>
                </h5>
              </td>
              <td>
                <h5 class="ui header tbl">
                  <div class="content">
                    {{ $contact->services_contact_owner }}
                    <div class="ui sub header">{{ $contact->services_contact_number1 }}</div>
                </h5>
              </td>
              <td>{{ $contact->street }} {{ $contact->barangay }} {{ $contact->city }} {{ $contact->province }}</td>
              <td>&#8369; {{number_format($contact->services_contact_price, 2)}}@if($contact->price_type == 1) per hr. @else flat @endif</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editservice" type="button" data-id="{{ $contact->services_contact_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button delservice" type="button" data-id="{{ $contact->services_contact_id }}"><i class="trash bin icon"></i></button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="ui bottom attached @if(isset($_GET['tab'])) active @endif tab segment" data-tab="second">
      <button class="large green ui labeled icon button" id="addctgry">
        <i class="add square icon"></i>Add Category
      </button>
      <div class="table-cont cat">
        <table class="ui selectable fixed single line table inverted compact">
          <thead class="full-width">
            <tr>
              <th class="six wide">Service Name</th>
              <th class="seven wide">Service Description</th>
              <th class="center aligned two wide">Action</th>
            </tr>
          </thead>
          <tbody>
          @php $services = $service @endphp
          @foreach ($services as $services)
            <tr> 
              <td class="name">{{ $services->services_name }}</td>
              <td>{{ $services->services_description }}</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editcat" type="button" data-id="{{ $services->services_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button delcat" type="button" data-id="{{ $services->services_id }}"><i class="trash bin icon"></i></button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteServiceContact" id="deletecontact">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui long modal" id="addcontact">
  <div class="header">Add Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/addServiceContact">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    
    <div class="required field">
      <label>Service Name:</label>
      <input type="text" placeholder="Text Input..." name="contactName">
    </div>
    <div class="eight wide column required field">
      <label>Service Category:</label>
      <select name="contactCtgry" class="ui search dropdown drpdwn">
        <option value="">Category</option>
        @php $service1 = $service @endphp
        @foreach ($service1 as $service1)
          <option value="{{ $service1->services_id }}">{{ $service1->services_name }}</option>
        @endforeach
      </select>
    </div>
    <div class="four fields">
      <div class="field">
        <label>No. and Street:</label>
          <input type="text" placeholder=" " name="street">
      </div>
      <div class="field">
        <label>Barangay:</label>
          <input type="text" placeholder=" " name="barangay">
      </div>
      <div class="field">
        <label>City:</label>
          <input type="text" placeholder=" " name="city">
      </div>
      <div class="field">
        <label>Province:</label>
          <input type="text" placeholder=" " name="province">
      </div>
    </div>
    <div class="required field">
      <label>Owner Name:</label>
      <input type="text" placeholder="Name" name="contactOwner">
    </div>
    <div class="two fields">
      <div class="six wide column required field">
        <label>Contact Number 1:</label>
        <input type="text" placeholder="" size="11" name="contactNumber1">
      </div>
      <div class="six wide column field">
        <label>Contact Number 2:</label>
        <input type="text" placeholder="" size="11" name="contactNumber2">
      </div>
    </div>
    <div class="six wide column required field">
      <label>Price:</label>
      <div class="ui right labeled input">
        <div class="ui label">&#8369;</div>
          <input type="number" min=0 class="price" placeholder="Amount" name="contactPrice">
          <div class="ui dropdown drpdwn type label" tabindex="0">
            <input type="hidden" name="pricetype" value="1">
            <div class="text">Rate per hr.</div>
            <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
              <div class="item active selected" data-value="1">Rate per hr.</div>
              <div class="item" data-value="2">Flat cost</div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Service
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>
<div class="ui long modal" id="editcontact">
  <div class="header">Edit Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/editServiceContact">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="contactId" id="contactId">
    <input type="hidden" name="dupcontactName" id="dupcontactName">
      <div class="required field">
        <label>Service Name:</label>
        <input type="text" placeholder="Text Input..." name="contactName" id="contactName">
      </div>
      <div class="eight wide column required field">
      <label>Service Category:</label>
        <select name="contactCtgry" class="ui search dropdown drpdwn">
          <option value="">Category</option>
          @php $service2 = $service @endphp
          @foreach ($service2 as $service2)
            <option value="{{ $service2->services_id }}">{{ $service2->services_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="four fields">
          <div class="field">
            <label>No. and Street:</label>
              <input type="text" placeholder=" " name="street">
          </div>
          <div class="field">
            <label>Barangay:</label>
              <input type="text" placeholder=" " name="barangay">
          </div>
          <div class="field">
            <label>City:</label>
              <input type="text" placeholder=" " name="city">
          </div>
          <div class="field">
            <label>Province:</label>
              <input type="text" placeholder=" " name="province">
          </div>
      </div>
      <div class="required field">
        <label>Owner Name:</label>
        <input type="text" placeholder="Name" name="contactOwner">
      </div>
      <div class="two fields">
        <div class="six wide column required field">
          <label>Contact Number 1:</label>
          <input type="text" placeholder="" size="11" name="contactNumber1">
        </div>
        <div class="six wide column field">
          <label>Contact Number 2:</label>
          <input type="text" placeholder="" size="11" name="contactNumber2">
        </div>
      </div>
    <div class="six wide column required field">
      <label>Price:</label>
      <div class="ui right labeled input">
        <div class="ui label">&#8369;</div>
          <input type="number" min=0 class="price" placeholder="Amount" name="contactPrice">
          <div class="ui dropdown drpdwn label type" tabindex="0">
            <input type="hidden" name="pricetype">
            <div class="text">Sample Text</div>
            <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
              <div class="item" data-value="1">Rate per hr.</div>
              <div class="item " data-value="2">Flat cost</div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save Changes
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>

<form method="post" action="/deleteServices" id="deletecat">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addcat">
  <div class="header">Add Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/addServices">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <div class="required field">
          <label>Service Name:</label>
          <input type="text" placeholder="Text Input..." name="serviceName">
        </div>
        <div class="field">
          <label>Description:</label>
          <textarea rows="2" name="serviceDescription"></textarea>
        </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Service
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>
<div class="ui small modal" id="editcat">
  <div class="header">Edit Service</div>
  <div class="content">
    <form class="ui form" method="post" action="/editServices">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="serviceId">
    <input type="hidden" name="dupserviceName">
        <div class="required field">
          <label>Service Name:</label>
          <input type="text" placeholder="Text Input..." name="serviceName">
        </div>
        <div class="field">
          <label>Description:</label>
          <textarea rows="2" name="serviceDescription"></textarea>
        </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Save Changes
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>

<div class="ui basic modal">
  <div class="ui icon header">
    <i class="warning sign icon"></i>
    Delete item "<span class="item"></span>"?
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