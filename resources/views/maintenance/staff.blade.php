@extends('layouts.admin')

@section('title','Staff')

@section('script')
<script type="text/javascript" src="{{ asset('js/staff.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/profession.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>

@endsection

@section('style')
<style type="text/css">
  .table-cont {
    margin-top: 20px;
  }
  .table-cont tr th {
    color: white !important;
  }
  .ui.image.header .content, .ui.image.header .content .sub.header {
    color:white;
  }
  img.profile {
    min-width: 25em;
    min-height: 25em;
  }
  .tbprofile{
    width: 2em !important;
    height: 2em !important;
  }
</style>
@endsection

@section('content')
  <div class="ui right floated raised basic segment content">
    
    <h1 class="ui right floated header">
      <i class="users icon"></i>
      <div class="content">Staff</div>
    </h1>
   
    <div class="ui clearing divider"></div>

    <div class="ui top attached tabular menu">
      <a class="@if(!isset($_GET['tab'])) active @endif item" data-tab="first">Staff</a>
      <a class="@if(isset($_GET['tab'])) active @endif item" data-tab="second">Profession</a>
    </div>

    <div class="ui bottom attached @if(!isset($_GET['tab'])) active @endif tab segment" data-tab="first"> 
      <button class="large green ui labeled icon button" id="addsta">
        <i class="add square icon"></i>Add Staff
      </button>
      <div class="table-cont">
        <table class="ui unstackable selectable fixed single line small table compact inverted">
          <thead class="full-width">
            <tr>
              <th class="seven wide">Staff Name</th>
              <th class="three wide">Profession</th>
              <th class="three wide">Contact</th>
              <th class="center aligned two wide">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($employee as $staff) 
            <tr>
              <td>
                <h4 class="ui image header">
                  <img src="/image/ProfilePictures/{{ $staff->staff_img }}" class="ui big circular image tbprofile">
                  <div class="content name">
                    {{ $staff->staff_fname }} {{ $staff->staff_lname }}  
                  </div>
                </h4>
              </td>
              <td>{{ $staff->staff_profession_description }}</td>
              <td>{{ $staff->staff_contact }}</td>
              <td class="center aligned">
                <button class="ui small inverted green icon button view" type="button" data-id="{{ $staff->staff_id }}"><i class="circle info icon"></i></button>
                <button class="ui small inverted blue icon button editstaff" type="button" data-id="{{ $staff->staff_id }}"><i class="write icon"></i></button>
                <button class="ui small inverted negative icon button delstaff" type="button" data-id="{{ $staff->staff_id }}"><i class="trash bin icon"></i></button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="ui bottom attached @if(isset($_GET['tab'])) active @endif tab segment" data-tab="second"> 
      <button class="large green ui labeled icon button" id="addprof">
        <i class="add square icon"></i>Add Profession
      </button>
      <div class="table-cont">
        <table class="ui selectable table inverted compact sortable">
          <thead class="full-width">
            <tr>
              <th class="nine wide">Description</th>
              <th class="center aligned two wide">No. of Staff</th>
              <th class="center aligned two wide">Actions</th>
            </tr>
          </thead>
          <tbody>
          @php $profession = $prof @endphp
          @foreach ($profession as $profession)
            <tr>
              <td class="name">{{ $profession->staff_profession_description }}</td>
              <td class="center aligned">{{ $profession->subcount }}</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editprof" type="button" data-id="{{ $profession->staff_profession_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button delprof" type="button" data-id="{{ $profession->staff_profession_id }}"><i class="trash bin icon"></i></button>
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
<form method="post" action="/deleteStaff" id="deletestaff">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui long modal" id="addstaff">
  <div class="header">Add Staff</div>
  <div class="content">
    <form class="ui form" method="post" action="/addStaff" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Name: </label>
        <div class="two fields">
          <div class="field">
            <input type="text" name="fname" placeholder="First Name">
          </div>
          <div class="field">
            <input type="text" name="lname" placeholder="Last Name">
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="fourteen wide field">
          <label>Profile Picture:</label>
          <input type="file" name="profilepic" accept="image/*" class="addpic">
        </div>
        <div class="two wide field">
          <label>&nbsp;</label>
          <div class="ui negative basic button removepic">Remove</div>
        </div>
      </div>
      <div class="ui two column centered grid" style="padding: 20px;">
        <div class="column">
          <div class="ui medium centered image">
            <img class="ui circular image profile" src="/generalpics/profilepreview.png">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <div class="eight wide column required field">
      <label>Profession:</label>
        <select name="profession" class="ui search dropdown drpdwn">
          <option value="">Category</option>
          @php $prof1 = $prof @endphp
          @foreach($prof1 as $prof1)
          <option value="{{ $prof1->staff_profession_id }}">{{ $prof1->staff_profession_description }}</option>
          @endforeach
        </select>
      </div>
      <div class="three fields">
        <div class="six wide column required field">
          <label>Birthdate: </label>
          <div class="field">
            <div class="ui calendar">
              <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" placeholder="Date" name="birthdate">
              </div>
            </div>
          </div>
        </div>
        <div class="three wide column required field">
          <label>Gender:</label>
          <div class="ui selection dropdown drpdwn">
            <input type="hidden" name="gender">
            <i class="dropdown icon"></i>
            <span class="default text">Gender</span>
            <div class="menu">
              <div class="item" data-value="Male">
                <i class="man icon"></i>
                Male
              </div>
              <div class="item" data-value="Female">
                <i class="woman icon"></i>
                Female
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="required four fields">
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
      <div class="six wide column required field">
        <label>Contact Number:</label>
        <input type="text" placeholder="" name="number">
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
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Staff
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
    </form>
  </div>  
</div>
<div class="ui long modal" id="editstaff">
  <div class="header">Edit Staff Information</div>
  <div class="content">
    <form class="ui form" method="post" action="/editStaff" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="id" class="id">
      <div class="required field">
        <label>Name: </label>
        <div class="two fields">
          <div class="field">
            <input type="text" name="fname" placeholder="First Name" class="fname">
          </div>
          <div class="field">
            <input type="text" name="lname" placeholder="Last Name" class="lname">
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="fourteen wide field">
          <label>Profile Picture:</label>
          <input type="file" name="profilepic" accept="image/*" class="editpic">
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
            <img class="ui circular image profile" src="/image/ProfilePictures/preview.png">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <div class="eight wide column required field">
      <label>Profession:</label>
        <select name="profession" class="ui search dropdown drpdwn">
          <option value="">Category</option>
          @php $prof2 = $prof @endphp
          @foreach($prof2 as $prof2)
          <option value="{{ $prof2->staff_profession_id }}">{{ $prof2->staff_profession_description }}</option>
          @endforeach
        </select>
      </div>
      <div class="three fields">
        <div class="six wide column required field">
          <label>Birthdate: </label>
          <div class="field">
            <div class="ui calendar">
              <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" placeholder="Date" name="birthdate">
              </div>
            </div>
          </div>
        </div>
        <div class="three wide column required field">
          <label>Gender:</label>
          <div class="ui selection dropdown drpdwn">
            <input type="hidden" name="gender">
            <i class="dropdown icon"></i>
            <span class="default text">Gender</span>
            <div class="menu">
              <div class="item" data-value="Male">
                <i class="man icon"></i>
                Male
              </div>
              <div class="item" data-value="Female">
                <i class="woman icon"></i>
                Female
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="required four fields">
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
      <div class="eight wide column required field">
        <label>Contact Number:</label>
        <input type="text" placeholder="" name="number">
      </div>
      <div class="six wide column required field">
        <label>Rate:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
            <input type="number" min="0" placeholder="Amount" name="rate">
          <div class="ui basic label">per hr.</div>
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

<form method="post" action="/deleteProfession" id="deleteprofession">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addprofession">
  <div class="header">Add Profession</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addProfession">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Profession Description:</label>
        <input type="text" placeholder="Text Input..." name="professionName">
      </div>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon active addbtn" type="submit">Add Profession
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editprofession">
  <div class="header">Edit Profession</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editProfession">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="professionId">
      <div class="required field">
        <label>Description:</label>
        <input type="text" placeholder="Text Input..." name="professionName">
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

<div class="ui long modal" id="viewform">
  <div class="header">
    Staff Profile
  </div>
  <div class="image content">
    <div class="ui medium image">
      <img class="pic ui circular image" style="min-height: 20em">
    </div>
    <div class="description">
      <div class="ui header"><span class="fname"></span> <span class="lname"></span></div>
      <div class="ui violet medium labels">
        <p><span class="ui horizontal label">Profession:</span> <span class="profession"></span></p>
        <p><span class="ui horizontal label">Birthdate:</span> <span class="bday"></span></p>
        <p><span class="ui horizontal label">Age:</span> <span class="age"></span></p>
        <p><span class="ui horizontal label">Gender:</span> <span class="gender"></span></p>
        <p><span class="ui horizontal label">Address:</span> <span class="address"></span></p>
        <p><span class="ui horizontal label">Cell Phone Number:</span> <span class="number"></span></p>
        <p><span class="ui horizontal label">Rate:</span> <span class="rate"></span>/hr</p>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button">
      OK
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>

<div class="ui basic modal">
  <div class="ui icon header">
    <i class="warning sign icon"></i>
    Delete <span class="item"></span>?
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