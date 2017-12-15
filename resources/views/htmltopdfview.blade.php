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
        <label>Client Name: </label><br>
        <label>Cellphone Number: </label><br>
        <label>Telephone Number: </label><br>
        <label>Email: </label>
      </div>

      <div id="eventDetails">
        <h4>Event Details</h4>
        <label>Event Name: </label><br>
        <label>Event Date: </label><br>
        <label>Event Time: </label><br>
        <label>Setup Time: </label><br>
        <label>End Time: </label><br>
        <label>Guest Count: </label><br>
        <label>Occasion: </label><br>
        <label>Motif: </label><br>
        <label>Location: </label><br>
        <label>Notes: </label><br>
      </div>

      <div id="packageMenu">
        <h4>Package Menu</h4>
        <label>Package Name:</label>
         <table>
        <thead>
          <tr>
            <th>Food Name</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>...</td>
              <td>...</td>
            </tr>
             </tbody>
            </table>
      </div>

      <div id="otherCharges">
        <h4>Other Charges</h4>
         <table>
        <thead>
          <tr>
            <th>Service Name</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>...</td>
              <td>...</td>
            </tr>
             </tbody>
          </table>
      </div>

      <div id="inventoryChecklist">
        <h4>Inventory Checklist</h4>
         <table>
        <thead>
          <tr>
            <th>Equipment</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>...</td>
              <td>...</td>
            </tr>
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
            <tr>
              <td>...</td>
              <td>...</td>
            </tr>
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
            <tr>
              <td>...</td>
              <td>...</td>
              <td>...</td>
              <td>...</td>
            </tr>
             </tbody>
          </table>
      </div>

      <div id="pricingDetails">
        <h4>Pricing Details</h4>
        <label>Food and Services: </label><br>
        <label>Food Addons: </label><br>
        <label>Venue: </label><br>
        <label>Other Additional Charges: </label><br>
        <label>Extra Cost/s: </label><br>
        <label>Total: </label><br>
      </div>
    </main>
</body>
</html>