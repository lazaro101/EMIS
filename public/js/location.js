$(document).ready(function(){
  

  $.fn.api.settings.api = {
    'retrieve location' : '/retrieveLocation',
  };
  //-----------------------Form Image Preview----------------------//
  $(".addpic").change(function(event){
     var input = $(event.currentTarget);
     var file = input[0].files[0];
     var reader = new FileReader();
     reader.onload = function(e){
         image_base64 = e.target.result;
         $('#addform img').attr("src", image_base64);
     };
     reader.readAsDataURL(file);
  });

  $(".editpic").change(function(event){
     var input = $(event.currentTarget);
     var file = input[0].files[0];
     var reader = new FileReader();
     reader.onload = function(e){
         image_base64 = e.target.result;
         $('#editform img').attr("src", image_base64);
     };
     reader.readAsDataURL(file);
  });

    $('#addform .removepic').click(function(){
      $('#addform img').attr("src", "/image/LocationImages/preview.png");
      $('#addform form').form('set value','uploadpic','')
    });
    $('#editform .removepic').click(function(){
      $('#editform img').attr("src", "/image/LocationImages/preview.png");
      $('#editform form').form('set value','uploadpic','')
      $('#editform form').form('set value','tempImage','')
    });

    //---------------------show for Forms----------------------------//
    $('#addLocation').click(function(){
      $('#addform')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    });

    $('.edit').api({
      action: 'retrieve location',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
          $('#editform form')
            .form('set values', {
              locid : data.location_id,
              locname : data.location_name,
              duplocname : data.location_name,
              ownername : data.location_owner,
              contactNumber1 : data.location_contact1,
              contactNumber2 : data.location_contact2,
              city : data.city,
              barangay : data.barangay,
              street : data.street,
              province : data.province,
              rate : data.location_rate,
              address : data.location_address,
              cap : data.location_max,
              tempImage : data.location_img
          });
          $("#editform form img").attr("src","/image/LocationImages/"+data.location_img);
        }) 
      },
      onComplete: function(response) {
      $('#editform')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
      },
    });

    //--------------add button------------------------------//
    $('#addform .addbtn').click(function(){
      if ($('#addform .ui.form').form('is valid') == false) {
        $('#addform .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editform .addbtn').click(function(){
      if ($('#editform .ui.form').form('is valid') == false) {
        $('#editform .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------cancel button------------------------------//
    $('#addform .cancelbtn').click(function(){
      $('#addform form').form('reset');
    });
    $('#editform .cancelbtn').click(function(){
      $('#editform form').form('reset');
    });

    //---------------------VALIDATIONS---------------------------//
    $.fn.form.settings.rules.checkLocation= function(value) { //-------------check duplicate location name-------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/validateVenue',
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
    $.fn.form.settings.rules.checkLocationEdit = function(value) { //-----check duplicate location name for editform-------//
      var res = true;
      var dup = $('#editform .ui.form').form('get value','duplocname');
      if (dup.toLowerCase() == value.toLowerCase()) {
        return true;
      }
      $.ajax
        ({
          async : false,
          url: '/validateVenue',
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
    }

    $.fn.form.settings.rules.checkRate = function(value) { //-----------duplicate -------------//
      if (value >= 10000 || value <= 0) {
        return false;
      }
      else if(value.indexOf(".")>1){
        return false;
      }
      return true;
    };

    $('#addform .ui.form')//---------------addform validate---------------//
      .form({
        inline : true,
        fields :{
          locname: {
            identifier: 'locname',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type   : 'checkLocation',
              prompt : 'Location Name Already Exist'
            },
            {
              type   : 'maxLength[30]',
              prompt : 'Location name too long'
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
            },]
          },
          ownername: {
            identifier: 'ownername',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
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
            optional   : true,
            rules: [{
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
          street: {
            identifier: 'street',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          barangay: {
            identifier: 'barangay',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          city: {
            identifier: 'city',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          province: {
            identifier: 'province',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          rate: {
            identifier: 'rate',
            rules: [{
              type: 'checkRate',
              prompt: 'Enter valid rate'
            },
            {
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'decimal',
              prompt: 'Enter valid rate'
            }
            ]
          },
        }//------------fields end------------------//
      });//-----------validate addform end ----------//
      $('#editform .ui.form')//--------------------editform validate--------------//
      .form({
        inline : true,
        fields :{
          locname: {
            identifier: 'locname',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type   : 'checkLocationEdit',
              prompt : 'Location Name Already Exist'
            },
            {
              type   : 'maxLength[30]',
              prompt : 'Location name too long'
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
            },]
          },
          ownername: {
            identifier: 'ownername',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
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
            optional   : true,
            rules: [{
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            }]
          },
          street: {
            identifier: 'street',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          barangay: {
            identifier: 'barangay',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          city: {
            identifier: 'city',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          province: {
            identifier: 'province',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            }]
          },
          rate: {
            identifier: 'rate',
            rules: [{
              type: 'checkRate',
              prompt: 'Enter valid rate'
            },{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'decimal',
              prompt: 'Enter valid rate'
            }]
          },
        }//-----------fields end--------------------//
      });//-----------editform end------------------//

  //-------------------Delete Validation----------------------//
  $('button.delbtn').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#delete-form').form('set value','id',id);
          $('#delete-form').submit();
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


  $('table.table').dataTable();
}); //<<-------ddocument.ready------------------------//
