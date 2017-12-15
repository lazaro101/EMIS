$(document).ready(function(){

  $('.tabular.menu .item').tab();
  $('.drpdwn').dropdown();


  $.fn.api.settings.api = {
    'retrieve equipment'   : '/retrieveEquipment',
  };
  //---------------------show addequipment button----------------------------//
  $('#addequip').click(function(){
    $('#addequipment')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
    $('#addequipment .ui.form').form('reset');//----------------reset form ------------//
  });

  //---------------------show editequipment button----------------------------//
  $('.editequip').api({
    action: 'retrieve equipment',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ID: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(response) {
      response.forEach(function(data) {
        $('#editequipment form')
          .form('set values', {
            id     : data.equipment_inventory_id,
            dupname     : data.equipment_inventory_name,
            name     : data.equipment_inventory_name,
            description     : data.equipment_inventory_description,
            quantity     : data.equipment_inventory_qty,
            type     : data.equipment_type_id,
        });
      }) 
    },
    onError: function(){
      alert();
    },
    onComplete: function(response){
      $('#editequipment')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
    }
  });

  //--------------add button------------------------------//
  $('#addequipment .addbtn').click(function(){
    if ($('#addequipment .ui.form').form('is valid') == false) {
      $('#addequipment .ui.form').form('validate form');
      return false
    }
    return true;
  });
  $('#editequipment .addbtn').click(function(){
    if ($('#editequipment .ui.form').form('is valid') == false) {
      $('#editequipment .ui.form').form('validate form');
      return false
    }
    return true;
  });
  //--------------cancel button------------------------------//
  $('#editequipment .cancelbtn').click(function(){
    $('#editequipment form').form('reset');
  });

  //---------------------VALIDATIONS---------------------------//
  $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
    ({
      async : false,
      url: '/validateEquipmentInventory',
      type : "get",
      data : {"value" : value},
      dataType: "json",
      success: function(data) {
          if (data.length > 0) {
            res = false;
          } else {
            res = true;
          }
      }
    });
    return res;
  };
  $.fn.form.settings.rules.checkNameEdit = function(value) { //-----------duplicate -------------//
    var res = true;
    var dup = $('#editequipment form').form('get value','dupname');
    if (dup.toLowerCase() == value.toLowerCase()) {
      return true;
    }
    $.ajax
    ({
      async : false,
      url: '/validateEquipmentInventory',
      type : "get",
      data : {"value" : value},
      dataType: "json",
      success: function(data) {
          if (data.length > 0) {
            res = false;
          } else {
            res = true;
          }
      }
    });
    return res;
  };

  $.fn.form.settings.rules.checkSymbol = function(value) { //-----------duplicate -------------//
    if (value.charAt(0)=="-" || value.charAt(0)=="/" || value.charAt(0)=="(" ||value.charAt(0)==")" || value.charAt(0)=="'" || value.charAt(0)>=0 && value.charAt(0)<=9){
      return false;  
    }
    return true;
  };

  $('#addequipment .ui.form')//--------------------addequipment validate--------------//
    .form({
      inline : true,
      fields :{
      name: {
        identifier: 'name',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be Empty.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        },
        {
          type   : 'regExp',
          value : '/^[ A-Za-z0-9()\'\\-`/\"]*$/',
          prompt : 'Invalid Symbol/s.'
        },
        {
          type   : 'regExp',
          value : '/^(?!.*[()\'\\-`/\"]{2}).*$/',
          prompt : 'Consecutive symbol/s not allowed.'
        },
        {
          type   : 'checkSymbol',
          prompt : 'Should not start with number/s or symbol/s.'
        },
        {
          type   : 'checkName',
          prompt : 'Name already exist.'
        }]
      },
      description : {
        identifier : 'description',
        rules : [
          {
          type   : 'maxLength[100]',
          prompt : 'Maximum of 100 characters only.'
          }
        ]
      },
      type : {
        identifier : 'type',
        rules : [{
          type : 'empty',
          prompt : 'Cannot be empty.',
        }]
      },
      quantity : {
        identifier : 'quantity',
        rules : [{
          type : 'empty',
          prompt : 'Cannot be empty.',
        },
        {
          type : 'integer[1..1000]',
          prompt : 'Invalid',
        }]
      },
    }
  });
  $('#editequipment form')//--------------------editequipment validate--------------//
    .form({
      inline : true,
      fields :{
      name: {
        identifier: 'name',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'checkSymbol',
          prompt : 'Should not start with number or symbol.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 10 characters only.'
        },
        {
          type   : 'regExp',
          value : '/^[ A-Za-z0-9()\'\\-`/\"]*$/',
          prompt : 'Invalid Symbol/s.'
        },
        {
          type   : 'regExp',
          value : '/^(?!.*[()\'\\-`/\"]{2}).*$/',
          prompt : 'Consecutive symbol/s not allowed.'
        },
        {
          type   : 'checkSymbol',
          prompt : 'Should not start with number/s or symbol/s.'
        },
        {
          type   : 'checkNameEdit',
          prompt : 'Name already exist.'
        }]
      },
      description : {
        identifier : 'description',
        rules : [
          {
          type   : 'maxLength[100]',
          prompt : 'Maximum of 100 characters only.'
          }
        ]
      },
      type : {
        identifier : 'type',
        rules : [{
          type : 'empty',
          prompt : 'Cannot be empty.',
        }]
      },
      quantity : {
        identifier : 'quantity',
        rules : [{
          type : 'empty',
          prompt : 'Cannot be empty.',
        },
        {
          type : 'integer[1..1000]',
          prompt : 'Invalid',
        }]
      },
    }
  });

  //-------------------Delete Validation----------------------//
  $('button.deleteequip').click(function(e) {
    var id = $(this).data('id');
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deleteequipment').form('set value','id',id);
          $('#deleteequipment').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });
  //------------------Message Box ------------------------//
  var tm = setTimeout(function(){ $('.ui.msgbox.scsmsg').transition('fade'); }, 5000);
  var ts = setTimeout(function(){ $('.ui.msgbox.valmsg').transition('fade'); }, 5000);
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


  $('table.table').DataTable();
});
