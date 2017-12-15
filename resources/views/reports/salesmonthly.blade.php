@extends('layouts.admin')

@section('title','Sales by Month')

@section('script')
  <script type="text/javascript" src="{{ asset('js/salesmonthly.js') }}"></script>  
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('content')

<div class="ui raised basic segment content"> 
  <h1 class="ui right floated header">
    <i class="file text icon"></i>
    <div class="content">Sales by Month</div>
  </h1>
  <div class="large secondary ui labeled icon button back">
    <i class="left chevron icon"></i>Reports
  </div>
  <div class="ui clearing divider"></div>

  <div class="ui grid">

    <div class="row">
      <div class="column">
        <div class="ui labeled icon basic button print"><i class="print icon"></i>Print</div>
      </div>
    </div>
    
    <div class="centered row">
      <div class="column">
        <div class="ui secondary vertical segment">
          <div class="ui container">
            <form class="ui form" style="margin: 0em 1em" method="get" action="/Admin/Reports/Sales_Monthly">
            {{ csrf_field()}}
              <div class="four fields">
                <div class="field">
                  <label>Starting:</label>
                  <div class="ui calendar">
                    <div class="ui input left icon">
                      <i class="calendar icon"></i>
                      <input type="text" placeholder="Date" name="start" value="@if(isset($_GET['start'])) {{$_GET['start']}} @else {{date('Y/m/01')}} @endif">
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>Ending:</label>
                  <div class="ui calendar">
                    <div class="ui input left icon">
                      <i class="calendar icon"></i>
                      <input type="text" placeholder="Date" name="end" value="@if(isset($_GET['end'])) {{$_GET['end']}} @else {{date('Y/m/t')}} @endif">
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>&nbsp;</label>
                  <button type="submit" class="ui small button">Apply Filter</button>
                  <a href="Sales_Report" class="ui small reset button">Reset Filter</a>
                </div>
              </div>
            </form>
          </div>
        </div>  
      </div>
    </div>

    <div class="row">
      <div class="column">
        <table class="ui table list">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Reservations</th>
              <th>Down</th>
              <th>Balance</th>
              <th>Total</th>  
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>

@endsection