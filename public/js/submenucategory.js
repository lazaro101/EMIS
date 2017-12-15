$(document).ready(function(){

  $.fn.api.settings.api = {
    'retrieve category'   : '/retrieveCategory',
  };

  //---------------------show addctgry button----------------------------//
  $('#addcat').click(function(){
    $('#addctgry')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
    $('#addctgry .ui.form').form('reset');//----------------reset form ------------//
  });

  //---------------------show editctgry button----------------------------//
  $('.editctgry').api({
    action: 'retrieve category',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ID: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(response) {
      response.forEach(function(data) {
        $('#editctgry form')
          .form('set values', {
            categoryId     : data.submenu_category_id,
            categoryName   : data.submenu_category_name,
        });
      }) 
    },
    onComplete: function(response){
      $('#editctgry')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show'); 
    }
  });

  //--------------add button------------------------------//
  $('#addctgry .addbtn').click(function(){
    if ($('#addctgry .ui.form').form('is valid') == false) {
      $('#addctgry .ui.form').form('validate form');
      return false
    }
    return true;
  });
  $('#editctgry .addbtn').click(function(){
    if ($('#editctgry .ui.form').form('is valid') == false) {
      $('#editctgry .ui.form').form('validate form');
      return false
    }
    return true;
  });
  //--------------cancel button------------------------------//
  $('#editctgry .cancelbtn').click(function(){
    $('#editctgry form').form('reset');
  });

  //---------------------VALIDATIONS---------------------------//
  $.fn.form.settings.rules.checkCategory = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
    ({
      async : false,
      url: '/validateCategory',
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

  $('#addctgry .ui.form')//--------------------addctgry validate--------------//
    .form({
      inline : true,
      // on     : 'change',
      fields :{
      categoryName: {
        identifier: 'categoryName',
        rules: [
        {
          type   : 'empty',
          prompt : 'Enter a Category Name.'
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
          type   : 'checkCategory',
          prompt : 'Category Name Already Exists'
        }]
      },
    }
  });
  $('#editctgry .ui.form')//--------------------editctgry validate--------------//
    .form({
      inline : true,
      // on     : 'change',
      fields :{
      categoryName: {
        identifier: 'categoryName',
        rules: [
        {
          type   : 'empty',
          prompt : 'Enter a Category Name.'
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
          type   : 'checkCategory',
          prompt : 'Category Name Already Exists'
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
  $('button.delctgry').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deletectgry').form('set value','id',id);
          $('#deletectgry').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });

});
