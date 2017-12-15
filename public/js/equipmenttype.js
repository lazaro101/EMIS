$(document).ready(function(){

  $.fn.api.settings.api = {
    'retrieve type'   : '/retrieveEquipmentType',
  };
  //---------------------show addequipmenttype button----------------------------//
  $('#addtype').click(function(){
    $('#addequipmenttype')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
    $('#addequipmenttype .ui.form').form('reset');//----------------reset form ------------//
  });

  //---------------------show editequipmenttype button----------------------------//
  $('.edittype').api({
    action: 'retrieve type',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ID: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(response) {
      response.forEach(function(data) {
        $('#editequipmenttype form')
          .form('set values', {
            id     : data.equipment_type_id,
            name   : data.equipment_type_description,
        });
      }) 
    },
    onComplete: function(response){
      $('#editequipmenttype')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
    }
  });

  //--------------add button------------------------------//
  $('#addequipmenttype .addbtn').click(function(){
    if ($('#addequipmenttype .ui.form').form('is valid') == false) {
      $('#addequipmenttype .ui.form').form('validate form');
      return false
    }
    return true;
  });
  $('#editequipmenttype .addbtn').click(function(){
    if ($('#editequipmenttype .ui.form').form('is valid') == false) {
      $('#editequipmenttype .ui.form').form('validate form');
      return false
    }
    return true;
  });
  //--------------cancel button------------------------------//
  $('#editequipmenttype .cancelbtn').click(function(){
    $('#editequipmenttype form').form('reset');
  });

  //---------------------VALIDATIONS---------------------------//
  $.fn.form.settings.rules.checkType = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
    ({
      async : false,
      url: '/validateEquipmentType',
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

  $('#addequipmenttype form')//--------------------addequipmenttype validate--------------//
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
          type   : 'checkType',
          prompt : 'Type already exist.'
        }]
      },
    }
  });
  $('#editequipmenttype .ui.form')//--------------------editequipmenttype validate--------------//
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
          type   : 'checkType',
          prompt : 'Type already exist.'
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
        }]
      },
    }
  });

  //-------------------Delete Validation----------------------//
  $('button.deletetype').click(function(e) {
    var id = $(this).data('id');
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deleteequipmenttype').form('set value','id',id);
          $('#deleteequipmenttype').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });

});
