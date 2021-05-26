@extends('layouts.web')

@section('title','Contact Us')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.ui.calendar.date').calendar({
    // startMode: 'month',
      type: 'date'
    });
    $('.ui.calendar.time').calendar({
      type: 'time'
    });
  });
</script>
@endsection

@section('style')
<style type="text/css">  
.ui.text.masthead {
  min-height: 150px;
  padding: 20px;
  background-image: url('{{ asset('image/Website/hdrbg.jpg') }}');
}
.ui.text h1.ui.header{
  margin-top: 1em;
  text-align: center;
  font-size: 3em;
  font-weight: bold;
  font-family: harrington;
}
</style>
@endsection

@section('header')
<div class="ui container">
  <div class="ui large secondary pointing menu" style="border:none">
  <a href="/" class="header logo item"><img src="generalpics/blacklogo.png">Catering Name</a>
    <div class="right item"> 
    <a class="toc item">
      <i class="sidebar icon"></i>
    </a>
    <a href="/" class="item">Home</a>
    <a href="/Menus" class="item">Menus</a>
    <a href="/Package" class="item">Packages</a>
    <a href="" class="item">About Us</a>
    <a href="/Contact-Us" class="active item">Contact Us</a>
    </div>
  </div>
</div>

<div class="ui text masthead">
  <h1 class="ui header">Contact Us</h1>
</div>
@endsection

@section('content')
@foreach($gen as $gen)
@endforeach
  <div class="ui vertical stripe segment">
    <div class="ui stackable grid container">
      <div class="two column row">
        <div class="column">
          <div class="ui list">
            <div class="item">
              <i class="big marker icon"></i>
              <div class="content">
                <p>{{$gen->address.' '.$gen->barangay.', '.$gen->city.' City'.$gen->province}}</p>
              </div>
            </div>
            <div class="item">
              <i class="big phone icon"></i>
              <div class="content">
                <p>
                Telephone: {{$gen->contact_tele}}<br>
                Cellphone: {{$gen->contact_cell}}</p>
              </div>
            </div>
            <div class="item">
              <i class="big mail icon"></i>
              <div class="content">
                <p>{{$gen->contact_email}}</p>
              </div>
            </div>
          </div>
          <h2 class="ui header">Location Map</h2>
          <img src="image/Website/map.jpg" class="ui rounded big image">
        </div>

        <div class="column">
          <h3 class="ui header">Inquiry Form</h3>
          <form class="ui equal width form" method="post" action="/inquiry">
            {{ csrf_field() }}
            <h4 class="ui right floated header">Contact Details</h4>
            <div class="ui clearing divider"></div>
            <div class="fields">
              <div class="field">
                <label>First Name:</label>
                <input type="text" placeholder="First Name" name="fname">
              </div>
              <div class="field">
                <label>Last Name:</label>
                <input type="text" placeholder="Last Name" name="lname">
              </div>
            </div>
            <div class="field">
              <label>Email:</label>
              <input type="text" placeholder="" name="email">
            </div>
            <div class="ten wide field">
              <label>Phone:</label>
              <input type="text" placeholder="" name="phone">
            </div>
            <h4 class="ui right floated header">Event Details</h4>
            <div class="ui clearing divider"></div>
            <div class="two fields">
              <div class="six wide field">
                <label>Event Date:</label>
                <div class="ui calendar date">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text" placeholder="Date" name="eventdate">
                  </div>
                </div>
              </div>
              <div class="six wide field">
                <label>Event Time:</label>
                <div class="ui calendar time">
                  <div class="ui input left icon">
                    <i class="clock icon"></i>
                    <input type="text" placeholder="Time" name="eventtime">
                  </div>
                </div>
              </div>
            </div>
            <div class="four wide field">
              <label>No. of Guests:</label>
              <input type="text" placeholder="" name="guest">
            </div>
            <div class="ten wide field">
              <label>Occassion:</label>
              <input type="text" placeholder="" name="occassion">
            </div>
            <div class="ten wide field">
              <label>Location:</label>
              <input type="text" placeholder="" name="location">
            </div>
            <div class="field">
              <label>Message:</label>
              <textarea cols="5" name="message"></textarea>
            </div>
            <div class="actions">
              <button class="ui button" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

  
