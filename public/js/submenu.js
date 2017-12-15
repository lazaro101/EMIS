$(document).ready(function(){

  $('.table-cont.food tbody .checkbox').on('change',function(){
    console.log($(this).checkbox('is checked'));
    var s = 1;
    if ($(this).checkbox('is checked') == true) {
      s = 0;
    }
    $.ajax
    ({
      url: '/changeSubmenuStatus',
      type:'get',
      data: { status:s, id:$(this).find('input').val() },
      dataType : 'json',
    });
  });

  $('.drpdwn').dropdown();

  $('.tabular.menu .item').tab();

  $.fn.api.settings.api = {
    'retrieve submenu' : '/retrieveSubmenu',
  };
  //-----------------------Form Image Preview----------------------//
    $(".addpic").change(function(event){
       var input = $(event.currentTarget);
       var file = input[0].files[0];
       var reader = new FileReader();
       reader.onload = function(e){
           image_base64 = e.target.result;
           $('#addfood img').attr("src", image_base64);
       };
       reader.readAsDataURL(file);
    });
    
    $(".editpic").change(function(event){
       var input = $(event.currentTarget);
       var file = input[0].files[0];
       var reader = new FileReader();
       reader.onload = function(e){
           image_base64 = e.target.result;
           $('#editfood img').attr("src", image_base64);
       };
       reader.readAsDataURL(file);
    });
    $('#addfood .removepic').click(function(){
      $('#addfood img').attr("src", "/image/FoodImages/preview.png");
      $('#addfood form').form('set value','submenuImage','')
    });
    $('#editfood .removepic').click(function(){
      $('#editfood img').attr("src", "/image/FoodImages/preview.png");
      $('#editfood form').form('set value','submenuImage','')
      $('#editfood form').form('set value','tempImage','')
    });

    //---------------------Show addfood----------------------------//
    $('#addsub').click(function(){
      $('#addfood')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    });
    //---------------------Show editfood----------------------------//
    $('.editfood').api({
      action: 'retrieve submenu',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
          $('#editfood form')
            .form('set values', {
              submenuId     : data.submenu_id,
              dupsubmenuName : data.submenu_name,
              submenuName   : data.submenu_name,
              submenuDesc   : data.submenu_description,
              submenuPrice   : data.submenu_price,
              submenuCtgry   : data.submenu_category_id,
              tempImage : data.submenu_img
          });
          $("#editfood img.upimage").attr("src","/image/FoodImages/"+data.submenu_img);
        }) 
      },
      onComplete: function(response) {
        $('#editfood')
          .modal('setting', 'closable', false)
          .modal('setting', 'autofocus', false)
          .modal('setting', 'transition', 'scale')
          .modal('show');
      },
    });

    //--------------form add button------------------------------//
    $('#addfood .addbtn').click(function(){
      if ($('#addfood .ui.form').form('is valid') == false) {
        $('#addfood .ui.form').form('validate form');
        return false
      }
      return true;
    });
    $('#editfood .addbtn').click(function(){
      if ($('#editfood .ui.form').form('is valid') == false) {
        $('#editfood .ui.form').form('validate form');
        return false
      }
      return true;
    });
    //--------------form cancel button------------------------------//
    $('#addfood .cancelbtn').click(function(){
      $('#addfood form').form('reset');
    });
    $('#editfood .cancelbtn').click(function(){
      $('#editfood form').form('reset');
    });

    //---------------------VALIDATIONS---------------------------//

    $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
      var res = true;
      $.ajax
        ({
          async : false,
          url: '/validateSubmenu',
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
      var dup = $('#editfood .ui.form').form('get value','dupsubmenuName');
      if (dup.toLowerCase() == value.toLowerCase()) {
        return true;
      }
      $.ajax
        ({
          async : false,
          url: '/validateSubmenu',
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

    $.fn.form.settings.rules.checkPrice = function(value) { //-----------duplicate -------------//
      if (value >= 1000 || value <= 0) {
        return false;
      }
      else if(value.indexOf(".")>1){
        return false;
      }
      return true;
    };

    $('#addfood .ui.form')//--------------------addfood validate--------------//
      .form({
        inline : true,
        fields :{
          submenuName: {
            identifier: 'submenuName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Enter a Food Name.'
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
              prompt : 'Category Name Already Exists'
            }]
          },
          submenuDesc: {
            identifier: 'submenuDesc',
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
          },
          submenuCtgry: {
            identifier: 'submenuCtgry',
            rules: [
            {
              type   : 'empty',
              prompt : 'Select a category'
            }]
          },
          submenuPrice: {
            identifier: 'submenuPrice',
            rules: [
             {
              type: 'checkPrice',
              prompt: 'Invalid Price'
            },
            {
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'decimal',
              prompt: 'Enter valid price'
            }
           ]
          },
        }
    });
    $('#editfood .ui.form')//--------------------editfood validate--------------//
      .form({
        inline : true,
        fields :{
          submenuName: {
            identifier: 'submenuName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Enter a Food Name.'
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
              prompt : 'Category Name Already Exists'
            }]
          },
          submenuDesc: {
            identifier: 'submenuDesc',
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
          },
          submenuCtgry: {
            identifier: 'submenuCtgry',
            rules: [
            {
              type   : 'empty',
              prompt : 'Select a category'
            }]
          },
          submenuPrice: {
            identifier: 'submenuPrice',
            rules: [{
              type: 'empty',
              prompt: 'Cannot be Empty'
            },
            {
              type: 'decimal',
              prompt: 'Enter valid price'
            },
            {
              type: 'checkPrice',
              prompt: 'Invalid Price'
            }]
          },
        }
    });

  //-------------------Delete Validation----------------------//
  $('button.delfood').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deletefood').form('set value','id',id);
          $('#deletefood').submit();
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
 
});//--------------document.ready--------------//
