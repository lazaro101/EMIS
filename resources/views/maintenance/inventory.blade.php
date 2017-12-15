@extends('layouts.admin')

@section('title','Equipment Inventory')

@section('script')
  <script type="text/javascript" src="{{ asset('js/inventory.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/equipmenttype.js') }}"></script>
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
  .medium.message {

  }
</style>
@endsection

@section('content')
  <div class="ui raised basic segment content">
    <h1 class="ui right floated header">
      <i class="archive icon"></i>
      <div class="content">Inventory</div>
    </h1>
    <div class="ui clearing divider"></div>

    <div class="ui top attached tabular menu">
      <a class="@if(!isset($_GET['tab'])) active @endif item" data-tab="first">Equipment</a>
      <a class="@if(isset($_GET['tab'])) active @endif item" data-tab="second">Type</a>
    </div>

    <div class="ui bottom attached @if(!isset($_GET['tab'])) active @endif tab segment" data-tab="first"> 
      <button class="large green ui labeled icon button" id="addequip">
        <i class="add square icon"></i>Add Equipment
      </button>
      <div class="table-cont">
        <table class="ui selectable fixed single line small table compact inverted">
          <thead class="full-width">
            <tr>
              <th class="four wide">Name</th>
              <th class="four wide">Type</th>
              <th class="four wide">Description</th>
              <th class="two wide">Qty.</th>
              <th class="center aligned two wide">Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($equipment as $equipment)
            <tr> 
              <td>{{ $equipment->equipment_inventory_name }}</td>
              <td>{{ $equipment->equipment_type_description}}</td>
              <td>{{ $equipment->equipment_inventory_description }}</td>
              <td>{{ $equipment->equipment_inventory_qty }}</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editequip" type="button" data-id="{{ $equipment->equipment_inventory_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button deleteequip" type="button" data-id="{{ $equipment->equipment_inventory_id }}"><i class="trash bin icon"></i></button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="ui bottom attached @if(isset($_GET['tab'])) active @endif tab segment" data-tab="second"> 
      <button class="large green ui labeled icon button" id="addtype">
        <i class="add square icon"></i>Add Type
      </button>
      <div class="table-cont">
        <table class="ui selectable fixed single line small table compact inverted">
          <thead class="full-width">
            <tr>
              <th class="four wide">Name</th>
              <th class="center aligned two wide">Actions</th>
            </tr>
          </thead>
          <tbody>
          @php $eqtype = $type @endphp
          @foreach ($eqtype as $eqtype)
            <tr> 
              <td>{{ $eqtype->equipment_type_description }}</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button edittype" type="button" data-id="{{ $eqtype->equipment_type_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button deletetype" type="button" data-id="{{ $eqtype->equipment_type_id }}"><i class="trash bin icon"></i></button>
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
<form method="post" action="/deleteEquipmentInventory" id="deleteequipment">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addequipment">
  <div class="header">Add Equipment</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addEquipmentInventory">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Equipment Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="field">
        <label>Equipment Description:</label>
        <textarea name="description" rows="5"></textarea>
      </div>
      <div class="six wide field">
      <label>Equipment Type:</label>
        <select name="type" class="ui search dropdown drpdwn">
          <option value="">Type</option>
          @php $type1 = $type @endphp
          @foreach ($type1 as $type1)
            <option value="{{ $type1->equipment_type_id }}">{{ $type1->equipment_type_description }}</option>
          @endforeach
        </select>
      </div>
      <div class="six wide field">
        <label>Quantity</label>
        <input type="number" name="quantity">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Equipment
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editequipment">
  <div class="header">Edit Equipment</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editEquipmentInventory">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="dupname">
    <input type="hidden" name="id">
      <div class="required field">
        <label>Equipment Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
      <div class="field">
        <label>Equipment Description:</label>
        <textarea name="description" rows="5"></textarea>
      </div>
      <div class="six wide field">
      <label>Equipment Type:</label>
        <select name="type" class="ui search dropdown drpdwn">
          <option value="">Type</option>
          @php $type2 = $type @endphp
          @foreach ($type2 as $type2)
            <option value="{{ $type2->equipment_type_id }}">{{ $type2->equipment_type_description }}</option>
          @endforeach
        </select>
      </div>
      <div class="six wide field">
        <label>Quantity</label>
        <input type="number" name="quantity">
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


<form method="post" action="/deleteEquipmentType" id="deleteequipmenttype">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui small modal" id="addequipmenttype">
  <div class="header">Add Equipment Type</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addEquipmentType">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Equipment Type Name:</label>
        <input type="text" placeholder="Text Input..." name="name">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Type
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editequipmenttype">
  <div class="header">Edit Equipment Type</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editEquipmentType">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="id" class="id">
      <div class="required field">
        <label>Equipment Type Name:</label>
        <input class="name" type="text" placeholder="Text Input..." name="name">
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
    Delete this item?
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

@if (count($errors) > 0)
  <div class="ui error floating medium message msgbox valmsg" style="left:38em;top:3em">
    <i class="close icon" id="close"></i>
    <div class="header">Error Adding/Modfying Category!</div>
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
  </div>
@endif

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