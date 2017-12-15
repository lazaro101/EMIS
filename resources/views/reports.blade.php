@extends('layouts.admin')

@section('title','Reports')

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.button.sales').click(function(){
      window.open("/Admin/Reports/Sales_Report",'_self');
    });
    $('.button.inventory').click(function(){
      window.open("/Admin/Reports/Inventory_Report",'_self');
    });
    $('.button.lost').click(function(){
      window.open("/Admin/Reports/Lost_Damage_Report",'_self');
    });
  });
</script>
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('content')

<div class="ui raised basic segment content"> 
  <h1 class="ui right floated header">
    <i class="area chart icon"></i>
    <div class="content">Reports</div>
  </h1>
  <div class="ui clearing divider"></div>

  <div class="ui grid">
    <div class="three column row">
      <div class="column">
        <div class="ui card">
          <div class="content">
            <div class="header">Sales</div>
            <div class="description">
              Reservation last 30 days: NaN 
            </div>
          </div>
   <!--        <div class="content">
            <h4 class="ui sub header">Reports</h4>
            <div class="ui small feed">
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a href="/Admin/Reports/Sales_Monthly">Sales by month</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a href="/Admin/Reports/Sales_Weekly">Sales by week</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a>Sales by day</a>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="extra content">
            <div class="ui basic primary button sales">View reports</div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="ui card">
          <div class="content">
            <div class="header">Inventory</div>
            <div class="description">
              Equipments added last 30 days: NaN
            </div>
          </div>
          <!--   <div class="content">
          <h4 class="ui sub header">Reports</h4>
            <div class="ui small feed">
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a>Transfers by month</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a>Transfers by week</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a>Transfers by day</a>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="extra content">
            <div class="ui basic primary button inventory">View reports</div>
          </div>
        </div>
      </div>
      <!-- <div class="column">
        <div class="ui card">
          <div class="content">
            <div class="header">Lost/Damage</div>
            <div class="description">
              Records 30 days: NaN 
            </div>
          </div>
          <div class="content">
            <h4 class="ui sub header">Reports</h4>
            <div class="ui small feed">
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a href="/Admin/Reports/Sales_Monthly">Sales by month</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a href="/Admin/Reports/Sales_Weekly">Sales by week</a>
                  </div>
                </div>
              </div>
              <div class="event">
                <div class="content">
                  <div class="summary">
                     <a>Sales by day</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="extra content">
            <div class="ui basic primary button lost">View reports</div>
          </div>
        </div>
      </div>
    </div> -->
  </div>

</div>

@endsection