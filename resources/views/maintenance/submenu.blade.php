@extends('layouts.admin')

@section('title','Submenu')

@section('script')
<script type="text/javascript" src="{{ asset('js/submenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/submenucategory.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
  .head {
    margin-top: 20px;
  } 
  .table-cont tr th {
    color: white !important;
  }
  .content.table {
    color:white;
  }
  .table-cont {
    margin-top: 20px;
  }
  img.upimage{
    min-height: 25em;
    min-width: 30em;
  }
</style>
@endsection

@section('content')
  <div class="ui raised basic segment content"> 
    <div class="masthead">
    <h1 class="ui right floated header">
      <i class="food icon"></i>
      <div class="content">Submenu</div>
    </h1>
    <div class="ui clearing divider"></div>
    </div>
    
    <div class="ui top attached tabular menu">
      <a class="@if(!isset($_GET['tab'])) active @endif item" data-tab="first">Food</a>
      <a class="@if(isset($_GET['tab'])) active @endif item" data-tab="second">Category</a>
    </div>

    <div class="ui bottom attached @if(!isset($_GET['tab'])) active @endif tab segment" data-tab="first"> 
      <button class="large green ui labeled icon button" id="addsub">
        <i class="add square icon"></i>Add Food
      </button>
      <div class="table-cont food">
        <table class="ui selectable fixed single line small table compact inverted">
          <thead class="full-width">
            <tr>
              <th class="four wide">Food</th>
              <th class="two wide">Category</th>
              <th class="four wide">Description</th>
              <th class="two wide">Price</th>
              <th class="two wide">Status</th>
              <th class="center aligned two wide">Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($submenu as $submenu)
            <tr>
              <td>
                <h4 class="ui image header">
                  <img src="/image/FoodImages/{{$submenu->submenu_img}}" class="ui large rounded image">
                    <div class="content table name">
                      {{ $submenu->submenu_name }}
                  </div>
                </h4>
              </td>
              <td>{{ $submenu->submenu_category_name }}</td>
              <td>{{ $submenu->submenu_description }}</td>
              <td>₱ {{ number_format($submenu->submenu_price, 2) }}</td>
              <td class="center aligned">
                <div class="ui toggle checkbox">
                  <input type="checkbox" value="{{$submenu->submenu_id}}" @if($submenu->submenu_status == 0) checked @endif> 
                  <label></label>
                </div>
              </td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editfood" type="button" data-id="{{ $submenu->submenu_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button delfood" type="button" data-id="{{ $submenu->submenu_id }}"><i class="trash bin icon"></i></button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="ui bottom attached @if(isset($_GET['tab'])) active @endif tab segment" data-tab="second">
      <button class="large green ui labeled icon button" id="addcat">
        <i class="add square icon"></i>Add Category
      </button>
      <div class="table-cont">
        <table class="ui table inverted compact">
          <thead class="full-width">
            <tr>
              <th class="ten wide">Category</th>
              <th class="center aligned two wide">No. of foods</th>
              <th class="center aligned two wide">Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($category as $category)
            <tr> 
              <td class="name">{{ $category->submenu_category_name }}</td>
              <td class="center aligned">{{ $category->subcount }}</td>
              <td class="center aligned">
                <button class="ui small inverted blue icon button editctgry" type="button" data-id="{{ $category->submenu_category_id }}"><i class="pencil icon"></i></button>
                <button class="ui small inverted negative icon button delctgry" type="button" data-id="{{ $category->submenu_category_id }}"><i class="trash bin icon"></i></button>
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
<form method="post" action="/deleteSubmenu" id="deletefood">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>
<div class="ui long modal" id="addfood">
  <div class="header">Add Food</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/addSubmenu" enctype="multipart/form-data">
    {{ csrf_field() }}
      <div class="required field">
        <label>Food Name:</label>
        <input type="text" placeholder="Text Input..." name="submenuName">
      </div>
      <div class="field">
        <label>Description:</label>
        <textarea rows="2" class="desc" name="submenuDesc"></textarea>
      </div>
      <div class="two fields">
        <div class="fourteen wide field">
          <label>Image:</label>
          <input type="file" name="submenuImage" class="addpic">
        </div>
        <div class="two wide field">
          <label>&nbsp;</label>
          <div class="ui negative basic button removepic">Remove</div>
        </div>
      </div>
      <div class="ui two column centered grid" style="padding: 20px;">
        <div class="column">
          <div class="ui medium centered image">
            <img class="ui image rounded upimage" src="/image/FoodImages/preview.png">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <div class="eight wide column required field">
        <label>Category:</label>
          <select name="submenuCtgry" class="ui search dropdown drpdwn">
            <option value="">Category</option>
            @foreach ($ctgry as $ctgry)
              <option value="{{ $ctgry->submenu_category_id }}">{{ $ctgry->submenu_category_name }}</option>
            @endforeach
          </select>
      </div>
      <div class="six wide column required field">
        <label>Price:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
            <input type="number" min=0 placeholder="Amount" name="submenuPrice">
          <div class="ui basic label">per head</div>
        </div>
      </div>
    </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive button labeled icon addbtn" type="submit"><i class="plus icon"></i>Add Food</button>
      <div class="or"></div>
      <button class="ui black deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui long modal" id="editfood">
  <div class="header">Edit Food</div>
    <div class="content"> 
    <form class="ui form" method="post" action="/editSubmenu" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="submenuId">
    <input type="hidden" name="dupsubmenuName">
      <div class="required field">
        <label>Food Name:</label>
        <input type="text" placeholder="Text Input..." name="submenuName">
      </div>
      <div class="field">
        <label>Description:</label>
        <textarea rows="2" name="submenuDesc"></textarea>
      </div>
      <div class="two fields">
        <div class="fourteen wide field">
          <label>Image:</label>
          <input type="file" name="submenuImage" class="editpic">
        </div>
        <div class="two wide field">
          <label>&nbsp;</label>
          <div class="ui negative basic button removepic">Remove</div>
        </div>
      </div>
      <div class="ui two column centered grid" style="padding: 20px;">
        <div class="column">
          <div class="ui medium centered image">
            <img class="ui image rounded upimage">
            <div class="ui violet ribbon label">
              <i class="upload icon"></i> Uploaded image:
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="tempImage">
      <div class="eight wide column required field">
        <label>Category:</label>
          <select name="submenuCtgry" class="ui search dropdown drpdwn">
            <option value="">Category</option>
            @foreach ($ctgry1 as $ctgry1)
              <option value="{{ $ctgry1->submenu_category_id }}">{{ $ctgry1->submenu_category_name }}</option>
            @endforeach
          </select>
      </div>
      <div class="six wide column required field">
        <label>Price:</label>
        <div class="ui right labeled input">
          <div class="ui label">&#8369;</div>
            <input type="number" min=0 placeholder="Amount" name="submenuPrice">
          <div class="ui basic label">per head</div>
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

<form method="post" action="/deleteSubmenuCategory" id="deletectgry">
{{ csrf_field() }}
<input type="hidden" name="id">
</form>

<div class="ui small modal" id="addctgry">
  <div class="header">Add Food Category</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/addSubmenuCategory" name="addform">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
      <div class="required field">
        <label>Category Name:</label>
        <input type="text" placeholder="Text Input..." name="categoryName" class="addname">
      </div>
  </div>
  <div class="actions">
    <div class="ui buttons">
      <button class="ui positive submit button labeled icon active addbtn" type="submit">Add Category
      <i class="plus icon"></i></button>
      <div class="or"></div>
      <button class="ui black reset deny button cancelbtn" type="reset">Cancel</button>
    </div>
      </form>
  </div>  
</div>
<div class="ui small modal" id="editctgry">
  <div class="header">Edit Food Category</div>
  <div class="content"> 
    <form class="ui form" method="post" action="/editSubmenuCategory">
    <input type="hidden" name="_token" value="{{ csrf_token()}}">
    <input type="hidden" name="categoryId" class="id">
      <div class="required field">
        <label>Category Name:</label>
        <input class="name" type="text" placeholder="Text Input..." name="categoryName">
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