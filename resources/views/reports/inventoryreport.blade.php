@extends('layouts.admin')

@section('title','Inventory Report')

@section('script')
<link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/components/calendar.css') }}">
<script type="text/javascript" src="{{ asset('Semantic/dist/components/calendar.js') }}"></script>
<script src="{{ asset('amchart/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('amchart/amcharts/serial.js') }}"></script>
<script src="{{ asset('amchart/amcharts/plugins/export/export.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('amchart/amcharts/plugins/export/export.css') }}" type="text/css" media="all" />
<script src="{{ asset('amchart/amcharts/themes/patterns.js') }}"></script>
<script src="{{ asset('amchart/amcharts/themes/light.js') }}"></script>
<script src="{{ asset('amchart/amcharts/themes/dark.js') }}"></script>
<script src="{{ asset('amchart/amcharts/themes/chalk.js') }}"></script>
<script src="{{ asset('amchart/amcharts/themes/black.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inventoryreport.js') }}"></script>  
@endsection

@section('style')
<style type="text/css">
/*body { background-color: #30303d; color: #fff; }*/
/*#chartdiv {
  width : 100%;
  height  : 500px;
}*/
</style>
@endsection

@section('content')

<div class="ui raised basic segment content"> 
  <h1 class="ui right floated header">
    <i class="file text icon"></i>
    <div class="content">Inventory Report</div>
  </h1>
  <div class="large secondary ui labeled icon button back">
    <i class="left chevron icon"></i>Reports
  </div>
  <div class="ui clearing divider"></div>

  <div class="ui grid">

    <div class="row">
      <div class="column">
        <button class="ui labeled icon basic button print"><i class="print icon"></i>Print</button>
      </div>
    </div>
    
    <div class="centered row">
      <div class="column">
        <div class="ui secondary vertical segment">
          <div class="ui container">
            <form class="ui form filter" style="margin: 0em 1em" method="get" action="/Admin/Reports/Inventory_Report">
            {{ csrf_field()}}
              <div class="four fields">
                <div class="field">
                  <label>Starting:</label>
                  <div class="ui calendar">
                    <div class="ui input left icon">
                      <i class="calendar icon"></i>
                      <input type="text" placeholder="Date" id='start' name="start" value="@if(isset($_GET['start'])) {{$_GET['start']}} @else {{date('Y/m/01')}} @endif">
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
                  <a href="Inventory_Report" class="ui small reset button">Reset Filter</a>
                </div>
              </div>
            </form>
          </div>
        </div>  
      </div>
    </div>
    
  <!--   <div class="row">
      <div class="column">
        <div id="chartdiv"></div>
      </div>
    </div> -->

    <div class="row">
      <div class="column">
        <table class="ui table list">
          <thead>
            <tr>
              <th>Date</th>
              <th>Transfer #</th>  
              <th class="four wide">Equipment</th>  
              <th class="two wide">Supplier</th>  
              <th>Unit value</th>
              <th>Quantity</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          @foreach($inv as $inv)
            <tr>
              <td>{{date("m/d/y", strtotime($inv->date_received))}}</td>
              <td>{{$inv->inventory_transfers_id}}</td>
              <td>{{$inv->equipment_inventory_name}}</td>
              <td>{{$inv->supplier_name}}</td> 
              <td>{{$inv->unit_value}}</td>
              <td>{{$inv->qty}}</td>
              <td>{{number_format($inv->qty * $inv->unit_value)}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>

@endsection