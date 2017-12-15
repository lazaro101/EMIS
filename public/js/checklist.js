$(document).ready(function(){
  $('.dropdown.multiple').dropdown();
  $.fn.api.settings.api = {
    'get checklist'   : '/getChecklist',
  };
  $(document).on('click','#checklist .all',function(){
    $(this).closest('tr').find('input[name="out[]"]').val($(this).closest('tr').find('.qty').text());
  });
  $('#checklist .addbtn').click(function(){
    var valid = 0;
    $('#checklist input[name="out[]"]').each(function(){
      if ($(this).val() > parseFloat($(this).closest('tr').find('.qty').text().replace(/[^0-9-.]/g, '')) || $(this).val() < 0) {
        valid = 1;
      }
    });
    if (valid == 1){
      swal('Column out!','Enter a valid value','error');
      return false;
    } else {
      return true;
    }
  });

  $(document).on('click','#inlist .all.in',function(){
    $(this).closest('tr').find('input[name="in[]"]').val($(this).closest('tr').find('.out').text());
  });
  $(document).on('click','#inlist .all.none',function(){
    $(this).closest('tr').find('input[name="ld[]"]').val($(this).closest('tr').find('.out').text());
  });
  // $('#inlist .addbtn').click(function(){
  //   var valid = 0;
  //   var value = 0;
  //   $('#inlist input[name="in[]"]').each(function(){
  //     value = parseFloat($(this).val().replace(/[^0-9-.]/g, '')) + parseFloat($(this).closest('tr').find('input[name="ld[]"]').val().replace(/[^0-9-.]/g, ''));
  //     if ($(this).val() > $(this).closest('tr').find('.out').text() || $(this).val() < 0) {
  //       valid = 1;
  //     }
  //     if (value > $(this).closest('tr').find('.out').text() || value <= 0) {
  //       valid = 1;
  //     }
  //   });
  //   $('#inlist input[name="ld[]"]').each(function(){
  //     if ($(this).val() > $(this).closest('tr').find('.out').text() || $(this).val() < 0) {
  //       valid = 1;
  //     }
  //   });
  //   if (valid == 1){
  //     swal('Column input/s!','Enter a valid value','error');
  //     return false;
  //   } else {
  //     return true;
  //   }
  // });
  $('#addCart').click(function(){
    var esel = $('#equipSelect').val();
    // tbl.column(0).visible(false)
    $('#addCart').prop('disabled',true);
    for (var i = 0; i < esel.length; i++) {
      $.ajax({
      url: '/dashboardOut',
      type:'get',
      data : {
        id : esel[i]
      },
      success:function(data) {
        $('#checklist table tbody').append('<tr><td>'+data.equipment_inventory_name+'<input type="hidden" name="eqid[]" value="'+data.equipment_inventory_id+'"></td><td class="qty">'+data.equipment_inventory_qty+'</td><td><div class="ui fluid action input"><input type="number" placeholder="0" name="out[]"><div class="ui button all">ALL</div></div></td><td><button type="button" class="ui negative icon button del" data-id="'+data.equipment_inventory_id+'"><i class="delete icon"></i></button></td></tr>');
        $('#equipSelect option:selected').remove();
        $('#equipSelect').val('')
        // // console.log(data);
        //   tbl.row.add([
        //     data.equipment_inventory_id,
        //     data.equipment_inventory_name,
        //     data.equipment_inventory_qty,
        //     '<input type="number" id="qty'+data.equipment_inventory_name.replace(/ /g, '')+'" onkeyup="qtyReturned()" style="width:5cm;">',
        //     '<button class="ui small inverted negative icon button deleteRow" type="button" id="'+data.equipment_inventory_id+'" onclick="deleteTableRow(this.id)"><i class="trash bin icon"></i></button>'
        //   ]).draw(true);
          $('#addCart').prop('disabled',true);
      }
    });
    }
  });

  $(document).on('click','#checklist .del',function(){
    $(this).closest('tr').remove();
    var idd = $(this).data('id');
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
  $('.out').click(function(){
    $('#checklist form').form('set value','ccid',$(this).data('id'));
    $('#checklist')
      .modal('setting', 'closable', false)
      .modal('setting', 'autofocus', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
  });
  // $('.out').api({
  //   action: 'get checklist',
  //   method: 'get',
  //   beforeSend: function(settings) {
  //     settings.data = {
  //       ccid: $(this).data('id')
  //     };
  //     return settings;
  //   },
  //   onSuccess: function(response) {
  //     $('#checklist table tbody').empty();
  //     $('#checklist input[name=ccid]').val($(this).data('id'));
  //     response.forEach(function(data) {
  //       $('#checklist table tbody').append('<tr><td>'+data.equipment_inventory_name+'<input type="hidden" name="eqid[]" value="'+data.equipment_inventory_id+'"></td><td class="qty">'+data.equipment_inventory_qty+'</td><td><div class="ui fluid action input"><input type="number" placeholder="0" name="out[]" value="'+data.equipment_out+'"><div class="ui button all">ALL</div></div></td><td><div class="ui negative icon button del" data-id="'+data.equipment_inventory_id+'"><i class="delete icon"></i></div></td></tr>');
  //     }); 
  //   },
  //   onComplete: function(response){
  //     $('#checklist')
  //       .modal('setting', 'closable', false)
  //       .modal('setting', 'autofocus', false)
  //       .modal('setting', 'transition', 'fade up')
  //       .modal('show');
  //   }
  // });
  $('.in').api({
    action: 'get checklist',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ccid: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(response) {
      $('#inlist input[name=ccid]').val($(this).data('id'));
      $('#inlist table tbody').empty();
      response.forEach(function(data) {
        $('#inlist table tbody').append('<tr><td>'+data.equipment_inventory_name+'<input type="hidden" name="eqid[]" value="'+data.equipment_inventory_id+'"></td><td class="out">'+data.equipment_out+'</td><input type="hidden" name="out[]" value="'+data.equipment_out+'"><td><div class="ui fluid action input"><input type="number" placeholder="0" name="in[]" value="'+data.equipment_in+'"><div class="ui button all in">ALL</div></div></td><td><div class="ui fluid action input"><input type="number" placeholder="0" name="ld[]" value="'+data.lost_damage+'"><div class="ui button all none">ALL</div></div></td></tr>');
      }); 
    },
    onComplete: function(response){
      $('#inlist')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    }
  });

  //------------------Message Box ------------------------//
  var tm = setTimeout(function(){ $('.ui.msgbox.scsmsg').transition('fade'); }, 5000);
  $('#close1').on('click', function() {
    clearTimeout(tm);
    $(this)
      .closest('.msgbox.scsmsg')
      .transition('fade');
  });
  $('#close').on('click', function() {
    clearTimeout(ts);
    $(this)
      .closest('.msgbox.valmsg')
      .transition('fade');
  });

  $('.table-cont table').DataTable();
});

function test(id){
  alert(id)
}