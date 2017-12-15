$(document).ready(function(){

  //---------------------show addform button----------------------------//
  $('#addctgry').click(function(){
    $('#addform')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
    $('#addform .ui.form').form('reset');//----------------reset form ------------//
  });

  //---------------------show editform button----------------------------//
  $('.edit').click(function(){
    $('#editform .ui.form').form('reset');//----------------reset form ------------//
    var id = $(this).data('id');
    $.ajax
    ({ 
      url: '/retrieveUsers',
      data: {"ID": id},
      type: 'get',
      dataType : 'json',
      success: function(response)
      {  
        response.forEach(function(data) {
          $('#editform form')
            .form('set values', {
              id     : data.id,
              username     : data.username,
              // password   : data.password,
              email   : data.email,
              disname   : data.display_name,
          });
        }) 
        $('#editform')
          .modal('setting', 'closable', false)
          .modal('setting', 'autofocus', false)
          .modal('setting', 'transition', 'scale')
          .modal('show'); 
      }
    });
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

  //---------------------VALIDATIONS---------------------------//

  $.fn.form.settings.rules.checkUsername = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
    ({
      async : false,
      url: '/validateUsers',
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
  $.fn.form.settings.rules.checkPass = function(value,checkPass) { 
    if (checkPass == 1) {
      if ($('#addform form').form('get value','password1') != $('#addform form').form('get value','password2')) {
        return false;
      } 
    } else {
      if ($('#editform form').form('get value','password1') != $('#editform form').form('get value','password2')) {
        return false;
      } 
    }
    return true;
  };

  $.fn.form.settings.rules.checkSymbol = function(value) { //-----------duplicate -------------//
    if (value.charAt(0)=="-" || value.charAt(0)=="/" || value.charAt(0)=="(" ||value.charAt(0)==")" || value.charAt(0)=="'" || value.charAt(0)>=0 && value.charAt(0)<=9){
      return false;  
    }
    return true;
  };

  $('#addform form')//--------------------addform validate--------------//
    .form({
      inline : true,
      fields :{
      username: {
        identifier: 'username',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
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
          type   : 'checkUsername',
          prompt : 'Username already taken.'
        }]
      },
      password1: {
        identifier: 'password1',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
      password2: {
        identifier: 'password2',
        rules: [
        {
          type   : 'checkPass[1]',
          prompt : "Password doesn't match."
        }]
      },
      email: {
        identifier: 'email',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'email',
          prompt : 'Enter a valid email address.'
        }]
      },
      disname: {
        identifier: 'disname',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
    }
  });
  $('#editform form')//--------------------addform validate--------------//
    .form({
      inline : true,
      fields :{
      username: {
        identifier: 'username',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
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
          type   : 'checkUsername',
          prompt : 'Username already taken.'
        }]
      },
      password1: {
        identifier: 'password1',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
      password2: {
        identifier: 'password2',
        rules: [
        {
          type   : 'checkPass[2]',
          prompt : "Password doesn't match."
        }]
      },
      email: {
        identifier: 'email',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'email',
          prompt : 'Enter a valid email address.'
        }]
      },
      disname: {
        identifier: 'disname',
        rules: [
        {
          type   : 'empty',
          prompt : 'Cannot be empty.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
    }
  });

  //-------------------Delete Validation----------------------//
  $('button.delbtn').click(function(e) {
    var id = $(this).data('id');
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

  
  $('table').DataTable();
});
