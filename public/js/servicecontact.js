$(document).ready(function(){
  $('.drpdwn').dropdown();

  $('.tabular.menu .item').tab();

  $.fn.api.settings.api = {
    'retrieve service contact' : '/retrieveServiceContact',
  };
  
    //---------------------Buttons for Forms----------------------------//
    $('#addservice').click(function(){
      // $('#addcontact .type').dropdown('set selected','1');
      $('#addcontact')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    });

    $('.editservice').api({
      action: 'retrieve service contact',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
           $('#editcontact form')
            .form('set values', {
              dupcontactName : data.services_contact_name,
              contactId   : data.services_contact_id,
              contactName   : data.services_contact_name,
              contactOwner   : data.services_contact_owner,
              contactCtgry   : data.services_id,
              street   : data.street,
              barangay   : data.barangay,
              city   : data.city,
              province   : data.province,
              contactNumber1   : data.services_contact_number1,
              contactNumber2   : data.services_contact_number2,
              contactPrice   : data.services_contact_price,
          });
          $('#editcontact .dropdown.type').dropdown('set selected',data.price_type);
        }) 
      },
      onComplete: function(response) {
      $('#editcontact form').form('reset');
      $('#editcontact')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
      },
    });

    //--------------add button------------------------------//
    $('#addcontact .addbtn').click(function(){
      if ($('#addcontact .ui.form').form('is valid') == false) {
        $('#addcontact .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editcontact .addbtn').click(function(){
      if ($('#editcontact .ui.form').form('is valid') == false) {
        $('#editcontact .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------cancel button------------------------------//
    $('#addcontact .cancelbtn').click(function(){
      $('#addcontact form').form('reset');
    });
    $('#editcontact .cancelbtn').click(function(){
      $('#editcontact form').form('reset');
    });

    //---------------------VALIDATIONS---------------------------//

    $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/validateServiceContact',
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
      /*var dup = $('#editcontact .ui.form').form('get value','dupcontactName');
      if (dup.toLowerCase() == value.toLowerCase()) {
        return true;
      }*/
      var dup = $('#contactName').val();
      var id = $('#contactId').val();
      console.log(dup); 
      $.ajax
        ({
          async : false,
          url: '/validateEditServiceContact',
          type : "get",
          data : {"dup" : dup, "id" : id},
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
    }

    $.fn.form.settings.rules.checkPrice = function(value) { //-----------duplicate -------------//
      if (value >= 10000) {
        return false;
      }
      // else if(value.indexOf(".")>2){
      //   return false;
      // }
      return true;
    };
    $.fn.form.settings.rules.checkContact = function(value,checkContact) { 
      if (checkContact == 1) {
        if ($('#addcontact form').form('get value','contactNumber1') == $('#addcontact form').form('get value','contactNumber2')) {
          return false
        }
      } else {
        if ($('#editcontact form').form('get value','contactNumber1') == $('#editcontact form').form('get value','contactNumber2')) {
          return false
        }
      }
      return true;
    };

    $('#addcontact .ui.form')//--------------------addcontact validate--------------//
      .form({
        inline : true,
        fields :{
          contactName: {
            identifier: 'contactName',
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
              prompt : 'Contact Name Already Exists'
            }]
          },
          contactOwner: {
            identifier: 'contactOwner',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            },
            {
              type   : 'regExp',
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          contactCtgry: {
            identifier: 'contactCtgry',
            rules: [
            {
              type   : 'empty',
              prompt : 'Select a category'
            }]
          },
          contactPrice: {
            identifier: 'contactPrice',
            rules: [ {
              type: 'checkPrice',
              prompt: 'Enter a valid Price'
            },
            {
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
           
            {
              type: 'decimal',
              prompt: 'Enter valid price'
            }]
          },
          contactNumber1: {
            identifier: 'contactNumber1',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
          contactNumber2: {
            identifier: 'contactNumber2',
            optional : true,
            rules: [{
              type   : 'checkContact[1]',
              prompt : 'Please put different values for each field'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
          priceType: {
            identifier: 'priceType',
            rules: [
            {
              type: 'Empty',
              prompt: 'Required.'
            }]
          },
        }
    });
    $('#editcontact .ui.form')//--------------------editcontact validate--------------//
      .form({
        inline : true,
        fields :{
          contactName: {
            identifier: 'contactName',
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
              prompt : 'Contact Name Already Exists'
            }]
          },
          contactOwner: {
            identifier: 'contactOwner',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            },
            {
              type   : 'regExp',
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          contactCtgry: {
            identifier: 'contactCtgry',
            rules: [
            {
              type   : 'empty',
              prompt : 'Select a category'
            }]
          },
          contactPrice: {
            identifier: 'contactPrice',
            rules: [ {
              type: 'checkPrice',
              prompt: 'Enter a valid Price'
            },
            {
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'decimal',
              prompt: 'Enter valid price'
            }]
          },
          contactNumber1: {
            identifier: 'contactNumber1',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
          contactNumber2: {
            identifier: 'contactNumber2',
            optional : true,
            rules: [{
              type   : 'checkContact[2]',
              prompt : 'Please put different values for each field'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
        }
    });


  //-------------------Delete Validation----------------------//
  $('button.delservice').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deletecontact').form('set value','id',id);
          $('#deletecontact').submit();
        }
      })
    .modal('show');
    e.preventDefault();
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

  $('.table-cont.ser table').DataTable();
});//---------------------document.ready--------------//
