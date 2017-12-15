$(document).ready(function(){
  var tbl = $('#inTable').DataTable({
     "searching": false,
      "ordering": false,
      "paging": false,
  });

  $('#addCart').prop('disabled',true);

  $(document).on('submit', '#out_form', function(e){
    var qty = [];
    var eventID = [];
    var oTable = $('#inTable').dataTable();
    var tblrowd = oTable.fnGetData().length;
    materialArr =  oTable.fnGetData();

      for(var i = 0; i<tblrowd; i++){
      qty[i] = $("#qty"+materialArr[i][1].replace(/ /g, '')).val();
      eventID[i] = materialArr[i][0]
    }
    alert(qty)
    alert(eventID)
  });

  $('.out.button').click(function(){
  $('#outact')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
  });

  $('#equipSelect').change(function(){
    $('#addCart').prop('disabled',false);
  });

  $('#addCart').click(function(){
    var esel = $('#equipSelect').val();
    tbl.column(0).visible(false)
    $('#addCart').prop('disabled',true);
    for (var i = 0; i < esel.length; i++) {
      $.ajax({
      url: '/dashboardOut',
      type:'get',
      data : {
        id : esel[i]
      },
      success:function(data) {
        $('#equipSelect option:selected').remove();
        $('#equipSelect').val('')
        // console.log(data);
          tbl.row.add([
            data.equipment_inventory_id,
            data.equipment_inventory_name,
            data.equipment_inventory_qty,
            '<input type="number" id="qty'+data.equipment_inventory_name.replace(/ /g, '')+'" onkeyup="qtyReturned()" style="width:5cm;">',
            '<button class="ui small inverted negative icon button deleteRow" type="button" id="'+data.equipment_inventory_id+'" onclick="deleteTableRow(this.id)"><i class="trash bin icon"></i></button>'
          ]).draw(true);
          $('#addCart').prop('disabled',true);
      }
    });
    }

  });

});


function qtyReturned()
{
  // alert('asd')
  var table = $('#inTable').dataTable();
  var tblrowd = table.fnGetData().length;
  qtyArr =  table.fnGetData();

  for (var i = 0; i < tblrowd; i++) {
    var availableQty = qtyArr[i][2]
    var returnQty =  $('#qty'+qtyArr[i][1].replace(/ /g, '')).val()
    if (returnQty > availableQty) {
      $('#qty'+qtyArr[i][1].replace(/ /g, '')).val(availableQty)
    }
  }
}

function deleteTableRow(idd)
{
  $('#inTable').on('click', '.deleteRow', function(e){
    var table = $('#inTable').DataTable();
    table.row($(this).parents('tr')).remove().draw();

    $.ajax({
    url: '/dashboardTable-add',
    type:'get',
    data : {
      iddd : idd
    },
    success:function(data) {
      console.log(data);
      $(`<option value=`+data.equipment_inventory_id+`>`+data.equipment_inventory_name+'('+data.equipment_inventory_qty+')'+`</option>`).appendTo("#equipSelect");
    }
  });
  });
}

function inModal(id){
    $('#inact').modal('show');

    $.ajax({
    url: '/dashboardIn',
    type:'get',
    data : {
      id : id
    },
    success:function(data) {
      console.log(data);
    }
  });

  }
