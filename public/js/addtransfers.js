$(document).ready(function(){

  $('.dropdown').dropdown();

  $(document).on('change','input[name="price[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });
    $(document).on('change','input[name="qty[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });

  $('.form.main').submit(function(e){
    var error = 0;
    $('input[name="price[]"]').each(function(){
      if ($(this).val() <= 0) {
        error = 1;
        $(this).closest('.field').addClass('error');
      }
    });
    $('input[name="qty[]"]').each(function(){
      if ($(this).val() <= 0) {
        error = 1;
        $(this).closest('.field').addClass('error');
      }
    });

    if (!$('.form.main').form('is valid')) {
      swal("Error submitting form!", "You have field/s with error." ,"error");
      e.preventDefault();
    } else if ($('.trtbl tbody tr').length == 0) {
      swal('Equipments table!','No equipment selected','error');
      e.preventDefault();
    } else if (error == 1) {
      swal('Column unit value/quantity ordered!','Enter a valid value','error');
      e.preventDefault();
    } else {
      $(this).unbind('submit').submit();
    }

  });

  $('.ui.calendar.date').calendar({
      // startMode: 'month',
      type: 'date'
  });
  $('.ui.calendar.time').calendar({
      // startMode: 'month',
      type: 'time'
  });

  $('.main.form').form({
    inline : false,
    fields : {
      supplier : {
        identifier : 'supplier',
        rules : [{
          type : 'empty',
          prompt : 'Supplier name is required.'
        }]
      },
      date : {
        identifier : 'date',
        rules : [{
          type : 'empty',
          prompt : 'Expected arrival date is required.'
        }]
      },
      qty : {
        identifier : 'qt',
        rules : [{
          type : 'empty',
        }]
      },
    }
  });

  $('.browse').click(function(){
    $.ajax
    ({
      url: '/getEquipments',
      type: 'get',
      success:function(response){
        $('#addequipment table tbody').empty();
        response.forEach(function(data){
          var check = 0;
          $("input[name='eqid[]']").map( function() {
            if ($(this).val() == data.equipment_inventory_id) {
              check = 1;
            } 
          }).get();
          if (check == 1) {
            $('#addequipment table tbody').append('<tr><td class="center aligned"></td><td class="name">'+data.equipment_inventory_name+'</td><td>'+data.equipment_type_description+'</td></tr>');
          } else {
            $('#addequipment table tbody').append('<tr><td class="center aligned"><div class="ui checkbox"><input type="checkbox" name="eq" value="'+data.equipment_inventory_id+'" tabindex="0"><label></label></div></td><td class="name">'+data.equipment_inventory_name+'</td><td>'+data.equipment_type_description+'</td></tr>');
          }
          
        });
      },
      complete:function(){
        $('#addequipment')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show'); 
      }
    });
  });


  $('#addequipment .addbtn').click(function(){
      $.each($("input[name='eq']:checked"), function(){
        $('.trtbl tbody').append('<tr><td>'+$(this).closest('tr').find('.name').text()+'<input type="hidden" name="eqid[]" value="'+$(this).val()+'"></td><td><div class="field"><input type="number" name="price[]"></div></td><td><div class="field"><input type="number" name="qty[]" data-validate="qt"></div></td><td class="center aligned"><i class="remove icon"></i></td></tr>');
      });
  });

  $(document).on('click','.trtbl .remove.icon',function(){
    $(this).closest('tr').remove();
  });

  $('.receive').click(function(){
    $('#receive')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show'); 

  });
  $('.complete').click(function(){

  });
});
