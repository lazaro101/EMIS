$(document).ready(function(){
    $('.drpdwn').dropdown();

    $('.secondary.segment .ui.calendar').calendar({
        type: 'date',
        startMode: 'year'
    });
    $('.tabular.menu .item').tab();

    $.fn.api.settings.api = {
      'retrieve staff' : '/retrieveStaff',
    };
    //-----------------------Form Image Preview----------------------//
    $(".addpic").change(function(event){
       var input = $(event.currentTarget);
       var file = input[0].files[0];
       var reader = new FileReader();
       reader.onload = function(e){
           image_base64 = e.target.result;
           $('#addstaff img').attr("src", image_base64);
       };
       reader.readAsDataURL(file);
    });
    $(".editpic").change(function(event){
       var input = $(event.currentTarget);
       var file = input[0].files[0];
       var reader = new FileReader();
       reader.onload = function(e){
           image_base64 = e.target.result;
           $('#editstaff img').attr("src", image_base64);
       };
       reader.readAsDataURL(file);
    });
    $('#addstaff .removepic').click(function(){
      $('#addstaff img').attr("src", "/generalpics/profilepreview.png");
      $('#addstaff form').form('set value','profilepic','');
    });
    $('#editstaff .removepic').click(function(){
      $('#editstaff img').attr("src", "/generalpics/profilepreview.png");
      $('#editstaff form').form('set value','profilepic','');
      $('#editstaff form').form('set value','tempImage','');
    });

    //---------------------show for Forms----------------------------//
    $('#addsta').click(function(){
      $('#addstaff')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
      $('#addstaff .ui.calendar').calendar({
        startMode: 'year',
        type: 'date'
      });
    });

    $('.editstaff').api({
      action: 'retrieve staff',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {

          $('#editstaff .ui.calendar').calendar('set date',data.staff_birthdate);
          $('#editstaff form')
              .form('set values', {
                id : data.staff_id,
                fname : data.staff_fname,
                lname : data.staff_lname,
                profession : data.staff_profession_id,
                gender : data.staff_gender,
                street : data.street,
                city : data.city,
                barangay : data.barangay,
                province : data.province,
                address : data.staff_address,
                number : data.staff_contact,
                rate : data.staff_rate,
                tempImage : data.staff_img
            });
          $("#editstaff img.profile").attr("src","/image/ProfilePictures/"+data.staff_img);
        }) 
      },
      onComplete: function(response) {
      $('#editstaff')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
      $('#editstaff .ui.calendar').calendar({
        startMode: 'year',
        type: 'date'
      });
      },
    });

    $('.view').click(function(){
      var id = $(this).data('id');
      $.ajax
      ({ 
        url: '/retrieveStaff',
        data: {"ID": id},
        type: 'get',
        dataType : 'json',
        success: function(response)
        {  
          response.forEach(function(data) {
          var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
          var date = new Date(data.staff_birthdate);
          var formattedDate = monthNames[date.getMonth()] +' '+ date.getDate() +', '+ date.getFullYear();

            $('#viewform span.fname').text(data.staff_fname);
            $('#viewform span.lname').text(data.staff_lname);
            $("#viewform img.pic").attr("src","/image/ProfilePictures/"+data.staff_img);
            $('#viewform span.profession').text(data.staff_profession_description);
            $('#viewform span.bday').text(formattedDate);
            $('#viewform span.age').text(data.staff_age);
            $('#viewform span.gender').text(data.staff_gender);
            $('#viewform span.address').text(data.street+", "+data.barangay+", "+data.city+", "+data.province);
            $('#viewform span.number').text(data.staff_contact);
            $('#viewform span.rate').text(data.staff_rate);
          })  
          $('#viewform')
            .modal('setting', 'closable', false)
            .modal('setting', 'transition', 'fade')
            .modal('show');
        }
      });
    });

    //--------------add button------------------------------//
    $('#addstaff .addbtn').click(function(){
      if ($('#addstaff .ui.form').form('is valid') == false) {
        $('#addstaff .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editstaff .addbtn').click(function(){
      if ($('#editstaff .ui.form').form('is valid') == false) {
        $('#editstaff .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------cancel button------------------------------//
    $('#addstaff .cancelbtn').click(function(){
      $('#addstaff form').form('reset');
    });
    $('#editstaff .cancelbtn').click(function(){
      $('#editstaff form').form('reset');
    });


    //---------------------VALIDATIONS---------------------------//

    $.fn.form.settings.rules.checkRate = function(value) { //-----------duplicate -------------//
      if (value >= 1000 || value <= 0) {
        return false;
      }
      else if(value.indexOf(".")>1){
        return false;
      }
      return true;
    };

    /*$.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/',
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
    };*/

    $('#addstaff .ui.form')//--------------------addstaff validate--------------//
      .form({
        inline : true,
        fields :{
          fname: {
            identifier: 'fname',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          lname: {
            identifier: 'lname',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          profession: {
            identifier: 'profession',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          birthdate: {
            identifier: 'birthdate',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          gender: {
            identifier: 'gender',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          street: {
            identifier: 'street',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          barangay: {
            identifier: 'barangay',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          city: {
            identifier: 'city',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          province: {
            identifier: 'province',
            rules: [
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          number: {
            identifier: 'number',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            }]
          },
          rate: {
            identifier: 'rate',
            rules: [
             {
              type   : 'checkRate',
              prompt : 'Enter a valid rate'
            },
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'decimal',
              prompt : 'Enter a valid rate'
            }
           ]
          },
        }
    });

    $('#editstaff .ui.form')//--------------------addstaff validate--------------//
      .form({
        inline : true,
        fields :{
          fname: {
            identifier: 'fname',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          lname: {
            identifier: 'lname',
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
              value  : '/^[A-Za-z\ ]*$/',
              prompt : 'Enter a valid name.'
            }]
          },
          profession: {
            identifier: 'profession',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          birthdate: {
            identifier: 'birthdate',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          gender: {
            identifier: 'gender',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            }]
          },
          street: {
            identifier: 'street',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          barangay: {
            identifier: 'barangay',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          city: {
            identifier: 'city',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          province: {
            identifier: 'province',
            rules: [
            {
              type   : 'maxLength[50]',
              prompt : 'Maximum of 50 characters only.'
            }]
          },
          address: {
            identifier: 'address',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'maxLength[100]',
              prompt : 'Maximum of 100 characters only.'
            },
            {
              type   : 'regExp',
              value  : '/[A-Za-z]/i',
              prompt : 'Should contain letters'
            }]
          },
          number: {
            identifier: 'number',
            rules: [
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type: 'integer',
              prompt: 'Enter valid mobile number'
            },
            {
              type: 'exactLength[11]',
              prompt: 'Must be 11 digit mobile number'
            }]
          },
          rate: {
            identifier: 'rate',
            rules: [
             {
              type   : 'checkRate',
              prompt : 'Enter a valid rate'
            },
            {
              type   : 'empty',
              prompt : 'Cannot be empty'
            },
            {
              type   : 'decimal',
              prompt : 'Enter a valid rate'
            }
           ]
          },
        }
    });
  //-------------------Delete Validation----------------------//
  $('button.delstaff').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text('Staff "'+item+'"');
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deletestaff').form('set value','id',id);
          $('#deletestaff').submit();
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
});//--------------document.ready------------//
