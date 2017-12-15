$(document).ready(function(){

    $('table.table').dataTable();
    
    $.fn.api.settings.api = {
      'retrieve profession' : '/retrieveProfession',
    };

    //---------------------show for Forms----------------------------//
    $('#addprof').click(function(){
      $('#addprofession')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
      $('#addprofession .ui.form').form('reset');//----------------reset form ------------//
    });

    $('.editprof').api({
      action: 'retrieve profession',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
          $('#editprofession form')
            .form('set values', {
              professionId     : data.staff_profession_id,
              professionName : data.staff_profession_description,
          });
        }) 
      },
      onComplete: function(response) {
      $('#editprofession')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
      },
    });

    //--------------add button------------------------------//
    $('#addprofession .addbtn').click(function(){
      if ($('#addprofession .ui.form').form('is valid') == false) {
        $('#addprofession .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editprofession .addbtn').click(function(){
      if ($('#editprofession .ui.form').form('is valid') == false) {
        $('#editprofession .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------cancel button------------------------------//
    $('#addprofession .cancelbtn').click(function(){
      $('#addprofession form').form('reset');
    });
    $('#editprofession .cancelbtn').click(function(){
      $('#editprofession form').form('reset');
    });

    //---------------------VALIDATIONS---------------------------//

    $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/validateProfession',
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

    $('#addprofession .ui.form')//--------------------addprofession validate--------------//
      .form({
        inline : true,
        fields :{
          professionName: {
            identifier: 'professionName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
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
              prompt : 'Profession Already Exists'
            }]
          },
        }
    });
    $('#editprofession .ui.form')//--------------------editprofession validate--------------//
      .form({
        inline : true,
        fields :{
          professionName: {
            identifier: 'professionName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
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
              prompt : 'Profession Already Exists'
            }]
          },
        }
    });

  //-------------------Delete Validation----------------------//
  $('button.delprof').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text('Staff Profession "'+item+'"');
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deleteprofession').form('set value','id',id);
          $('#deleteprofession').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });
});//----------------------document.ready-------------//
