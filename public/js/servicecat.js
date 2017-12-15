$(document).ready(function(){

  $.fn.api.settings.api = {
    'retrieve services' : '/retrieveServices',
  };

  //---------------------Buttons for Forms----------------------------//
    $('#addctgry').click(function(){
      $('#addcat')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    });

    $('.editcat').api({
      action: 'retrieve services',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
          $('#editcat form')
            .form('set values', {
              serviceId     : data.services_id,
              serviceName : data.services_name,
              dupserviceName : data.services_name,
              serviceDescription   : data.services_description,
          });
        })
      },
      onComplete: function(response) {
      $('#editcat')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
      },
    });
    
    //--------------add button------------------------------//
    $('#addcat .addbtn').click(function(){
      if ($('#addcat .ui.form').form('is valid') == false) {
        $('#addcat .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editcat .addbtn').click(function(){
      if ($('#editcat .ui.form').form('is valid') == false) {
        $('#editcat .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------cancel button------------------------------//
    $('#addcat .cancelbtn').click(function(){
      $('#addcat form').form('reset');
    });
    $('#editcat .cancelbtn').click(function(){
      $('#editcat form').form('reset');
    });

    //---------------------VALIDATIONS---------------------------//

    $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/validateServices',
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
    $.fn.form.settings.rules.checkNameEdit = function(value) { //-----------check duplicate -------------//
      var res = true;
      var dup = $('#editcat .ui.form').form('get value','dupserviceName');
      if (dup == value) {
        return true;
      }
      $.ajax
        ({
          async : false,
          url: '/validateServices',
          type : "get",
          data : {"value" : value},
          dataType: "json",
          success: function(response) {
            if (response.length > 0) {
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

    $('#addcat .ui.form')//--------------------addcat validate--------------//
      .form({
        inline : true,
        fields :{
          serviceName: {
            identifier: 'serviceName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[30]',
              prompt : 'Maximum of 30 characters only.'
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
              prompt : 'Service Name Already Exists'
            }]
          },
          serviceDescription: {
            identifier: 'serviceDescription',
            rules: [
            // {
            //   type   : 'empty',
            //   prompt : 'Cannot be empty'
            // },
            {
              type   : 'maxLength[100]',
              prompt : 'Maximum of 100 characters only.'
            },
            {
              type   : 'regExp',
              value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
              prompt : 'Invalid Symbol/s.'
            },
            {
              type   : 'regExp',
              value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
              prompt : 'Consecutive symbol/s not allowed.'
            }]
          }
        }
    });
    $('#editcat .ui.form')//--------------------editcat validate--------------//
      .form({
        inline : true,
        on     : 'change',
        fields :{
          serviceName: {
            identifier: 'serviceName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[30]',
              prompt : 'Maximum of 30 characters only.'
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
              prompt : 'Service Name Already Exists'
            }]
          },
          serviceDescription: {
            identifier: 'serviceDescription',
            rules: [
            // {
            //   type   : 'empty',
            //   prompt : 'Cannot be empty'
            // },
            {
              type   : 'maxLength[100]',
              prompt : 'Maximum of 100 characters only.'
            },
            {
              type   : 'regExp',
              value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
              prompt : 'Invalid Symbol/s.'
            },
            {
              type   : 'regExp',
              value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
              prompt : 'Consecutive symbol/s not allowed.'
            }]
          }
        }
    });

  //-------------------Delete Validation----------------------//
  $('button.delcat').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deletecat').form('set value','id',id);
          $('#deletecat').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });

  $('.table-cont.cat table').DataTable();

});//-----------------document.ready--------------------//
