@extends('layouts.admin')

@section('title','Location')

@section('script')
<script type="text/javascript" src="{{ asset('js/location.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .head {
    margin-top: 20px;
  }
  .table-cont {
    margin-top: 20px;
  }
  .table-cont tr th {
    color: white !important;
  }
</style>
@endsection

@section('content')

  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="map icon"></i>
      <div class="content">Location</div>
    </h1>
    <button class="large green ui labeled icon button" id="addLocation">
      <i class="add square icon"></i>Add Location
    </button>
    <div class="ui clearing divider"></div>

    <div class="table-cont">
      <table class="ui selectable table fixed single line inverted compact">
        <thead class="full-width">
          <tr>
            <th class="four wide">Location</th>
            <th class="three wide">Owner</th>
            <th class="three wide">Contact</th>
            <th class="two wide">Max. Cap.</th>
            <th class="center aligned two wide">Actions</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($location as $Location)
          <tr> 
            <td class="name">{{ $Location->location_name }}</td>
            <td>{{ $Location->location_owner }}</td>
            <td>{{ $Location->location_contact1 }}</td>
            <td>{{ $Location->location_max }}</td>
            <td class="center aligned">
              <button class="ui small inverted blue icon button edit" type="button" data-id="{{ $Location->location_id }}"><i class="pencil icon"></i></button>
              <button class="ui small inverted negative icon button delbtn" type="button" data-id="{{ $Location->location_id }}"><i class="trash bin icon"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
@endsection

@section('forms')
<form method="post" action="/deleteLocation" id="delete-form">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui long modal" id="addform">
  <div class="header">Add Location</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addLocation" name="addform" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field" id="ctgryName">
        <label>Location Name:</label>
        <input type="text" placeholder="Text Input..." name="locname">
      </div>
      <div class="required field">
        <label>Owner Name:</label>
        <input type="text" placeholder="Text Input..." name="ownername">
      </div>
      <div class="two fields">
        <div class="six wide column required field">
          <label>Contact Number 1:</label>
          <input type="text" placeholder="" name="contactNumber1">
        </div>
        <div class="six wide column field">
          <label>Contact Number 2:</label>
          <input type="text" placeholder="" name="contactNumber2">
        </div>
      </div>
      <div class="field">
        <label>Image:</label>
        <input type="file" name="uploadpic" accept="image/*" class="addpic">
      </div>
      <div class="ui two column centered grid" style="padding: 20px;">
        <div class="column">
          <div class="ui medium centered image">
            <img class="ui rounded image" src="/image/LocationImages/preview.png">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="required field">
          <label>No. and Street:</label>
            <input type="text" placeholder=" " name="street">
        </div>
        <div class="required field">
          <label>Barangay:</label>
            <input type="text" placeholder=" " name="barangay">
        </div>
        <div class="required field">
          <label>City:</label>
            <input type="text" placeholder=" " name="city">
        </div>
        <div class="required field">
          <label>Province:</label>
          <input type="text" placeholder=" " name="province">
        </div>
      </div>
      <div class="four wide column required field">
        <label>Max Capacity:</label>
          <input type="text" class="price" placeholder="Amount" name="cap">
      </div>
      <div class="six wide column required field">
        <label>Rate:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
            <input type="number" min=0 class="price" placeholder="Amount" name="rate">
          <div class="ui basic label">per hr.</div>
        </div>
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Location
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>

<div class="ui long modal" id="editform">
  <div class="header">Edit Location</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editLocation" name="addform" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="locid">
    <input type="hidden" name="duplocname">
      <div class="required field" id="ctgryName">
        <label>Location Name:</label>
        <input type="text" placeholder="Text Input..." name="locname">
      </div>
      <div class="required field">
        <label>Owner Name:</label>
        <input type="text" placeholder="Text Input..." name="ownername">
      </div>
      <div class="two fields">
        <div class="six wide column required field">
          <label>Contact Number 1:</label>
          <input type="text" placeholder="" name="contactNumber1">
        </div>
        <div class="six wide column field">
          <label>Contact Number 2:</label>
          <input type="text" placeholder="" name="contactNumber2">
        </div>
      </div>
      <div class="two fields">
        <div class="fourteen wide field">
          <label>Image:</label>
          <input type="file" name="uploadpic" accept="image/*" class="editpic">
        </div>
        <div class="two wide field">
          <label>&nbsp;</label>
          <div class="ui negative basic button removepic">Remove</div>
        </div>
      </div>
      <input type="hidden" name="tempImage">
      <div class="ui two column centered grid" style="padding: 20px;">
        <div class="column">
          <div class="ui medium centered image">
            <img class="ui rounded image" src="/image/LocationImages/preview.png">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="required field">
          <label>No. and Street:</label>
            <input type="text" placeholder=" " name="street">
        </div>
        <div class="required field">
          <label>Barangay:</label>
            <input type="text" placeholder=" " name="barangay">
        </div>
        <div class="required field">
          <label>City:</label>
            <input type="text" placeholder=" " name="city">
        </div>
        <div class="required field">
          <label>Province:</label>
          <input type="text" placeholder=" " name="province">
        </div>
      </div>
      <div class="four wide column required field">
        <label>Max Capacity:</label>
          <input type="text" class="price" placeholder="Amount" name="cap">
      </div>
      <div class="six wide column required field">
        <label>Rate:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
            <input type="number" min=0 class="price" placeholder="Amount" name="rate">
          <div class="ui basic label">per hr.</div>
        </div>
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Save Changes
      <i class="pencil icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
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