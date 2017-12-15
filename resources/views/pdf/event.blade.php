<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <title>Event Details</title>
    <!-- <link rel="stylesheet" href="style.css" media="all" /> -->
    <style type="text/css">
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm;  
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

.h3 {
  text-align: center;
  line-height: 0.2;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 5px 0;
  background: url(dimension.png);
}

main {
  margin-left: 10%;
  margin-right: 10%;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}
table td {
  padding: 20px;
  text-align: left;
}
    </style>
<body style="width: 100%">
  <header class="clearfix">
    <div class="h3">
    <h3>Al Marsan's Catering Services</h3>
    <h3>41 Magsaysay Street, Parang, Marikina City</h3>
    <h3>Tel: 941-4066 CP: 0916-3777-348 Email: almarsancatering@yahoo.com</h3>
    </div>
  <h1>Event Details</h1>
    </header>
    <main>
      <div id="clientDetails">
        <h4> Client Details</h4>
        <label>Client Name: {{$rsrvtn->client_fname.' '.$rsrvtn->client_lname}}</label><br>
        <label>Cellphone Number: {{ $rsrvtn->client_contact1 }}</label><br>
        <label>Telephone Number: {{ $rsrvtn->client_telephone1 }}</label><br>
        <label>Email: {{ $rsrvtn->client_email }}</label>
      </div>

      <div id="eventDetails">
        <h4>Event Details</h4>
        <label>Event Name: {{ $rsrvtn->event_name }}</label><br>
        <label>Event Date: {{ $rsrvtn->event_date }}</label><br>
        <label>Event Time: {{ $rsrvtn->event_time }}</label><br>
        <label>Setup Time: {{ $rsrvtn->event_setup }}</label><br>
        <label>End Time: {{ $rsrvtn->event_end }}</label><br>
        <label>Guest Count: {{ $rsrvtn->event_guest_count }}</label><br>
        <label>Occasion: {{ $rsrvtn->event_occassion }}</label><br>
        <label>Motif: {{ $rsrvtn->event_motif }}</label><br>
        <label>Location: </label><br>
        <label>Notes: {{ $rsrvtn->event_setup_notes }}</label><br>
      </div>

      <div id="packageMenu">
        <h4>Package Menu</h4>
        <label>Package Name: {{$rsrvtn->package_name}}</label>
         <table>
        <thead>
          <tr>
            <th>Food Name</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>
            
                    @if(count($menu) == 0)
                    <tr>
                      <td colspan="2" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($menu as $menu)
                      <tr>
                        <td>{{$menu->submenu_name}}<input type="hidden" name="menu[]" value="{{$menu->submenu_id}}"></td>
                        <td class="four wide">{{$menu->submenu_category_name}}</td>
                      </tr>
                      @endforeach
                      @if(count($addons) != 0)
                      <tr>
                        <td colspan="2" class="center aligned">Addons:</td>
                      </tr>
                      @foreach($addons as $ao)
                      <tr>
                        <td>{{$ao->submenu_name}}<input type="hidden" name="addons[]" value="{{$ao->submenu_id}}"></td>
                        <td class="four wide">{{$ao->submenu_category_name}}</td>
                      </tr>
                      @endforeach
                      @endif
                    @endif
             </tbody>
            </table>
      </div>

      <div id="otherCharges">
        <h4>Other Charges</h4>
         <table>
        <thead>
          <tr>
            <th>Service Name</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
            
                    @if(count($services) == 0)
                    <tr>
                      <td colspan="5" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($services as $ser)
                      <tr>
                        <td>{{$ser->services_contact_name}}<input type="hidden" name="serviceContact[]" value="{{$ser->services_contact_id}}"></td>
                        <td class="right aligned total">₱ {{number_format($ser->total,2)}}<input type="hidden" name="sctot[]" value="{{$ser->total}}"></td>
                        <td class="center aligned">
                          <div class="ui secondary small icon button delser"><i class="delete icon"></i></div>
                        </td>
                      </tr>
                      @endforeach
                    @endif
             </tbody>
          </table>
      </div>


      <div id="staffAssignment">
        <h4>Staff Assignment</h4>
         <table>
        <thead>
          <tr>
            <th>Staff Name</th>
            <th>Profession</th>
          </tr>
        </thead>
        <tbody>
         
                    @if(count($staff) == 0)
                    <tr>
                      <td colspan="3" class="center aligned">Empty</td>
                    </tr>
                    @else
                      @foreach($staff as $st)
                      <tr>
                        <td>{{$st->staff_fname.' '.$st->staff_lname}}<input type="hidden" name="staff[]" value="{{$st->staff_id}}"></td>
                        <td>{{$st->staff_profession_description}}</td>
                        <td class="center aligned"><i class="delete icon"></i></td>
                      </tr>
                      @endforeach
                    @endif
             </tbody>
          </table>
      </div>

      <div id="extraCost">
        <h4>Extra Cost/s</h4>
         <table>
        <thead>
          <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Count</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          
                  @if(count($extra) == 0)
                    <tr>
                      <td colspan="5" class="center aligned">Empty</td>
                    </tr>
                  @else
                    @foreach($extra as $extra)
                    <tr>
                      <input type="hidden" value="{{$extra->extra_cost_id}}">
                      <td>{{$extra->cost_type}}</td>
                      <td class="right aligned">₱ {{$extra->amount}}</td>
                      <td class="center aligned">({{$extra->guest_count}})</td>
                      <td class="right aligned">₱ {{$extra->total}}</td>
                    </tr>
                    <tr>
                      <td colspan="5">{{$extra->comments}}<input type="hidden" name="extraCost[]" value="{{$extra->extra_cost_id}}"></td>
                    </tr>
                    @endforeach
                  @endif
             </tbody>
          </table>
      </div>

      <div id="pricingDetails">
        <h4>Pricing Details</h4>
        <label>Food and Services: {{number_format($rsrvtn->menu_total,2)}}</label><br>
        <label>Food Addons: {{number_format($rsrvtn->addons_total,2)}}</label><br>
        <label>Venue: {{number_format($rsrvtn->location_total,2)}}</label><br>
        <label>Other Additional Charges: {{number_format($rsrvtn->services_total,2)}}</label><br>
        <label>Extra Cost/s: {{number_format($rsrvtn->extra_cost_total,2)}}</label><br>
        <label>Total: {{number_format($rsrvtn->grand_total,2)}}</label><br>
      </div>
    </main>
</body>
</html>