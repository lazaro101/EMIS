@extends('layouts.admin')

@section('title','Events')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.print.css') }}" media="print">
<!-- <script src="{{ asset('Semantic/dist/fullcalendar/lib/jquery.min.js') }}"></script> -->
<script src="{{ asset('Semantic/dist/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('Semantic/dist/fullcalendar/fullcalendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/fullcalendar/fullcalendar.css') }}">
<script type="text/javascript" src="{{ asset('js/events.js') }}"></script>

@endsection

@section('style')
<style type="text/css">
#calendar {
  /*background-color: rgba(360,360,360,.8);*/
  /*width: 500px;*/
}
</style>
@endsection

@section('content')
  <div class="ui raised basic segment content"> 
    <h1 class="ui right floated header">
      <i class="calendar icon"></i>
      <div class="content">Events</div>
    </h1>

    <div class="ui clearing divider"></div>

    <div class="ui container">
  	  <div class="ui grid">
  	    <div class="ui ten column">
  	      <div id="calendar"></div>
  	    </div>
	    </div>
	  </div>
</div>
@endsection